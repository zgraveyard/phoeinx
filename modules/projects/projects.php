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
	for($i=1;$i<4;$i++){
		$status['Status'][$i]=$statusVars[$i-1];
	}
	switch ($act) {
		case 'new':
			require_once('functions.php');
			$getClients = getClientsNumber();
			if($getClients > 0){
				$getTypes = getTypesNumber();
				if($getTypes > 0){
					$getAllClients = $db->select('select id , name , company from client_info order by regDate ASC ');
					$countClients = count($getAllClients);
					for($i=0;$i<$countClients;$i++){
						$clients['Clients'][$getAllClients[$i]['id']]=$getAllClients[$i]['company'].' ('.$getAllClients[$i]['name'].')';
					}		
					$getDepartments = $db->select('select * from emp_departments order by fatherId ASC');
					$countDep = count($getDepartments);
						for($i=0;$i<$countDep;$i++){
							$sql[$i]='select count(id) as count from emp_personal_info where dep_id='.$db->sqlsafe($getDepartments[$i]['id']).'';
							$getDepartments[$i]['count']=$db->CQuery($sql[$i]);
							if($getDepartments[$i]['count'] > 0){
								$departments['Departments'][$getDepartments[$i]['id']]=getPath('emp_departments',
																		$getDepartments[$i]['id'],
																		$getDepartments[$i]['fatherId']);
							}
						}
					if(!is_array($departments)){
					 	$skin = new skin();
					 	$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=employees&file=department&action=new">new Department</a> before start adding a new Project, and remember to add few staff too.');
						$skin->assign('config',$config);
						$skin->assign('showMenu','1');
						$skin->assign('incFile','site/error.tpl');
						$skin->display('site/index.tpl');					
					}else{
						$getAllTypes = $db->select('select id , name from projects_type order by id ASC ');
						$countTypes = count($getAllTypes);
						for($i=0;$i<$countTypes;$i++){
							$types['Project Type'][$getAllTypes[$i]['id']]=$getAllTypes[$i]['name'];
						}
			
					 	$skin = new skin();
					 	$skin->assign('clients',$clients);
						$skin->assign('departments',$departments);
						$skin->assign('types',$types);
					 	$skin->assign('action','add');
						$skin->assign('config',$config);
						$skin->assign('status',$status);
						$skin->assign('showMenu','1');
						$skin->assign('incFile','site/projects/projectForm.tpl');
						$skin->display('site/index.tpl');					
					}				
				}elseif($getTypes == 0){
				 	$skin = new skin();
				 	$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=projects&file=types">new type</a> before start adding a new Project');
					$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
					$skin->display('site/index.tpl');				
				}		
			}
			elseif($getClients  == 0){
			 	$skin = new skin();
			 	$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=clients&file=client&action=new">new client</a> before start adding a new Project');
				$skin->assign('config',$config);
				$skin->assign('showMenu','1');
				$skin->assign('incFile','site/error.tpl');
				$skin->display('site/index.tpl');				
			}
		break;

		case 'add':
			if(empty($_POST['pname'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&action=new&error=1');
			}else{
				$record = array(
					"client_id" =>$db->sqlsafe($_POST['cln']),
					"type_id" =>$db->sqlsafe($_POST['ptype']),
					"name" =>$db->sqlsafe($_POST['pname']),
					"dep_id" =>$db->sqlsafe($_POST['dep_id']),
					"cost" =>$db->sqlsafe($_POST['cost']),
					"start_date" =>$db->sqlsafe($_POST['startDate']),
					"end_date" =>$db->sqlsafe($_POST['endDate']),
					"status_id" =>$db->sqlsafe($_POST['pStatus']),
					"description"=>$db->sqlsafe(nl2br($_POST['note']))
				);
				$insert = $db->insert('projects_info',$record);
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&action=new&error=2');
				}
			}
			break;

		case 'delete':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=2');
			}else{
				$pId = $db->sqlsafe($_GET['id']);
				$delete = $db->delete('projects_info','id ='.$pId.'');
				if($delete){
					$getTasks = $db->select('select id from tasks_info where project_id='.$pId.'');

					$delete = $db->delete('projects_notes','project_id ='.$pId.'');
					$deleteNote = $db->delete('tasks_notes','task_id='.$db->sqlsafe($getTasks[0]['id']).'');
					$deleteEmps = $db->delete('tasks_emp','task_id='.$db->sqlsafe($getTasks[0]['id']).'');
					$deleteEmps = $db->delete('tasks_info','project_id='.$pId.'');
					$deleteRel = $db->delete('tasks_relations','project_id='.$pId.'');

					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
				}
			}
			break;
		case 'info':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
			}else{
				$pId = $db->sqlsafe($_GET['id']);
				$project_info = $db->select('select pinfo.id , pinfo.name , cinfo.company , cinfo.id as cId ,pinfo.`description`,pinfo.cost,
	 			pinfo.start_date , pinfo.end_date ,ptype.name as type , pinfo.status_id , dep.id as depID ,  dep.name as depName , dep.fatherId
	 			from projects_info as pinfo
		 		inner join client_info as cinfo on pinfo.client_id = cinfo.id
				inner join projects_type as ptype on pinfo.type_id = ptype.id
				inner join emp_departments as dep on pinfo.dep_id = dep.id
				where pinfo.id = '.$pId.'	order by pinfo.id ASC',0,1);

				$project_info[0]['depName']=getPath('emp_departments',$project_info[0]['depID'],$project_info[0]['fatherId']);
				$getProjectNotes = $db->select('select * from projects_notes where project_id = '.$pId.' ');

				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('showClose','1');
				 	$skin->assign('notes',$getProjectNotes);
					$skin->assign('project',$project_info[0]);
				 	$skin->display('site/projects/project.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('notes',$getProjectNotes);
					$skin->assign('project',$project_info[0]);
					$skin->assign('incFile','site/projects/project.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		case 'editForm':
				if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
			}else{
				$pId = $db->sqlsafe($_GET['id']);
				$getTasks =$db->CQuery('select count(id) from tasks_info where project_id='.$pId.'');

				$project_info = $db->select('select pinfo.id , pinfo.name , cinfo.id as cId ,pinfo.`description`,pinfo.cost,
	 			pinfo.start_date , pinfo.end_date , pinfo.status_id , dep.id as depId , dep.name as depName
	 			from projects_info as pinfo
		 		inner join client_info as cinfo on pinfo.client_id = cinfo.id
				inner join projects_type as ptype on pinfo.type_id = ptype.id
				inner join emp_departments as dep on pinfo.dep_id = dep.id
				where pinfo.id = '.$pId.' order by pinfo.id ASC',0,1);

				$project_info[0]['description'] =strip_tags($project_info[0]['description']);

				$getAllClients = $db->select('select id , name , company from client_info order by regDate ASC ');
				$countClients = count($getAllClients);
				for($i=0;$i<$countClients;$i++){
					$clients['Clients'][$getAllClients[$i]['id']]=$getAllClients[$i]['company'].' ('.$getAllClients[$i]['name'].')';
				}

				if($getTasks == 0 ){
					$getDepartments = $db->select('select * from emp_departments order by fatherId ASC');
					$countDep = count($getDepartments);
					for($i=0;$i<$countDep;$i++){
						$departments['Departments'][$getDepartments[$i]['id']]=getPath('emp_departments',
																$getDepartments[$i]['id'],
																$getDepartments[$i]['fatherId']);
					}
				}elseif($getTasks > 0){
					$departments['Departments'][0]=array($project_info[0]['depId']=>$project_info[0]['depName']);
				}


				$getAllTypes = $db->select('select id , name from projects_type order by id ASC ');
				$countTypes = count($getAllTypes);
				for($i=0;$i<$countTypes;$i++){
					$types['Clients'][$getAllTypes[$i]['id']]=$getAllTypes[$i]['name'];
				}

			 	$skin = new skin();
			 	$skin->assign('clients',$clients);
				$skin->assign('departments',$departments);
				$skin->assign('types',$types);
			 	$skin->assign('action','edit');
				$skin->assign('config',$config);
				$skin->assign('status',$status);
				$skin->assign('project',$project_info[0]);
				$skin->assign('showMenu','1');
				$skin->assign('incFile','site/projects/projectForm.tpl');
				$skin->display('site/index.tpl');
			}
			break;

		case 'addNote':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
			}else{
				if($_POST['ajax'] == 1){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('showClose','1');
				 	$skin->assign('goto','module.php?act=load&modload=projects&file=projects');
				 	$skin->display('site/projects/noteForm.tpl');
				}else{
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('goto','module.php?act=load&modload=projects&file=projects');
					$skin->assign('incFile','site/projects/noteForm.tpl');
				 	$skin->display('site/index.tpl');
				}
			}
			break;

		case'anote':
			if(!isset($_POST['pid']) OR empty($_POST['note'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
			}else{
				$record = array(
					"note"=>$db->sqlsafe(nl2br($_POST['note'])),
					"project_id"=>$db->sqlsafe($_POST['pid'])
				);
				$insert = $db->insert('projects_notes',$record);
				if($insert){
			 		$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('goto','module.php?act=load&modload=projects&file=projects');
					$skin->assign('incFile','site/projects/noteForm.tpl');
				 	$skin->display('site/index.tpl');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&error=1');
				}
			}
			break;

		case 'edit':
			if(empty($_POST['pname']) OR !isset($_POST['pId'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&action=new&error=1');
			}else{
				$projectID = $db->sqlsafe($_POST['pId']);
				$record = array(
					"client_id" =>$db->sqlsafe($_POST['cln']),
					"type_id" =>$db->sqlsafe($_POST['ptype']),
					"name" =>$db->sqlsafe($_POST['pname']),
					"dep_id" =>$db->sqlsafe($_POST['dep_id']),
					"cost" =>$db->sqlsafe($_POST['cost']),
					"start_date" =>$db->sqlsafe($_POST['startDate']),
					"end_date" =>$db->sqlsafe($_POST['endDate']),
					"status_id" =>$db->sqlsafe($_POST['pStatus']),
					"description"=>$db->sqlsafe(nl2br($_POST['note']))
				);
				$insert = $db->update('projects_info',$record,'id = '.$projectID.'');
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=projects&file=projects&action=editForm&id='.$_POST['pId'].'&error=2');
				}
			}
			break;

		default:
	 		$geCount = $db->CQuery('select count(id) from projects_info');
			$nav = $db->getNav($geCount,$config['perPage']);
	 		$getAllProjects =$db->select('select pinfo.id , pinfo.name , cinfo.company , cinfo.id as cId ,
	 			pinfo.start_date , pinfo.end_date ,  pinfo.status_id , dep.id as depID, dep.name as depName , dep.fatherId
	 			from projects_info as pinfo
		 		inner join client_info as cinfo on pinfo.client_id = cinfo.id
				inner join projects_type as ptype on pinfo.type_id = ptype.id
				inner join emp_departments as dep on pinfo.dep_id = dep.id
				order by pinfo.id ASC
			',$page,$config['perPage']);
	 		$countProjects = count($getAllProjects);
	 		for($i=0;$i<$countProjects;$i++){
				$getAllProjects[$i]['depName']=getPath('emp_departments',$getAllProjects[$i]['depID'],$getAllProjects[$i]['fatherId']);
	 		}

	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('nav',$nav);
			$skin->assign('projects',$getAllProjects);
			$skin->assign('incFile','site/projects/projects.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}
?>