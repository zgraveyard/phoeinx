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
		case 'pay':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
			}else{
				$clnId = $db->sqlsafe($_GET['id']);
				$getCln = $db->select('select pay.* , cl.name , cl.company from client_payment as pay
				inner join client_info as cl on cl.id = pay.client_id where cl.id = '.$clnId.' and pay.client_id = '.$clnId.' ');

				$getTotalPayments = $db->CQuery('select sum(ammount) as total  from client_payment where client_id = '.$clnId.' ');
				$getMustPay = $db->CQuery('select sum(cost) as total  from projects_info where client_id = '.$clnId.' ');

			 	if($_POST['ajax'] == 1){
					$skin = new skin();
					$skin->assign('info',$getCln);
			 		$skin->assign('config',$config);
			 		$skin->assign('total',$getTotalPayments);
			 		$skin->assign('mustPay',$getMustPay);
			 		$skin->assign('showClose','1');
			 		$skin->display('site/client/payments.tpl');
			 	}else{
			 		$skin = new skin();
			 		$skin->assign('info',$getCln);
				 	$skin->assign('config',$config);
			 		$skin->assign('total',$getTotalPayments);
			 		$skin->assign('mustPay',$getMustPay);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/client/payments.tpl');
				 	$skin->display('site/index.tpl');
			 	}
			}
			break;

		case 'addPay':
			if(!isset($_GET['id'])){
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
			}else{
				$clnId = $db->sqlsafe($_GET['id']);
				$getCln = $db->select('select name , company from client_info where id = '.$clnId.' ');
			 	if($_POST['ajax'] == 1){
					$skin = new skin();
					$skin->assign('info',$getCln[0]);
			 		$skin->assign('config',$config);
			 		$skin->assign('showClose','1');
			 		$skin->display('site/client/payForm.tpl');
			 	}else{
			 		$skin = new skin();
			 		$skin->assign('info',$getCln[0]);
				 	$skin->assign('config',$config);
					$skin->assign('showMenu','1');
					$skin->assign('incFile','site/client/payForm.tpl');
				 	$skin->display('site/index.tpl');
			 	}
			}
			break;
		case 'addPayment':
			if(empty($_POST['cname']) OR empty($_POST['company']) ) {
				header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=1');
			}else{
				$record = array(
					"client_id"=>$db->sqlsafe($_POST['cId']),
					"pay_date"=>$db->sqlsafe($_POST['regdate']),
					"ammount"=>$db->sqlsafe($_POST['ammount']),
					"type"=>$db->sqlsafe($_POST['type'])
				);
				$insert = $db->insert('client_payment',$record);
				if($insert){
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&done=1');
				}else{
					header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
				}
			}
			break;
		default:
			header('Location: '.$config['url'].'/module.php?act=load&modload=clients&file=client&error=2');
	}
?>