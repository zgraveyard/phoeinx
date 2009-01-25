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
	$act = (isset($_GET['action'])) ? treatGet($_GET['action']) : treatGet($_POST['action']);
	$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
	switch ($act) {
		case 'add':
			if( empty($_POST['title'])){
				header('location: feed.php?error=1');
			}else{
				$record = array(
					"url"=>$db->sqlsafe($_POST['title'])
				);
				$insert= $db->insert('feeds',$record);
				if($_POST['ajax'] != 1){
					if($insert){
						header('Location: '.$config['url'].'/feed.php?done=1');
					}else{
						header('Location: '.$config['url'].'/feed.php?error=1');
					}
				}else{
					include_once(ABSPATH.'/lib/php/rss/rss_fetch.inc');
		 			define(MAGPIE_OUTPUT_ENCODING, 'windows-1256');
					$getFeeds = $db->select('select * from feeds order by id ASC');
					if(is_array($getFeeds)){
						for($i=0;$i<count($getFeeds);$i++){
							$feeds[$i]=$getFeeds[$i]['url'];
						}
		
						foreach($feeds as $key => $value){
							$news[$key]= fetch_rss($value);
							$getFeeds[$key]['title'] = $news[$key]->channel['title'];
						}
					}					
					$skin = new skin();
				 	$skin->assign('config',$config);
					$skin->assign('feeds',$getFeeds);
					$skin->display('site/allfeeds.tpl');
				}
			}
			break;
		case'getNews':
			 	include_once(ABSPATH.'/lib/php/rss/rss_fetch.inc');
			 	define(MAGPIE_OUTPUT_ENCODING, 'windows-1256');
				$getFeeds = $db->select('select url from feeds order by id DESC');
				if(is_array($getFeeds)){
					for($i=0;$i<count($getFeeds);$i++){
						$feeds[$i]=$getFeeds[$i]['url'];
					}

					foreach($feeds as $key => $value){
						$news[$key]= @fetch_rss($value);
						$num_items = 3;
						$items[$key]['item'] = array_slice($news[$key]->items, 0, $num_items);
						$items[$key]['title'] = $news[$key]->channel['title'];

					}
				 	$skin = new skin();
				 	$skin->assign('config',$config);
				 	$skin->assign('rss',$items);
				 	$skin->assign('title',$rss->channel['title']);
				 	$skin->display('site/news.tpl');
				}else{
				 	$skin = new skin();
				 	$skin->display('site/none.tpl');
				}
			break;
		case 'del':
			if(!isset($_GET['id'])){
				header('Location: '.$_SERVER['HTTP_REFERER'].'&error=2');
			}else{
				$id = $db->sqlsafe($_GET['id']);
				$delete = $db->delete('feeds','id='.$id.'');
				if($delete){
					echo 1;
				}else{
					echo 'There was a Problem while we try to remove this employee .';
				}
			}
			break;
		default:
 			include_once(ABSPATH.'/lib/php/rss/rss_fetch.inc');
 			define(MAGPIE_OUTPUT_ENCODING, 'windows-1256');
			$getFeeds = $db->select('select * from feeds order by id');
			if(is_array($getFeeds)){
				for($i=0;$i<count($getFeeds);$i++){
					$feeds[$i]=$getFeeds[$i]['url'];
				}

				foreach($feeds as $key => $value){
					$news[$key]= fetch_rss($value);
					$getFeeds[$key]['title'] = $news[$key]->channel['title'];
				}
			}
			$skin = new skin();
			$skin->assign('showMenu','1');
			$skin->assign('config',$config);
			$skin->assign('act','add');
	 		$skin->assign('feeds',$getFeeds);
	 		$skin->assign('incFile','site/feed.tpl');
	 		$skin->display('site/index.tpl');
			break;
	}
?>
