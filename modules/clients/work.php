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
			header('location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&error=1');
		}else{
			$record = array("work_type"=>$db->sqlsafe($_POST['title']));
			$insert = $db->insert('work_area',$record);
			if($_POST['ajax'] != 1){
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&error=1');
				}
			}else{
		 		$getAllAreas=$db->select('select * from work_area order by id ASC ');
		 		$skin = new skin();
		 		$skin->assign('config',$config);
				$skin->assign('work',$getAllAreas);
			 	$skin->display('site/client/allworkfeilds.tpl');
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
		 			"work_type"=>$db->sqlSafe($_POST['value'])
		 		);

		 		$update = $db->update('work_area',$record,'id = '.$id.'');
		 		if($update){
		 			$getRecord = $db->select('select work_type as name from work_area where id ='.$id.' limit 0,1');
		 			$returend_value = $getRecord[0]['name'];
		 		}else{
					$returend_value='Error : no data has been modified..';
		 		}
		 	}
		 	echo $returend_value;
		break;

		case 'delete':
				if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&error=2');
			}else{
				$workId = $db->sqlsafe($_GET['id']);
				$getCln = $db->CQuery('select count(id) from client_info where workId='.$workId.'');
				if($getCln == 0){
					$delete = $db->delete('work_area','id ='.$workId.'');
					if($delete){
						header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&done=1');
					}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&error=1');
					}
				}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=work&error=3');
				}
			}
		break;

		default:
	 		$getAllAreas=$db->select('select * from work_area order by id ASC ');

	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('work',$getAllAreas);
			$skin->assign('incFile','site/client/workfeilds.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}

?>