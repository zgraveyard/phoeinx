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
   require_once('config.php');
	if(isset($_SESSION['login'])){
 		if(is_array($_SESSION['login'])){
 			header('Location: index.php');
 		}
 	}else{
		$act = isset($_GET['action']) ? treatGet($_GET['action']):treatGet($_POST['action']);
		switch ($act) {
			case 'get':
				if(empty($_POST['email'])){
					header('Location: '.$config['url'].'/lost.php?error=2');
				}else{
					require_once (ABSPATH."/lib/php/pear/Validate.php");
					$check = Validate::email(trim($_POST['email']));
					if($check){
						$email = $db->sqlsafe($_POST['email']);
						$getEmail = $db->CQuery('select count(id) from admin where email='.$email.' limit 0,1');
						if($getEmail != 0){
							$newPassword = Random_Password(10);
							$record = array(
								"passwd"=>$db->sqlsafe(md5($newPassword))
							);
							$update = $db->update('admin',$record,'email = '.$email.'');
							if($update){
								$to      = $_POST['email'];
								$subject = 'New Password';
								$message = 'Hello Sir :'."\r\n";
								$message.= 'Some one has request a new password.'."\r\n";
								$message.= 'We have Change it successfully'."\r\n";
								$message.= 'Your new password is :'.$newPassword.''."\r\n";
								$headers = 'From: ' .$_POST['email'].''. "\r\n" .
								    'Reply-To: '.$_POST['email'].'' . "\r\n";
								$result = mail($to, $subject, $message, $headers);
								if($result){
									header('Location: '.$config['url'].'/lost.php?done=1');
								}else{
									header('Location: '.$config['url'].'/lost.php?error=4');
								}

							}else{
								header('Location: '.$config['url'].'/lost.php?error=1');
							}
						}else{
							header('Location: '.$config['url'].'/lost.php?error=1');
						}
					};
				}
				break;
			default:
		  	$skin = new skin();
		  	$skin->assign('url',$globalVar['url']);
		  	$skin->assign('action','get');
		  	$skin->assign('config',$config);
		  	$skin->assign('showMenu','0');
		  	$skin->assign('incFile','site/lost.tpl');
		  	$skin->assign('redir', treatGet(urldecode($_GET['redirect'])));
		  	$skin->display('site/index.tpl');
	 	}
	}
?>