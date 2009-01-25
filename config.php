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
 	define('ABSPATH',$_SERVER['DOCUMENT_ROOT'].'/Phoenix');
	require_once(ABSPATH.'/lib/php/classes/db.class.php');
	require_once(ABSPATH.'/lib/php/classes/BURAK_Gantt.class.php');
	require_once(ABSPATH.'/lib/php/functions/general.php');

	global $config;
	$config['dbname']='Phoenix';
	$config['dbuser']='root';
	$config['dbserver']='localhost';
	$config['dbpass']='';

	$db = new db();
	$db->connect($config['dbname'],$config['dbserver'],$config['dbuser'],$config['dbpass']);

	$settings = getSettings();
 	$config['dir']=ABSPATH;
	$config['url']=$settings['url'];
	$config['title']=$settings['sitename'];
	$config['curency']=$settings['curency'];
	$config['perPage']=$settings['perPage'];
	$config['theme']=$settings['theme'];
	$config['gantType']=1; // you can use 1 for days or 2 for weeks  or 3 for moths

	require_once($config['dir'].'/lib/php/smarty/Smarty.class.php');
	class skin extends Smarty{
		function skin(){
			global $config;
			$this->Smarty();
			$this->template_dir =$config['dir'].'/themes/'.$config['theme'].'/';
			$this->compile_dir  =$config['dir'].'/themes/'.$config['theme'].'/temp';
			$this->config_dir   =$config['dir'].'/themes/'.$config['theme'].'/config/';
			$this->load_filter('output','move_to_head');
			//$this->load_filter('output','png_image');
		}
	}
	session_start();
?>