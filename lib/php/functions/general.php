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
function isLogin(){
 	global $globalVar;
 	if(!isset($_SESSION['login'])){
 		header('Location: login.php?login=1&redirect='.htmlentities(urlencode($_SERVER['REQUEST_URI'])).'');
 	}elseif(isset($_SESSION['login'])){
 		if(!is_array($_SESSION['login'])){
 			header('Location: login.php?login=1&redirect='.htmlentities(urlencode($_SERVER['REQUEST_URI'])).'');
 		}
 	}
 }

function treatGet($text){
	$text = str_replace(array('&', '"', '<', '>'),array('&amp;', '&quot;','&lt;', '&gt;'),$text);
	return $text;
 }

function formatArray($arrayVars){
	echo '<pre>';
		print_r($arrayVars);
	echo'</pre>';
	exit;
 }

function getThemes($ThemeDir){
	if ($handle = opendir($ThemeDir)) {
	   while(FALSE!== ($file = readdir($handle))) {
	   	if( $file != '.' && $file != '..' && $file != 'index.htm' && $file!='index.html' && $file!='.svn' && $file!='index.php')
	   		{
		    		if(!is_file($file)){ $dir[$file]=$file; }
		    }
		 }
		 closedir($handle);
	}
	return $dir;
}


function pageNum($page=0, $perPage=25){
	if($page=="" || $page<=0){
		$page = 0;
	}
	return $start = (($page-1)*$perPage)+$perPage;
}

function Random_Password($length) {
	srand(date("s"));
	$possible_charactors = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$string = "";
	while(strlen($string)<$length) {
		$string .= substr($possible_charactors,(rand()%(strlen($possible_charactors))),1);
	}
	return($string);
}

function uploadExcel($fieldName){
			require_once (ABSPATH."/lib/pear/HTTP/Upload.php");
			$fileTypes = array('xls');
			$upload = new HTTP_Upload("en");
			$file = $upload->getFiles("".$fieldName."");
			$file->setName('uniq');
			$file->setValidExtensions($fileTypes,'accept');
			if ($file->isValid()) {
			    $moved = $file->moveTo("xls/");
			    if (!PEAR::isError($moved)) {
					$fileName = $file->getProp("name");
					$done['name']=$fileName;
					$done['result']=true;
			    } elseif ($file->isMissing()) {
			   	$done['result']=false;
			    $done['error']= 'No file was provided.';
				} elseif ($file->isError()) {
			   	$done['result']=false;
			    $done['error']= $file->errorMsg();;
				}
			}
			return  $done;
}

function getPath($table,$cat_father_id, $catId, $link=FALSE){
	global $db;
	$catArray = $db->select("SELECT * FROM ".$table." ORDER BY id DESC");
	$count = count($catArray);
	for ($i=0; $i<=$count; $i++) {
		if(isset($catArray[$i]['id']) && $catArray[$i]['id']==$cat_father_id) {
			if($link == TRUE){
				$pathArray[$i+1] = " &rsaquo;&rsaquo; <a href='ndex.php?catId=".$catArray[$i]['id']."&amp;act=viewCat' class='txtLocation'>"
									.$catArray[$i]['title']."</a>";
			} else {
				$pathArray[$i+1]= " &rsaquo;&rsaquo; ".$catArray[$i]['name'];
			}
			$cat_father_id = $catArray[$i]['fatherId'];
		}
	}
	krsort($pathArray);
	reset($pathArray);
	$dir = "";
	foreach($pathArray as $key => $value){
	 	$dir.= $value;
	}
	$dir = substr($dir,18);
	return $dir;
}

//function getSons($catId , $fatherId){
//	global $db;
//	$catArray = $db->select('SELECT id , fatherId FROM emp_departments where id='.$catId.' ORDER BY id DESC');
//	if($catArray[0]['fatherId'] != $fatherId) {
//		if ($catArray[0]['fatherId'] != 0)
//		{
//			return getSons($catArray[0]['fatherId'] , $fatherId);
//		}else{
//				return false;
//		}
//
//	}else{
//		return true;
//	}
//}
function getSons($dep_id){
	global $db;
	$result = $db->sqlsafe($dep_id);
	$getData = $db->select('select  id from emp_departments where fatherId='.$dep_id);
	$countData = count($getData);
	if($countData != 0)
	{
	   for($i=0;$i<$countData ;$i++)
		{
			$result = $result.','.getSons($getData[$i]['id']);
		}
	}
	return $result;
}

function getSettings(){
	global $db;
	$getSettings = $db->select('select * from settings where id='.$db->sqlsafe('1').' limit 0,1');
	return $getSettings[0];
}

?>