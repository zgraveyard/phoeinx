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
	isLogin();

	require_once "lib/php/providedUtilities/fpdf/fpdf.php";
	require_once "lib/php/providedUtilities/ziplib.php";
	require_once "lib/php/classes/class.report.php";

//create a new report
	$report = new Report();
	if($report->is_supported($_GET['type'])){  //if it's a supported filetype
	  $report->s_filetype($_GET['type']);
	}else{
	  $report->s_filetype($report->g_default()); //else use the default filetype
	}
	$report->s_baseDir('site/'); // use this to specify the directory where the report template fit inside.
	$report->s_fileName('report.pdf.tpl');
	$projectId = $db->sqlsafe($_GET['id']);
	$getData = $db->select('select id , name from projects_info where id='.$projectId.'');
	list($width , $height) = getimagesize($config['url'].'/cache/gantt.jpg');
	$report->assign('config',$config);
	$report->assign('project',$getData[0]);
	$report->assign('width',$width);
    $report->addPage();
    $filename = str_replace(' ','-',$getData[0]['name']); //set the filename here
    $report->printReport($filename);
?>