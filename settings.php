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
	include_once('config.php');
	isLogin();
	$act = (isset($_GET['act'])) ? treatGet($_GET['act']) : treatGet($_POST['act']);
	$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
	switch ($act) {
		case 'save':
			if( empty($_POST['sitename']) OR empty($_POST['url']) OR empty($_POST['curency']) OR !isset($_POST['perPage'])){
				header('location: settings.php?error=1');
			}else{
				$record = array(
					"sitename"=>$db->sqlsafe($_POST['sitename']),
					"url"=>$db->sqlsafe($_POST['url']),
					"theme"=>$db->sqlsafe($_POST['theme']),
					"perPage"=>$db->sqlsafe($_POST['perPage']),
					"curency"=>$db->sqlsafe($_POST['curency'])
				);
				$update = $db->update('settings',$record,'id ='.$db->sqlsafe($_POST['id']).'');
				if($update){

					$recordEemail = array(
						"email"=>$db->sqlsafe($_POST['email'])
					);
					$update = $db->update('admin',$recordEemail,'id='.$db->sqlsafe($_SESSION['login']['id']).'');
					header('location: settings.php?error=2');
				}else{
					header('location: settings.php?error=3');
				}
			}
			break;

		default:
			$themes['Theme'] = getThemes(ABSPATH.'/themes/');
			$getAdminEmail = $db->select('select email from admin where id='.$db->sqlsafe($_SESSION['login']['id']).'');

			$skin = new skin();
			$skin->assign('showMenu','1');
			$skin->assign('config',$config);
			$skin->assign('act','save');
			$skin->assign('email',$getAdminEmail[0]['email']);
	 		$skin->assign('info',$settings);
	 		$skin->assign('theme',$themes);
	 		$skin->assign('incFile','site/settings.tpl');
	 		$skin->display('site/index.tpl');
			break;
	}
?>
