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
switch ($act) {
	case 'new':
		$getAllDepartments = $db->select('select * from emp_departments order by id ASC');
		$countDep = count($getAllDepartments);
		for($i=0;$i<$countDep;$i++){
			$departments['path'][$getAllDepartments[$i]['id']]=getPath('emp_departments',
			$getAllDepartments[$i]['id'],
			$getAllDepartments[$i]['fatherId']);
		}
		if($_POST['ajax'] != 1){
			$skin = new skin();
			$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('act','add');
			$skin->assign('departments',$departments);
			$skin->assign('incFile','site/emp/departmentForm.tpl');
			$skin->display('site/index.tpl');
		}elseif($_POST['ajax'] == 1){
			$skin = new skin();
			$skin->assign('config',$config);
			$skin->assign('showClose','1');
			$skin->assign('act','add');
			$skin->assign('departments',$departments);
			$skin->display('site/emp/departmentForm.tpl');
		}
		break;

	case 'add':
		if(empty($_POST['depName'])){
			header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&action=new&error=1');
		}else{
			$record = array(
						"name"=>$db->sqlsafe($_POST['depName']),
						"fatherId"=>$db->sqlsafe($_POST['fatherId'])
			);
			$insert = $db->insert('emp_departments',$record);
			if($insert){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&done=1');
			}else{
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&action=new&error=2');
			}
		}
		break;
	case 'editForm':
		if(!isset($_GET['id'])){
			header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&error=2');
		}else{
			$depId = $db->sqlsafe($_GET['id']);
			$getDepInfo = $db->select('select * from emp_departments where id='.$depId.' limit 0,1');

			$getAllDepartments = $db->select('select * from emp_departments where fatherId !='.$depId.' order by id ASC');
			$countDep = count($getAllDepartments);
			for($i=0;$i<$countDep;$i++){
				$departments['path'][$getAllDepartments[$i]['id']]=getPath('emp_departments',
				$getAllDepartments[$i]['id'],
				$getAllDepartments[$i]['fatherId']);
			}
			if($_POST['ajax'] != 1){
				$skin = new skin();
				$skin->assign('config',$config);
				$skin->assign('showMenu','1');
				$skin->assign('act','edit');
				$skin->assign('info',$getDepInfo[0]);
				$skin->assign('departments',$departments);
				$skin->assign('incFile','site/emp/departmentForm.tpl');
				$skin->display('site/index.tpl');
			}elseif($_POST['ajax'] == 1){
				$skin = new skin();
				$skin->assign ('config',$config);
				$skin->assign ('showClose','1');
				$skin->assign ('act','edit');
				$skin->assign ('info',$getDepInfo[0]);
				$skin->assign ('departments',$departments);
				$skin->display('site/emp/departmentForm.tpl');
			}
		}
		break;

	case 'edit':
		if(!isset($_POST['did']) OR empty($_POST['depName'])){
			header('Location: '.$_SERVER['HTTP_REFERER'].'&error=3');
		}else{
			$id = $db->sqlsafe($_POST['did']);
			$record=array(
						"name"=>$db->sqlsafe($_POST['depName']),
						"fatherId"=>$db->sqlsafe($_POST['fatherId'])
			);
			$update =$db->update('emp_departments',$record , 'id = '.$id.'');
			if($update){
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&done=1');
			}else{
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=3');
			}
		}
		break;

	case 'delete':
		if(!isset($_GET['id'])){
			header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&error=2');
		}else{
			$depId = $db->sqlsafe($_GET['id']);
			$getDepartment = $db->CQuery('select count(id) as count from emp_departments where id='.$depId.'');
			if($getDepartment == 1){
				$getEmployee = $db->CQuery('select count(id) from emp_personal_info ' .
											'where dep_id IN ('.getSons($_GET['id']).') ' .
											'order By id ASC');
				if($getEmployee == 0 ){
					$delete = $db->delete('emp_departments','id ='.$depId.'');
					if($delete){
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&done=1');
					}else{
						header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&error=1');
					}
				}elseif( $getEmployee != 0 ){
					header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&error=3');
				}
			}else{
				header('Location: '.$config['url'].'/module.php?act=load&modload=employees&file=department&error=1');
			}
		}
		break;
	default:
		$geCount = $db->CQuery('select count(id) from emp_departments');
		$nav = $db->getNav($geCount,$config['perPage']);
		$getAllDepartments =$db->select('select * from emp_departments order by id ASC '
		,$page,$config['perPage']);
		$countDep = count($getAllDepartments);
		for($i=0;$i<$countDep;$i++){
			$getAllDepartments[$i]['path']=getPath('emp_departments',$getAllDepartments[$i]['id'],$getAllDepartments[$i]['fatherId']);
			$sql[$i]='select count(id) as count from emp_personal_info where dep_id='.$db->sqlsafe($getAllDepartments[$i]['id']).'';
			$getAllDepartments[$i]['count']=$db->CQuery($sql[$i]);
		}
		$skin = new skin();
		$skin->assign('config',$config);
		$skin->assign('showMenu','1');
		$skin->assign('nav',$nav);
		$skin->assign('departments',$getAllDepartments);
		$skin->assign('incFile','site/emp/departments.tpl');
		$skin->display('site/index.tpl');
		break;
}

?>