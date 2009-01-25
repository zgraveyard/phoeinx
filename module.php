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
	include_once('config.php');
	$act = isset($_GET['act']) ? treatGet($_GET['act']):treatGet($_POST['act']);
	switch($act){
		case 'load':
			if(empty($_GET['modload'])){
				header('location: index.php');
			}else{
				if(empty($_GET['file'])){
					$fileToLoad = 'index.php';
				}else{
					$fileToLoad = $_GET['file'].'.php';
				}
				$directory = $config['dir'].'/modules/'.$_GET['modload'].'/';
				if(is_file($directory)){
					die('you cant use this module its a file');
				}elseif(is_dir($directory)){
					if(!is_file($directory.$fileToLoad)){
						die('there is no such file');
					}else{
						require_once($directory.$fileToLoad);
					}
				}
			}
			break;
		default:
			header('Location : index.php');
	}

?>