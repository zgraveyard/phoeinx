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
	if(!isset($_GET['pId']) OR empty($_GET['pId'])){
		header('location: '.$_SERVER['HTTP_REFERER'].'&error=1');
	}else{
		@unlink(ABSPATH.'/cache/gantt.jpg');
		$projectId = $db->sqlsafe($_GET['pId']);
		$getTasks = $db->select('select id , name ,progress, start_date , end_date ,status_id ' .
								'from tasks_info where project_id = '.$projectId.'');
		if(is_array($getTasks )){
			$g = new BURAK_Gantt();
			// set grid type
			$g->setGrid($config['gantType']);
			// set Gantt colors
			$g->setColor("group","000000");
			$g->setColor("progress","660000");

			for($i=0;$i<count($getTasks);$i++){
				$g->addTask($getTasks[$i]['id'],$getTasks[$i]['start_date'],$getTasks[$i]['end_date'],$getTasks[$i]['progress'],$getTasks[$i]['name']);
			}
			$getRelationShip = $db->select('select * from tasks_relations where project_id='.$projectId.'');
			for($i=0;$i<count($getRelationShip);$i++){
				$g->addRelation($getRelationShip[$i]['task_id_1'],$getRelationShip[$i]['task_id_2'],$getRelationShip[$i]['relation']);
			}
			$g->outputGantt(ABSPATH.'/cache/gantt.jpg');
			$getData = $db->select('select id , name from projects_info where id='.$projectId.'');
	 		$skin = new skin();
		 	$skin->assign('config',$config);
		 	$skin->assign('project',$getData[0]);
			$skin->assign('showMenu','1');
			$skin->assign('incFile','site/projects/gantt.tpl');
		 	$skin->display('site/index.tpl');
		}else{
			header('location: module.php?act=load&modload=projects&file=projects&error=512');
		}
		exit;
	}
?>