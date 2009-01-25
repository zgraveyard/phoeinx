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
	include_once('config.php');
 	isLogin();

	$act = (isset($_GET['act'])) ? treatGet($_GET['act']) : treatGet($_POST['act']);
	switch($act)
	{
		case 'chPass':
			if(!isset($_POST['userid']) OR !isset($_POST['oldPass']) OR !isset($_POST['newPass']) OR !isset($_POST['newPass2'])){
				header('Location: change.php?error=1');
			}else{
				$id = $db->sqlSafe($_POST['userid']);
				$isAdmin = $db->select('select * from admin where id='.$id.' ');
				if(is_array($isAdmin)){
					$OldPassword = md5(trim($_POST['oldPass']));
					if($OldPassword === $isAdmin[0]['passwd'] ){
						if($_POST['newPass'] === $_POST['newPass2']){
							$newPass = md5(trim($_POST['newPass']));
							$record = array(
								"passwd"=>$db->sqlSafe($newPass)
							);
							$update = $db->update('admin',$record,'id = '.$id.' ');
							if($update){
								header('location: change.php?error=4');
							}else{
								header('location: change.php?error=2');
							}
						}else{
								header('location: change.php?error=6');
						}
					}else{
								header('location: change.php?error=3');
					}
				}else{
								header('location: change.php?error=5');
				}
			}

		break;

		default:
			$adminId = $db->sqlsafe($_SESSION['login']['id']);
			$select = $db->select('select * from admin where id = '.$adminId.' ');
			if(!is_array($select)){
				header('Location: change.php?error=6');
			}
			$skin = new skin();
	 		$skin->assign('config',$config);
	 		$skin->assign('showMenu','1');
			$skin->assign('act','chPass');
	 		$skin->assign('admin',$select[0]);
	 		$skin->assign('incFile','site/password.tpl');
	 		$skin->display('site/index.tpl');
	}
?>