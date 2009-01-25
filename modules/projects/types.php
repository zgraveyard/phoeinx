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
	if(!preg_match("/\bmodule.php\b/i", $_SERVER['PHP_SELF'])){
		die('you cant use this file directoly');
	}
	isLogin();
	$act = isset($_GET['action']) ? treatGet($_GET['action']):treatGet($_POST['action']);
	$page = isset($_GET['pager']) ? treatGet($_GET['pager']):treatGet($_POST['pager']);
	$active = $db->sqlsafe('1');
	switch ($act) {
		case 'add':
		if(empty($_POST['title'])){
			header('location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&error=1');
		}else{
			$record = array("name"=>$db->sqlsafe($_POST['title']));
			$insert = $db->insert('projects_type',$record);
			if($_POST['ajax'] != 1){
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&error=1');
				}
			}else{
		 		$getAllTypes=$db->select('select * from projects_type order by id ASC ');
		 		$skin = new skin();
		 		$skin->assign('config',$config);
				$skin->assign('types',$getAllTypes);
			 	$skin->display('site/projects/alltypes.tpl');
			}
		}
		break;

		case 'save':
			$returend_value='';
		 	if(empty($_POST['value'])){
				$returend_value='Error : no data has been modified..';
		 	}else{
		 		$id=$db->sqlSafe($_GET['id']);
		 		$record = array(
		 			"name"=>$db->sqlSafe($_POST['value'])
		 		);

		 		$update = $db->update('projects_type',$record,'id = '.$id.'');
		 		if($update){
		 			$getRecord = $db->select('select name from projects_type where id ='.$id.' limit 0,1');
		 			$returend_value = $getRecord[0]['name'];
		 		}else{
					$returend_value='Error : no data has been modified..';
		 		}
		 	}
		 	echo $returend_value;
		break;

		case 'delete':
				if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&error=2');
			}else{
				$typeId = $db->sqlsafe($_GET['id']);
				$getType = $db->CQuery('select count(id) from projects_info where type_id='.$typeId.'');
				if($getType == 0){
					$delete = $db->delete('projects_type','id ='.$typeId.'');
					if($delete){
						header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&done=1');
					}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&error=1');
					}
				}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=types&error=3');
				}
			}
		break;

		default:
	 		$getAllTypes=$db->select('select * from projects_type order by id ASC ');
	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('types',$getAllTypes);
			$skin->assign('incFile','site/projects/types.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}

?>