<?php
###################################
# Copyright (c) 2008 Mhd Zahere Ghaibeh and others.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU GPL v2.0
# which accompanies this distribution, and is available at
# http://www.GNU.org
##################################

function getClientsNumber(){
	global $db;
	$getNumber = $db->CQuery('select count(id) from client_info');
	return $getNumber;
}

function getTypesNumber(){
	global $db;
	$getNumber = $db->CQuery('select count(id) from projects_type');
	return $getNumber;
}

function checkDates($project, $startDate , $endDate){
	global $db ;
	$error['done']=1;
	$error['msg']='';
	$getData = $db->select(' select start_date , end_date from projects_info where id='.$db->sqlsafe($project).' limit 0,1 ');
	if( $getData[0]['start_date'] > $startDate ){
		$error['msg'] = 'Your task start date is less than the project start date';
		$error['done']=0;
	}elseif( $getData[0]['end_date'] < $endDate ){
		$error['msg'] = 'Your task end date is greater than the project end date';
		$error['done']=0;	
	}
	return $error;
}
?>