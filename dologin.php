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
 require_once('config.php');
 $user = isset($_GET['user']) ? treatGet($_GET['user']):treatGet($_POST['user']);
 $pass = isset($_GET['pass']) ? treatGet($_GET['pass']):treatGet($_POST['pass']);
 $pass = md5($pass);
	if((empty($user)) && (empty($pass))){
		header('Location: login.php?error=3');
		exit;
	}elseif(empty($user)){
		header('Location: login.php?error=1');
		exit;
	}elseif(empty($pass)){
		header('Location: login.php?error=2');
		exit;
	}else{
		$getUser = $db->CQuery('select count(id) from admin where name = '.$db->sqlsafe($user).' ');
		$getPassword = $db->CQuery('select count(id) from admin where passwd = '.$db->sqlsafe($pass).' ');
		if($getUser != 1){
			header('Location: login.php?error=1&user='.$user.'');
			exit;
		}elseif($getPassword != 1){
			header('Location: login.php?error=2');
			exit;
		}else{
				$getInfo = $db->select('select id ,name , email from admin where passwd = '.$db->sqlsafe($pass).' AND name = '.$db->sqlsafe($user).' limit 0 , 1');
				$_SESSION['login']['name'] = $getInfo[0]['name'];
				$_SESSION['login']['email'] = $getInfo[0]['email'];
				$_SESSION['login']['id'] = $getInfo[0]['id'];
				$_SESSION['login']['pass'] = $pass;
				if(!empty($_POST['redir'])){
					header('Location: '.$_POST['redir'].'');
					exit;
				}else{
					header('Location: index.php');
					exit;
				}
		}
	}
?>