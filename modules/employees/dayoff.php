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
		case 'addForm':
			if(!isset($_POST['depID'])){
				$getDepartments = $db->select('select * from emp_departments order by fatherId ASC');
				
				$countDep = count($getDepartments);
				for($i=0;$i<$countDep;$i++){
					$getEmps = $db->CQuery('select count(id) from emp_personal_info where dep_id ='.$db->sqlsafe($getDepartments[$i]['id']).'');
					if($getEmps > 0){
						$departments['Departments'][$getDepartments[$i]['id']]=getPath('emp_departments',
																$getDepartments[$i]['id'],
																$getDepartments[$i]['fatherId']);					
					}
				}
				if(!is_array($departments)){
			 		$skin = new skin();
			 		$skin->assign('errorMSG','Sorry , There is no departments with valid number of employee, you may have departments but with no employee inside.');
				 	$skin->assign('config',$config);
				 	$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
				 	$skin->display('site/index.tpl');					
				}else{
					$skin = new skin();
					$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('act','addForm');
					$skin->assign('departments',$departments);
					$skin->assign('incFile','site/emp/dayOff_first.tpl');
					$skin->display('site/index.tpl');				
				}
			}else{
				$depId = $db->sqlsafe($_POST['depID']);
				$getAllEmployees = $db->select('select id , name  from emp_personal_info where active='.$active.' and dep_id ='.$depId.' ');
				if(is_array($getAllEmployees)){
					$countEmp = count($getAllEmployees);
					for($i=0;$i<$countEmp ; $i++){
						$employees['Employees'][$getAllEmployees[$i]['id']]=$getAllEmployees[$i]['name'];
					}

					$skin = new skin();
					$skin->assign('config',$config);
					$skin->assign('employee',$employees);
					$skin->assign('act','add');
					$skin->display('site/emp/dayOff_second.tpl');
				}else{
					echo '<div class="error">Sorry there is no employees in the choosen department</div>';
				}

			}
			break;
		case 'add':
			if( empty($_POST['startDate']) OR empty($_POST['endDate']) OR !isset($_POST['depID']) OR !isset($_POST['empID']) ){
				header('location: '.$config['url'].'/module.php?act=load&modload=employees&file=dayoff&action=addForm&error=1');
			}else{
				if(!isset($_POST['paid'])){
					$paid = 0;
				}else{
					$paid = $_POST['paid'];
				}
				$record = array(
					"emp_id"=>$db->sqlsafe($_POST['empID']),
					"dep_id"=>$db->sqlsafe($_POST['depID']),
					"start_date"=>$db->sqlsafe($_POST['startDate']),
					"end_date"=>$db->sqlsafe($_POST['endDate']),
					"paid"=>$db->sqlsafe($paid)
				);
				$insert = $db->insert('emp_dayoff',$record);
				if($insert){
					header('location: '.$config['url'].'/module.php?act=load&modload=employees&file=dayoff&action=addForm&error=3');
				}else{
					header('location: '.$config['url'].'/module.php?act=load&modload=employees&file=dayoff&action=addForm&error=2');
				}
			}
			break;
		default:
			header('location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee');
	}
?>