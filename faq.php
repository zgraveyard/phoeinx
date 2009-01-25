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
 			$menu = 1;
 		}
 	}else{
 		$menu = 0;
 	}
 	$skin = new skin();
    $skin->assign('config',$config);
	$skin->assign('showMenu',$menu);
	$skin->assign('incFile','site/faq.tpl');
	$skin->display('site/index.tpl');
?>