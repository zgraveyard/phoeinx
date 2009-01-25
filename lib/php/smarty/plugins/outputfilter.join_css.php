<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty join_css outputfilter plugin
 *
 * File:     outputfilter.join_css.php<br>
 * Type:     outputfilter<br>
 * Name:     join_css<br>
 * Date:     Jan 03, 2008<br>
 * Purpose:  join togther css into a single file
 * Install:  Drop into the plugin directory, call
 *           <code>$smarty->load_filter('output','join_css');</code>
 *           from application. You should specify your cachedir below.
 * @author   Leon Chevalier <http://aciddrop.com>
 * @version  1
 * @param string
 * @param Smarty
 */
function smarty_outputfilter_join_css($source, &$smarty)
{
	return _joiner(array('cachedir'=>$smarty->compile_dir,
					 	 'tag'=>'link',
						 'type'=>'text/css',
						 'ext'=>'css',
					  	 'src'=>'href',
					  	 'rel'=>'stylesheet',
					  	 'self_close'=>true),$source);	
}

function _joiner($options,$source) {
//	$cachedir = $_SERVER['DOCUMENT_ROOT'] . $options['cachedir'];
	$cachedir = $options['cachedir'];
	preg_match("!<head>.*?</head>!is", $source, $matches);	
	if(is_array($matches)) {
	preg_match_all("!<" . $options['tag'] . "[^>]+" . $options['type'] . "[^>]+>(</" . $options['tag'] . ">)?!is", $matches[0], $matches);
	}
	$script_array = $matches[0];
	if(is_array($script_array)) {
		//Get the cache hash
		$cache_file = md5(implode("_",$script_array));
		//echo $cache_file . "\n";
		//Remove empty sources
		foreach($script_array AS $key=>$value) {
		preg_match("!" . $options['src'] . "=\"(.*?)\"!is", $value, $src);
			if(!$src[1]) {
			unset($script_array[$key]);
			}
		}		
		//Check if the cache file exists
		if (file_exists($cachedir . "/" . $cache_file . ".$options[ext]")) {
		$source = _remove_scripts($script_array,$source);
		$source = str_replace("@@marker@@","<" . $options['tag'] . " type=\"" . $options['type'] . "\" " .  $options['src'] . "=\"http://" . $_SERVER['HTTP_HOST'] . $options['cachedir'] . "/$cache_file.$options[ext]\" rel=\"stylesheet\" />",$source);
		return $source;
		}				
		//Create file
		foreach($script_array AS $key=>$value) {
			//Get the src
			preg_match("!" . $options['src'] . "=\"(.*?)\"!is", $value, $src);
			$src[1] = str_replace("http://".$_SERVER['HTTP_HOST'],"",$src[1]);
			$current_src = $_SERVER['DOCUMENT_ROOT'] . $src[1];								
			//Get the code
			if (file_exists($current_src)) {
			   $contents .= file_get_contents($current_src) . "\n";				      
			   if($key == count($script_array)-1) { //Remove script 
				   $source = str_replace($value,"@@marker@@",$source); 
			   } else {
				   $source = str_replace($value,"",$source);
			   }
			}					
		}
		//Write to cache and display
		if($contents) {
			if ($fp = fopen($cachedir . '/' . $cache_file . '.' . $options[ext], 'wb')) {
					fwrite($fp, $contents);
					fclose($fp);				
					//Create the link to the new file
					$newfile = "<" . $options['tag'] . " type=\"" . $options['type'] . "\" $options[src]=\"http://" . $_SERVER['HTTP_HOST'] . $options['cachedir'] ."/$cache_file." . $options[ext] . "\"";					
					if($options['rel']) {
						$newfile .= " rel=\"" . $options['rel'] . "\"";
					}					
					if($options['self_close']) {
						$newfile .= " />";
					} else {
						$newfile .= "></" . $options['tag'] . ">";
					}
					$source = str_replace("@@marker@@",$newfile,$source);
			} 
		}
	}
	return $source;
}

function _remove_scripts($script_array,$source) {

	foreach($script_array AS $key=>$value) {	      
		   if($key == count($script_array)-1) { //Remove script 
		   $source = str_replace($value,"@@marker@@",$source); 
		   } else {
		   $source = str_replace($value,"",$source);
		   }			
	}	
	return $source;
}
?>