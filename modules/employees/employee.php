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
	$gender['Gender'][1]='Male';
	$gender['Gender'][0]='Female';

	switch ($act) {
		case 'new':
			include_once('functions.php');
			$departmentNumber = getDepNumber();
			if($departmentNumber > 0 ){
				$positionsNumber = getPosNumber();
				if( $positionsNumber > 0){
					$getDepartments = $db->select('select * from emp_departments order by fatherId ASC');
					$countDep = count($getDepartments);
					for($i=0;$i<$countDep;$i++){
						$departments['Departments'][$getDepartments[$i]['id']]=getPath('emp_departments',
																$getDepartments[$i]['id'],
																$getDepartments[$i]['fatherId']);
					}

					$getPositions = $db->select('select * from emp_positions order by id ASC');
					$countPos = count($getPositions);
					for($i=0;$i<$countPos ;$i++){
						$position['Work Posoitions'][$getPositions[$i]['id']]=$getPositions[$i]['name'];
					}

					$getCountries = $db->select('select ci , cn from cc order by cn ASC');
					$countCountry = count($getCountries);
					for($i=0;$i<$countCountry;$i++){
						$country['Nationality'][$getCountries[$i]['ci']] = $getCountries[$i]['cn'];
					}
					if($_POST['ajax'] != 1){
				 		$skin = new skin();
				 		$skin->assign('country',$country);
						$skin->assign('departments',$departments);
						$skin->assign('pos_id',$position);
				 		$skin->assign('action','add');
					 	$skin->assign('config',$config);
					 	$skin->assign('gender',$gender);
						$skin->assign('showMenu','1');
						$skin->assign('incFile','site/emp/employeeForm.tpl');
					 	$skin->display('site/index.tpl');
					}elseif($_POST['ajax'] == 1){
				 		$skin = new skin();
				 		$skin->assign('country',$country);
						$skin->assign('departments',$departments);
						$skin->assign('pos_id',$position);
				 		$skin->assign('action','add');
					 	$skin->assign('config',$config);
					 	$skin->assign('gender',$gender);
					 	$skin->assign('showClose','1');
						$skin->display('site/emp/employeeForm.tpl');
					}
				}elseif($positionsNumber == 0){
			 		$skin = new skin();
			 		$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=employees&file=position">new work position</a> before start adding an employee');
				 	$skin->assign('config',$config);
				 	$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
				 	$skin->display('site/index.tpl');
				}
			}elseif($departmentNumber == 0 ){
			 		$skin = new skin();
			 		$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=employees&file=department&action=new">new department</a> before start adding an employee');
				 	$skin->assign('config',$config);
				 	$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
				 	$skin->display('site/index.tpl');
			}
		break;

		case 'add':
			if(empty($_POST['ename']) OR !isset($_POST['ci']) OR empty($_POST['certificate']) OR empty($_POST['experince'] )
			OR !isset($_POST['dep_id']) OR empty($_POST['eaddress']) ) {
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&action=new&error=1');
			}else{
				$record = array(
					"name"=>$db->sqlsafe($_POST['ename']),
					"gender"=>$db->sqlsafe($_POST['gender']),
					"birth_date"=>$db->sqlsafe($_POST['Date_Year']),
					"certificate"=>$db->sqlsafe($_POST['certificate']),
					"experince"=>$db->sqlsafe($_POST['experince']),
					"mobile"=>$db->sqlsafe($_POST['emobile']),
					"address"=>$db->sqlsafe($_POST['eaddress']),
					"phone"=>$db->sqlsafe($_POST['ephone']),
					"dep_id"=>$db->sqlsafe($_POST['dep_id']),
					"pos_id"=>$db->sqlsafe($_POST['pos_id']),
					"nationality"=>$db->sqlsafe($_POST['ci'])
				);
				$insert = $db->insert('emp_personal_info',$record);
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&action=new&error=2');
				}
			}
			break;

		case 'editForm':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
			}else{
				$empId = $db->sqlSafe($_GET['id']);
				$getEmp = $db->select('select * from emp_personal_info where id='.$empId.'');
				if(!is_array($getEmp)){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
				}else{
					$getDepartments = $db->select('select * from emp_departments order by fatherId ASC');
					$countDep = count($getDepartments);
					for($i=0;$i<$countDep;$i++){
						$departments['Departments'][$getDepartments[$i]['id']]=getPath('emp_departments',
																$getDepartments[$i]['id'],
																$getDepartments[$i]['fatherId']);
					}

					$getPositions = $db->select('select * from emp_positions order by id ASC');
					$countPos = count($getPositions);
					for($i=0;$i<$countPos ;$i++){
						$position['Work Posoitions'][$getPositions[$i]['id']]=$getPositions[$i]['name'];
					}

					$getCountries = $db->select('select ci , cn from cc order by cn ASC');
					$countCountry = count($getCountries);
					for($i=0;$i<$countCountry;$i++){
						$country['Nationality'][$getCountries[$i]['ci']] = $getCountries[$i]['cn'];
					}
					if($_POST['ajax'] != 1){
			 			$skin = new skin();
			 			$skin->assign('gender',$gender);
			 			$skin->assign('country',$country);
						$skin->assign('departments',$departments);
						$skin->assign('pos_id',$position);
						$skin->assign('info',$getEmp[0]);
			 			$skin->assign('action','edit');
				 		$skin->assign('config',$config);
						$skin->assign('showMenu','1');
						$skin->assign('incFile','site/emp/employeeForm.tpl');
				 		$skin->display('site/index.tpl');
					}elseif($_POST['ajax'] == 1){
			 			$skin = new skin();
			 			$skin->assign('gender',$gender);
			 			$skin->assign('country',$country);
						$skin->assign('departments',$departments);
						$skin->assign('pos_id',$position);
						$skin->assign('info',$getEmp[0]);
			 			$skin->assign('action','edit');
				 		$skin->assign('config',$config);
						$skin->assign('showClose','1');
						$skin->display('site/emp/employeeForm.tpl');
					}
				}
			}
			break;

		case 'edit':
			if(!isset($_POST['empId']) OR empty($_POST['ename']) OR !isset($_POST['ci'])
			OR empty($_POST['certificate']) OR empty($_POST['experince'] )
			OR !isset($_POST['dep_id']) OR empty($_POST['eaddress']) ) {
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=1');
			}else{
				$id = $db->sqlsafe($_POST['empId']);
				$record = array(
					"name"=>$db->sqlsafe($_POST['ename']),
					"gender"=>$db->sqlsafe($_POST['gender']),
					"birth_date"=>$db->sqlsafe($_POST['Date_Year']),
					"certificate"=>$db->sqlsafe($_POST['certificate']),
					"experince"=>$db->sqlsafe($_POST['experince']),
					"mobile"=>$db->sqlsafe($_POST['emobile']),
					"address"=>$db->sqlsafe($_POST['eaddress']),
					"phone"=>$db->sqlsafe($_POST['ephone']),
					"dep_id"=>$db->sqlsafe($_POST['dep_id']),
					"pos_id"=>$db->sqlsafe($_POST['pos_id']),
					"nationality"=>$db->sqlsafe($_POST['ci'])
				);
				$update = $db->update('emp_personal_info', $record ,'id = '.$id.'');
				if($update){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
				}
			}
			break;

		case'active':
			if(!isset($_GET['id']) OR !isset($_GET['status'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
			}else{
				$empId = $db->sqlsafe($_GET['id']);
				if($_GET['status'] == 0){
					$active = $db->sqlsafe('1');
				}elseif($_GET['status'] == 1){
					$active = $db->sqlsafe('0');
				}
				$record = array( "active"=>$active );
				$update = $db->update('emp_personal_info', $record ,'id = '.$empId.'');
				if($update){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
				}
			}
			break;

		case 'delete':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
			}else{
				$empId = $db->sqlsafe($_GET['id']);
				$getEmp = $db->CQuery('select count(id) from emp_personal_info where id='.$empId.'');
				$getEmpTask = $db->CQuery('select count(info.id) from tasks_info as info ' .
										  'inner join tasks_emp as emp on info.id = emp.task_id ' .
										  'where emp.emp_id='.$empId.' and info.status_id = '.$db->sqlsafe('3').'');
				if($getEmp == 1 && $getEmpTask == 0 ){
					$delete = $db->delete('emp_personal_info','id ='.$empId.'');
					if($delete){
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&done=1');
					}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=1');
					}
				}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=1');
				}
			}
			break;

		case 'empInfo':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=employee&error=2');
			}else{

				$empId = $db->sqlsafe($_GET['id']);

				$getEmp = $db->select('select info.* , dep.name as depname , cc.* ,dep.id as depId, dep.fatherId as fatherID,
					pos.name as posName from emp_personal_info as info
					inner join emp_departments as dep on info.dep_id = dep.id
					inner join cc on cc.ci=info.nationality
					inner join emp_positions as pos on pos.id = info.pos_id
					where info.id='.$empId.' ');

				$getEmp[0]['depname']=getPath('emp_departments',$getEmp[0]['depId'],$getEmp[0]['fatherID']);
				if($_POST['ajax'] == 1){
					$skin = new skin();
					$skin->assign('info',$getEmp[0]);
				 	$skin->assign('config',$config);
				 	$skin->assign('showClose','1');
				 	$skin->display('site/emp/employee.tpl');
				}else{
					$skin = new skin();
					$skin->assign('info',$getEmp[0]);
				 	$skin->assign('config',$config);
				 	$skin->assign('incFile','site/emp/employee.tpl');
					$skin->assign('showMenu','1');
				 	$skin->display('site/index.tpl');
				}

			}
			break;

		default:
	 		$geCount = $db->CQuery('select count(id) from emp_personal_info');
			$nav = $db->getNav($geCount,$config['perPage']);
	 		$getAllEmployees =$db->select('select info.id as id , info.name as empName , dep.id as depId , dep.fatherId as fatherID,
	 			dep.name as depName, info.active as active from emp_personal_info as info inner join emp_departments as dep
	 			on dep.id = info.dep_id order by id ASC ',$page,$config['perPage']);

			$countDep = count($getAllEmployees);
			for($i=0;$i<$countDep;$i++){
				$getAllEmployees[$i]['depName']=getPath('emp_departments',$getAllEmployees[$i]['depId'],$getAllEmployees[$i]['fatherID']);
			}
	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('nav',$nav);
			$skin->assign('employees',$getAllEmployees);
			$skin->assign('incFile','site/emp/employees.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}
?>