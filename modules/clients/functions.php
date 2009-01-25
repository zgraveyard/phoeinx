<?php
###################################
# Copyright (c) 2008 Mhd Zahere Ghaibeh and others.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU GPL v2.0
# which accompanies this distribution, and is available at
# http://www.GNU.org
##################################

function getWorkNumbers(){
	global $db;
	$getNumber = $db->CQuery('select count(id) from work_area');
	return $getNumber;
}

?>