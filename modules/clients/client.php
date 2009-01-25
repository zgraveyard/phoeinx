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
			require_once('functions.php');
			$workNumbers = getWorkNumbers();
			if($workNumbers > 0 ){
				$getCountries = $db->select('select ci , cn from cc order by cn ASC');
				for($i=0;$i<239;$i++){
					$country['Nationality'][$getCountries[$i]['ci']] = $getCountries[$i]['cn'];
				}
	
				$getWork = $db->select('select * from work_area order by work_type ASC');
				$countWork = count($getWork);
				for($i=0;$i<$countWork;$i++){
					$workType['Specialization'][$getWork[$i]['id']] = $getWork[$i]['work_type'] ;
				}
				if($_POST['ajax'] != 1){
			 		$skin = new skin();
			 		$skin->assign('country',$country);
			 		$skin->assign('work',$workType);
			 		$skin->assign('action','add');
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/client/clientForm.tpl');
				 	$skin->display('site/index.tpl');
				}elseif($_POST['ajax'] == 1){
			 		$skin = new skin();
			 		$skin->assign('country',$country);
			 		$skin->assign('work',$workType);
			 		$skin->assign('action','add');
				 	$skin->assign('config',$config);
					$skin->assign('showClose','1');
					$skin->display('site/client/clientForm.tpl');
				}			
			}elseif($workNumbers == 0){
			 		$skin = new skin();
			 		$skin->assign('errorMSG','Sorry , but you have to add a <a href="'.$config['url'].'/module.php?act=load&modload=clients&file=work">new work fields</a> before start adding a new client');
				 	$skin->assign('config',$config);
				 	$skin->assign('showMenu','1');
					$skin->assign('incFile','site/error.tpl');
				 	$skin->display('site/index.tpl');				
			}
		break;

		case 'add':
			if(empty($_POST['cname']) OR empty($_POST['company']) OR empty($_POST['workType'] )
			OR empty($_POST['address']) ) {
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&action=new&error=1');
			}else{
				$record = array(
					"name"=>$db->sqlsafe($_POST['cname']),
					"company"=>$db->sqlsafe($_POST['company']),
					"regDate"=>$db->sqlsafe($_POST['regdate']),
					"moreInfo"=>$db->sqlsafe(nl2br($_POST['moreInfo'])),
					"mobile"=>$db->sqlsafe($_POST['mobile']),
					"address"=>$db->sqlsafe(nl2br($_POST['address'])),
					"phone"=>$db->sqlsafe($_POST['phone']),
					"nationality"=>$db->sqlsafe($_POST['ci']),
					"fax"=>$db->sqlsafe($_POST['fax']),
					"workId"=>$db->sqlsafe($_POST['workType'])
				);
				$insert = $db->insert('client_info',$record);
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&action=new&error=2');
				}
			}
			break;

		case 'editForm':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
			}else{
				$clnId = $db->sqlSafe($_GET['id']);
				$getCln = $db->select('select * from client_info where id='.$clnId.'');
				if(!is_array($getCln)){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
				}else{
					$getCountries = $db->select('select ci , cn from cc order by cn ASC');
					for($i=0;$i<239;$i++){
						$country['Nationality'][$getCountries[$i]['ci']] = $getCountries[$i]['cn'];
					}

					$getWork = $db->select('select * from work_area order by work_type ASC');
					$countWork = count($getWork);
					for($i=0;$i<$countWork;$i++){
						$workType['Specialization'][$getWork[$i]['id']] = $getWork[$i]['work_type'] ;
					}
					if($_POST['ajax'] != 1){
				 		$skin = new skin();
				 		$skin->assign('country',$country);
						$skin->assign('work',$workType);
						$skin->assign('info',$getCln[0]);
				 		$skin->assign('action','edit');
					 	$skin->assign('config',$config);
						$skin->assign('showMenu','1');
						$skin->assign('incFile','site/client/clientForm.tpl');
					 	$skin->display('site/index.tpl');
					}elseif($_POST['ajax'] == 1){
				 		$skin = new skin();
				 		$skin->assign('country',$country);
						$skin->assign('work',$workType);
						$skin->assign('info',$getCln[0]);
				 		$skin->assign('action','edit');
					 	$skin->assign('config',$config);
						$skin->assign('showClose','1');
						$skin->display('site/client/clientForm.tpl');
					}
				}
			}
			break;

		case 'edit':
			if(!isset($_POST['cId']) OR empty($_POST['cname']) OR empty($_POST['company']) OR empty($_POST['workType'] )
			OR empty($_POST['address']) ) {
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&action=new&error=1');
			}else{
				$clnId = $db->sqlsafe($_POST['cId']);
				$record = array(
					"name"=>$db->sqlsafe($_POST['cname']),
					"company"=>$db->sqlsafe($_POST['company']),
					"regDate"=>$db->sqlsafe($_POST['regdate']),
					"moreInfo"=>$db->sqlsafe(nl2br($_POST['moreInfo'])),
					"mobile"=>$db->sqlsafe($_POST['mobile']),
					"address"=>$db->sqlsafe(nl2br($_POST['address'])),
					"phone"=>$db->sqlsafe($_POST['phone']),
					"nationality"=>$db->sqlsafe($_POST['ci']),
					"fax"=>$db->sqlsafe($_POST['fax']),
					"workId"=>$db->sqlsafe($_POST['workType'])
				);
				$update = $db->update('client_info',$record,' id = '.$clnId.' ');
				if($update){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&action=new&error=2');
				}
			}
			break;

		case 'delete':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
			}else{
				$clnId = $db->sqlsafe($_GET['id']);
				$getProjectsCount = $db->CQuery('select count(id) from projects_info where client_id ='.$clnId.'');
				if($getProjectsCount == 0){
					$delete = $db->delete('client_info','id ='.$clnId.'');
					$delete2 = $db->delete('client_payment','client_id = '.$clnId.'');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=1');
				}
				if($delete){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=1');
				}
			}
			break;

		case 'clientInfo':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
			}else{
				$clnId = $db->sqlsafe($_GET['id']);
				$getCln = $db->select('select * from client_info as cl inner join cc on cc.ci = cl.nationality
					inner join work_area as wrk on wrk.id = cl.workId where cl.id = '.$clnId.'
				');
			 	if($_POST['ajax'] == 1){
					$skin = new skin();
					$skin->assign('info',$getCln[0]);
			 		$skin->assign('config',$config);
			 		$skin->assign('showClose','1');
			 		$skin->display('site/client/client.tpl');
			 	}else{
			 		$skin = new skin();
			 		$skin->assign('info',$getCln[0]);
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/client/client.tpl');
				 	$skin->display('site/index.tpl');
			 	}
			}
			break;

			default:
	 		$geCount = $db->CQuery('select count(id) from client_info');
			$nav = $db->getNav($geCount,$config['perPage']);
	 		$getAllCleints =$db->select(
	 			'select info.id as id , info.name as clnName , info.company , wrk.work_type as wrkName ,info.regDate as regDate
	 			 from client_info as info inner join work_area as wrk
	 			 on info.workId = wrk.id order by info.id ASC '
				,$page,$config['perPage']);
	 		$skin = new skin();
		 	$skin->assign('config',$config);
			$skin->assign('showMenu','1');
			$skin->assign('nav',$nav);
			$skin->assign('cleints',$getAllCleints);
			$skin->assign('incFile','site/client/clients.tpl');
		 	$skin->display('site/index.tpl');
		break;
	}
?>
