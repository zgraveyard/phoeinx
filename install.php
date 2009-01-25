<?php
###################################
# Copyright (c) 2008 Mhd Zahere Ghaibeh and others.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU GPL v2.0
# which accompanies this distribution, and is available at
# http://www.GNU.org
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#
##################################
session_start();
	require_once('lib/php/functions/general.php');
	$act = isset($_GET['action']) ? treatGet($_GET['action']):treatGet($_POST['action']);
	switch($act){
		case'start':
			echo '
				<p>Please fill the required information below :</p>
				<form name="" action="install.php" method="post">
				<p><label>Program Directory : <input type="text" name="directory">&nbsp; With the " / " at the begining of the directory name.</label></p>
				<p><label>Database server : <input type="text" name="server"></label></p>
				<p><label>Database user : <input type="text" name="user"></label></p>
				<p><label>Database passowrd : <input type="text" name="password"></label></p>
				<p><label>Database Name : <input type="text" name="dbname"></label></p>
				<p><label><input type="submit"></label></p>
				<input type="hidden" name="action" value="create">
				</form>
			';
			break;
		case'create':
			if(empty($_POST['server']) OR empty($_POST['user']) OR empty($_POST['dbname']) ){
				echo 'as we said fill all the information <a href="install.php?start">back</a>';
			}else{
				$connect = mysql_connect($_POST['server'],$_POST['user'],$_POST['password']);
				if($connect){
					$_SESSION['connect'] =$_POST;
					if (is_writable('config.php')){
						$handle = fopen("config.php", "w");
						$data="
<?php
###################################
# Copyright (c) 2008 Mhd Zahere Ghaibeh and others.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU GPL v2.0
# which accompanies this distribution, and is available at
# http://www.GNU.org
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#
##################################
 	define('ABSPATH',\$_SERVER['DOCUMENT_ROOT'].'".$_SESSION['connect']['directory']."');
	require_once(ABSPATH.'/lib/php/classes/db.class.php');
	require_once(ABSPATH.'/lib/php/classes/BURAK_Gantt.class.php');
	require_once(ABSPATH.'/lib/php/functions/general.php');
    global \$config;
	\$dbname='".$_SESSION['connect']['dbname']."';
	\$dbuser='".$_SESSION['connect']['user']."';
	\$dbserver='".$_SESSION['connect']['server']."';
	\$dbpass='".$_SESSION['connect']['password']."';
	\$db = new db();
	\$db->connect(\$dbname,\$dbserver,\$dbuser,\$dbpass);

	\$settings = getSettings();

	\$config['dir']=ABSPATH;
	\$config['url']=\$settings['url'];
	\$config['title']=\$settings['sitename'];
	\$config['curency']=\$settings['curency'];
	\$config['perPage']=\$settings['perPage'];
	\$config['theme']=\$settings['theme'];
	\$config['gantType']=1; // you can use 1 for days or 2 for weeks  or 3 for moths

	require_once(\$config['dir'].'/lib/php/smarty/Smarty.class.php');
	class skin extends Smarty{
		function skin(){
			global \$config;
			\$this->Smarty();
			\$this->template_dir =\$config['dir'].'/themes/'.\$config['theme'].'/';
			\$this->compile_dir  =\$config['dir'].'/themes/'.\$config['theme'].'/temp';
			\$this->config_dir   =\$config['dir'].'/themes/'.\$config['theme'].'/config/';
			\$this->load_filter('output','move_to_head');
		}
	}
session_start();
?>";
						fwrite($handle, $data);
						fclose($handle);
						echo 'We are done now lets go to the next step <a href="install.php?action=sql1">Create Db</a>';
					}else{
						echo 'the file db.connection.php is not writable';
					}
				}else{
					echo 'we couldont connect to the database server .. start a gain <a href="install.php?action=start">Start</a>';
				}
			}
			break;
		case 'sql1':
				$connect = mysql_connect($_SESSION['connect']['server'],$_SESSION['connect']['user'],$_SESSION['connect']['password']);
				$sql = 'CREATE DATABASE '.$_SESSION['connect']['dbname'];
				if(mysql_query($sql,$connect)){
					echo 'Database has been created lets imports some data first ..<a href="install.php?action=import">Import</a>';
				}else{
					echo 'We couldnt create the db , make sure that everything is okay ..<a href="install.php?action=sql1">Create Db</a>';
				}
			break;
		case 'import':
				require_once('lib/php/classes/db.class.php');
				$db = new db;
				$db->connect($_SESSION['connect']['dbname'],$_SESSION['connect']['server'],$_SESSION['connect']['user'],$_SESSION['connect']['password']);
				$dbcreate = file_get_contents('dbFiles/mysql.sql') ;
				$dbs = explode(";",$dbcreate);
				foreach($dbs as $query){
					$query = trim($query);
					if($query){
						@mysql_query($query)or mysql_error();
					}
				}
			echo 'We Have Created your db now lets Populate some data inside .. <a href="install.php?action=import2">final</a>';
			break;
		case 'import2':
				require_once('lib/php/classes/db.class.php');
				$db = new db;
				$db->connect($_SESSION['connect']['dbname'],$_SESSION['connect']['server'],$_SESSION['connect']['user'],$_SESSION['connect']['password']);

				$recordSettings = array(
					"id"=>$db->sqlsafe('1'),
					"url"=>$db->sqlsafe('http://'.$_SERVER['HTTP_HOST'].$_SESSION['connect']['directory'].''),
					"sitename"=>$db->sqlsafe('My Simple Project Management System'),
					"theme"=>$db->sqlsafe('default'),
					"perPage"=>$db->sqlsafe('10'),
					"curency"=>$db->sqlsafe('$')
				);
				$insertSettings = $db->insert('settings',$recordSettings);
				$dbcreate = file_get_contents('dbFiles/insert.sql') ;
				$dbs = explode(";",$dbcreate);
				foreach($dbs as $query){
					$query = trim($query);
					if($query){
						@mysql_query($query)or mysql_error();
					}
				}
				if(@unlink('install.php')){
					echo 'We Have Finished.<br /> now you have to make sure that the cache & the theme temp directory are writables ( 775 or 777 ).';
				}else{
					echo 'We Have Finished , you have to delete the install.php file.<br /> now you have to make sure that the cache & the theme temp directory are writables ( 775 or 777 ).';
				}
			break;
		default:
			echo 'The Installation will start now .. , all you have to do is just relax and press';
			echo '&nbsp;<a href="install.php?action=start">start</a>';
	}
?>
