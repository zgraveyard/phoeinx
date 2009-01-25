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
			header('location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&error=1');
		}else{
			$record = array("name"=>$db->sqlsafe($_POST['title']));
			$insert = $db->insert('emp_positions',$record);
			if($_POST['ajax'] != 1){
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&error=1');
				}
			}else{
		 		$getAllPositions=$db->select('select * from emp_positions order by id ASC ');
		 		$skin = new skin();
		 		$skin->assign('config',$config);
				$skin->assign('positions',$getAllPositions);
				$skin->clear_cache('site/index.tpl');
			 	$skin->display('site/emp/allpositions.tpl');
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

		 		$update = $db->update('emp_positions',$record,'id = '.$id.'');
		 		if($update){
		 			$getRecord = $db->select('select name from emp_positions where id ='.$id.' limit 0,1');
		 			$returend_value = $getRecord[0]['name'];
		 		}else{
					$returend_value='Error : no data has been modified..';
		 		}
		 	}
		 	echo $returend_value;
		break;

		case 'delete':
				if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&error=2');
			}else{
				$posId = $db->sqlsafe($_GET['id']);
				$getEmp = $db->CQuery('select count(id) from emp_personal_info where pos_id='.$posId.'');
				if($getEmp == 0){
					$delete = $db->delete('emp_positions','id ='.$posId.'');
					if($delete){
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&done=1');
					}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&error=1');
					}
				}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=position&error=3');
				}
			}
		break;

		default:
	 		$getAllPositions=$db->select('select * from emp_positions order by id ASC ');

	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('positions',$getAllPositions);
			$skin->assign('incFile','site/emp/positions.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}

?>