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
	$statusVars = array('Pending','Working','Finished');
	$relationName = array('SS', 'EE', 'ES');
	for($i=1;$i<4;$i++){
		$status['Status'][$i]=$statusVars[$i-1];
	}
	require_once('functions.php');
	switch ($act) {
		case 'new':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$proID = $db->sqlsafe($_GET['id']);
				$getProjectInfo = $db->select('select info.id , info.name , info.dep_id , dep.name as depName , ' .
											  'type.name as typeName,cinfo.company as cName , cinfo.id as cId ' .
											  'from projects_info as info ' .
											  'inner join projects_type as type on type.id = info.type_id ' .
											  'inner join emp_departments as dep on info.dep_id = dep.id ' .
											  'inner join client_info as cinfo on info.client_id = cinfo.id ' .
											  'where info.id='.$proID.' limit 0,1');

				$getEmployees = $db->select('select id , name from emp_personal_info ' .
											'where dep_id IN ('.getSons($getProjectInfo[0]['dep_id']).') AND active='.$active.' ' .
											'order By id ASC');
				$countEmp = count($getEmployees);
				for($i=0;$i<$countEmp;$i++){
					$getOffEmp = $db->select('select emp.name , dep.name as depName , off.start_date , off.end_date ' .
											 'from emp_personal_info as emp ' .
											 'inner join emp_departments as dep on emp.dep_id = dep.id ' .
											 'inner join emp_dayoff as off on emp.id = off.emp_id ' .
											 'Where emp.id = '.$db->sqlsafe($getEmployees[$i]['id']).'');
					$emp['Employees'][$getEmployees[$i]['id']]=$getEmployees[$i]['name'];
				}

		 		$skin = new skin();
			 	$skin->assign('config',$config);
				$skin->assign('showMenu','1');
				$skin->assign('action','add');
				$skin->assign('status',$status);
				$skin->assign('employee',$emp);
				$skin->assign('dayOff',$getOffEmp);
				$skin->assign('project',$getProjectInfo[0]);
				$skin->assign('incFile','site/projects/taskForm.tpl');
			 	$skin->display('site/index.tpl');

			}
		break;

		case 'add':
			if(empty($_POST['tName']) OR !isset($_POST['pId']) OR !isset($_POST['progress'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$chek = checkDates($_POST['pId'],$_POST['startDate'],$_POST['endDate']);
				if($chek['done'] == 1){
					$record = array(
						"project_id" =>$db->sqlsafe($_POST['pId']),
						"name" =>$db->sqlsafe($_POST['tName']),
						"description" =>$db->sqlsafe($_POST['note']),
						"start_date" =>$db->sqlsafe($_POST['startDate']),
						"end_date" =>$db->sqlsafe($_POST['endDate']),
						"status_id" =>$db->sqlsafe($_POST['tStatus']),
						"progress"=>$db->sqlsafe($_POST['progress'])
					);
					$insert = $db->insert('tasks_info',$record);
					if($insert){
						$id = mysql_insert_id();
						foreach($_POST['employee'] as $key=>$value){
							$empRecord = array(
								"task_id" =>$db->sqlsafe($id),
								"emp_id" =>$db->sqlsafe($value)
							);
							$insert = $db->insert('tasks_emp',$empRecord);
						}
						header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&done=1');
					}else{
						header('Location: '.$_SERVER['HTTP_REFERER'].'&error=2');
					}				
				}elseif($chek['done'] == 0){
					$skin = new skin();
					$skin->assign('errorMSG',$chek['msg']);
					$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
					$skin->display('site/index.tpl');				
				}
			}
			break;

		case 'delete':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$tId = $db->sqlsafe($_GET['id']);
				$delete = $db->delete('tasks_info','id ='.$tId.'');
				if($delete){
					$delete = $db->delete('tasks_notes','task_id ='.$tId.'');
					$delete = $db->delete('tasks_emp','task_id ='.$tId.'');
					$delete = $db->delete('tasks_relations','task_id_2 ='.$tId.'');
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&done=1');
				}else{
					header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
				}
			}
			break;

		case 'view':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$pId = $db->sqlsafe($_GET['id']);
	 			$geCount = $db->CQuery('select count(id) from tasks_info where project_id='.$pId.'');
				$nav =$db->getNav($geCount,$config['perPage']);

				$project_tasks = $db->select('select t.id , t.name , t.start_date , t.end_date
								,t.`description` , pInfo.name as proName , pInfo.id as pId, t.status_id
				 				from tasks_info as t inner join projects_info as pInfo on pInfo.id=t.project_id
								where t.project_id ='.$pId.' Order by t.start_date DESC',$page,$config['perPage']);

		 		$skin = new skin();
			 	$skin->assign('config',$config);
				$skin->assign('showMenu','1');
				$skin->assign('nav',$nav);
				$skin->assign('tasks',$project_tasks);
				$skin->assign('incFile','site/projects/tasks.tpl');
			 	$skin->display('site/index.tpl');
			}
			break;
		case 'viewEmp':

			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$tId = $db->sqlsafe($_GET['id']);
				$getEmp = $db->select('select emp.name ,emp.id , t.id as tId,  dep.name as depName , dep.id as depId , dep.fatherId ' .
						'from emp_personal_info as emp ' .
						'inner join tasks_emp as t on emp.id = t.emp_id ' .
						'inner join emp_departments as dep on emp.dep_id = dep.id ' .
						'where t.task_id = '.$tId.'');
				$countEmp = count($getEmp);
				for($i=0;$i<$countEmp;$i++){
					$getEmp[$i]['depName']=getPath('emp_departments',$getEmp[$i]['depId'],$getEmp[$i]['fatherId']);
				}

				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('emp',$getEmp);
				 	$skin->assign('showClose','1');
				 	$skin->display('site/projects/taskEmp.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
				 	$skin->assign('emp',$getEmp);
				 	$skin->display('site/projects/taskEmp.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		case 'delEmp':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=2');
			}else{
				$id = $db->sqlsafe($_GET['id']);
				$delete = $db->delete('tasks_emp','id='.$id.'');
				if($delete){
					echo 1;
				}else{
					echo 'There was a Problem while we try to remove this employee .';
				}
			}
			break;

		case 'editForm':
				if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$taskId = $db->sqlsafe($_GET['id']);
				$getTaskInfo = $db->select('select * from tasks_info where id='.$taskId.'');
				$getProjectInfo = $db->select('select info.id , info.name , info.dep_id , dep.name as depName , ' .
											  'type.name as typeName,cinfo.company as cName , cinfo.id as cId ' .
											  'from projects_info as info ' .
											  'inner join projects_type as type on type.id = info.type_id ' .
											  'inner join emp_departments as dep on info.dep_id = dep.id ' .
											  'inner join client_info as cinfo on info.client_id = cinfo.id ' .
											  'where info.id='.$getTaskInfo[0]['project_id'] .' limit 0,1');
				$getEmployees = $db->select('select id , name from emp_personal_info ' .
											'where dep_id IN ('.getSons($getProjectInfo[0]['dep_id']).') AND active='.$active.' ' .
											'order By id ASC');
				$countEmp = count($getEmployees);
				for($i=0;$i<$countEmp;$i++){
					$getOffEmp = $db->select('select emp.name , dep.name as depName , off.start_date , off.end_date ' .
											 'from emp_personal_info as emp ' .
											 'inner join emp_departments as dep on emp.dep_id = dep.id ' .
											 'inner join emp_dayoff as off on emp.id = off.emp_id ' .
											 'Where emp.id = '.$db->sqlsafe($getEmployees[$i]['id']).'');
					$emp['Employees'][$getEmployees[$i]['id']]=$getEmployees[$i]['name'];
				}

				$getTaskEmp = $db->select('select emp_id from tasks_emp where task_id='.$taskId.'');
				$countTaskEmp = count($getTaskEmp);
				for($i=0;$i<$countTaskEmp;$i++){
					$getEmpTask[$i]=$getTaskEmp[$i]['emp_id'];
				}

		 		$skin = new skin();
			 	$skin->assign('config',$config);
				$skin->assign('showMenu','1');
				$skin->assign('action','edit');
				$skin->assign('info',$getTaskInfo[0]);
				$skin->assign('status',$status);
				$skin->assign('employee',$emp);
				$skin->assign('tty',$getEmpTask);
				$skin->assign('dayOff',$getOffEmp);
				$skin->assign('project',$getProjectInfo[0]);
				$skin->assign('incFile','site/projects/taskForm.tpl');
			 	$skin->display('site/index.tpl');
			}
			break;

		case 'edit':
			if(empty($_POST['tName']) OR !isset($_POST['pId']) OR !isset($_POST['tId']) ){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$taskID = $db->sqlsafe($_POST['tId']);
				$record = array(
					"project_id" =>$db->sqlsafe($_POST['pId']),
					"name" =>$db->sqlsafe($_POST['tName']),
					"description" =>$db->sqlsafe($_POST['note']),
					"start_date" =>$db->sqlsafe($_POST['startDate']),
					"end_date" =>$db->sqlsafe($_POST['endDate']),
					"status_id" =>$db->sqlsafe($_POST['tStatus']),
					"progress"=>$db->sqlsafe($_POST['progress'])
				);

				$insert = $db->update('tasks_info',$record,'id = '.$taskID.'');
				if($insert){
					$delete= $db->delete('tasks_emp','task_id='.$taskID.'');
					foreach($_POST['employee'] as $key=>$value){
						$empRecord = array(
							"task_id" =>$taskID,
							"emp_id" =>$db->sqlsafe($value)
						);
						$insert = $db->insert('tasks_emp',$empRecord);
					}
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=tasks&action=view&id='.$_POST['pId']);
				}else{
					header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
				}
			}
			break;

		case 'addNote':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('showClose','1');
				 	$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
				 	$skin->display('site/projects/noteForm.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
					$skin->assign('incFile','site/projects/noteForm.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		case'anote':
			if(!isset($_POST['pid']) OR empty($_POST['note'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$record = array(
					"note"=>$db->sqlsafe(nl2br($_POST['note'])),
					"task_id"=>$db->sqlsafe($_POST['pid'])
				);
				$insert = $db->insert('tasks_notes',$record);
				if($insert){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
					$skin->assign('incFile','site/projects/noteForm.tpl');
				 	$skin->display('site/index.tpl');
				}else{
					header('Location: module.php?act=load&modload=projects&file=tasks&error=1');
				}
			}
			break;

		case 'addReal':
			if(!isset($_GET['id']) OR !isset($_GET['pId'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				for($i=0;$i<3;$i++){
					$realtions['Relation Type'][$relationName[$i]]=$relationName[$i];
				}
				$taskId = $db->sqlsafe($_GET['id']);
				$projectId = $db->sqlsafe($_GET['pId']);
				$getRelations = $db->select('select task_id_1 from tasks_relations where project_id='.$projectId.' and task_id_2 = '.$taskId.'');
				if(is_array($getRelations)){

					for($i=0;$i<count($getRelations);$i++){
						$result = $result.','.$getRelations[$i]['task_id_1'];
					}
					$result =substr($result, 1);
					$getProjectTasks = $db->select('select id , name from tasks_info where project_id='.$projectId.' and id not in ('.$result .')');
				}else{
					$getProjectTasks = $db->select('select id , name from tasks_info where project_id='.$projectId.' and id != '.$taskId.'');
				}

				$countTask = count($getProjectTasks);
				for($i=0;$i<$countTask;$i++){
					$tasks['Tasks'][$getProjectTasks[$i]['id']]=$getProjectTasks[$i]['name'];
				}

				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('tasks',$tasks);
				 	$skin->assign('relations',$realtions);
				 	$skin->assign('projectId',$_GET['pId']);
				 	$skin->assign('showClose','1');
				 	$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
				 	$skin->display('site/projects/relationForm.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
				 	$skin->assign('tasks',$tasks);
				 	$skin->assign('projectId',$_GET['pId']);
				 	$skin->assign('relations',$realtions);
					$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
					$skin->assign('incFile','site/projects/relationForm.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		case 'arelation':

			if(!isset($_POST['tid']) OR !isset($_POST['note']) OR empty($_POST['relation'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$record = array(
					"task_id_1"=>$db->sqlsafe($_POST['note']),
					"task_id_2"=>$db->sqlsafe($_POST['tid']),
					"relation"=>$db->sqlsafe($_POST['relation']),
					"project_id"=>$db->sqlsafe($_POST['project']),
				);
				$insert = $db->insert('tasks_relations',$record);
				if($insert){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('goto','module.php?act=load&modload=projects&file=tasks');
					$skin->assign('incFile','site/projects/relationForm.tpl');
				 	$skin->display('site/index.tpl');
				}else{
					header('Location: module.php?act=load&modload=projects&file=tasks&error=1');
				}
			}
		break;

		case 'delRel':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=2');
			}else{
				$id = $db->sqlsafe($_GET['id']);
				$delete = $db->delete('tasks_relations','id='.$id.'');
				if($delete){
					echo 1;
				}else{
					echo 'There was a Problem while we try to remove this Item .';
				}
			}
			break;

		case 'info':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=1');
			}else{
				$taskId = $db->sqlsafe($_GET['id']);
				$getRelations = $db->select('SELECT rel.id , rel.relation as relation , info.name as name1 , info1.name as name2 ' .
											'FROM `tasks_relations` AS rel ' .
											'INNER JOIN tasks_info AS info ON rel.task_id_1 = info.id ' .
											'INNER JOIN tasks_info AS info1 ON rel.task_id_2 = info1.id ' .
											'WHERE rel.task_id_2 = '.$taskId.'');

				$getnotes = $db->select('select * from tasks_notes where task_id ='.$taskId.'');
				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('showClose','1');
				 	$skin->assign('notes',$getnotes);
				 	$skin->assign('rel',$getRelations);
				 	$skin->display('site/projects/tasksNote.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('notes',$getnotes);
				 	$skin->assign('rel',$getRelations);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/projects/tasksNote.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		default:
 			$geCount = $db->CQuery('select count(id) from tasks_info');
			$nav = $db->getNav($geCount,$config['perPage']);
			$project_tasks = $db->select('select t.id , t.name , t.start_date , t.end_date
							,t.`description` , pInfo.name as proName , pInfo.id as pId , t.status_id
			 				from tasks_info as t inner join projects_info as pInfo on pInfo.id=t.project_id
							Order by t.start_date DESC',$page,$config['perPage']);
	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('nav',$nav);
			$skin->assign('tasks',$project_tasks);
			$skin->assign('incFile','site/projects/tasks.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}

?>
