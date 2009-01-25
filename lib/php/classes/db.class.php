<?php
/**
 *  mysql DB CLASS
 *  Author  : Mhd Zaher Ghaibeh
 *  License : Dual license 1-LGPL , 2-GPL
 *  Version : 0.7 rc1
 *  @since 0.6b - May 23, 2007
 */

/*
usage :
$db = new db();
$db->connect($dbname , $server = "localhost" , $user ="root" , $pass ="");

$record = array("name"=>$db->sqlsafe('linux juggler'));
//insert
//insert(tablename , record );
$insert = $db->insert('names',$record);

//update
//update(tablename , record , where condition);
$update = $db->update('names',$record,'id=1');

//delete
//delete(tablename , where condition);
$delete = $db->delete('names','id=1');

//select
//@return array
$data = $db->select('select name from names');
$data['0']['name'] --> 'linux juggler';
$data['1']['name'] --> 'linux lady';
and so on ...
*/

if(class_exists('db')){
	return ;
}

class db{

	var $dbConnect;

	/**
	 * @access public
	 * This is the Connection function .
	 * by default you dont have to supply it with :
	 * 1- database host name : it will take the default 'localhost'.
	 * 2- database user name : it will take the default 'root'.
	 * 3- database password : it will take the default ''.
	 *
	 * @param string $db which is the database name
	 * @param string $user the user name for the database sever
	 * @param string $pass the database user password
	 * @param string $server the server host or ip
	 *
	 * @return void
	 */
	function connect($dbname , $server = "localhost" , $user ="root" , $pass ="" ){
		$this->dbserver = trim($server);
		$this->dbuse = trim($user);
		$this->dbpass = trim($pass);
		$this->dbname = trim($dbname);

		$this->dbConnect = @mysql_connect($this->dbserver , $this->dbuse , $this->dbpass );
		if($this->dbConnect){
			$this->dbSelected = @mysql_select_db($this->dbname,$this->dbConnect);
			if(!$this->dbSelected){
				die( $this->debug(mysql_error()) );
			}
		}else{
			die( $this->debug(mysql_error()) );
		}
	}

	/**
	 * @access public
	 * This is the select function .
	 *
	 * @param string $query which is the select statment
	 * @param string $limit which is the LIMIT part of the statement
	 * @return array it will be the result as a nested array
	 */
	function select($query , $pageNum=0 , $maxRows=0){
		$this->query = $query;

		if($maxRows > 0){
			$startRow = $pageNum * $maxRows;
			$this->query = sprintf('%s LIMIT %d, %d ' , $this->query , $startRow, $maxRows);
		}

		$result = @mysql_query($this->query) or die( $this->debug(mysql_error(),$this->query) );
		for ($i= 0 ; $i<mysql_num_rows($result);$i++){
			$rows = @mysql_fetch_assoc($result);
			$output[$i] = $rows;
		}

		//just freeing the memory
		mysql_free_result($result);
		return $output;
	}

	/**
	 * @access public
	 * This is the update function .
	 *
	 * @param string $table which is the table name that we are going to use.
	 * @param array $values which is the values of the fileds.
	 * @param string $where its the where condetion that we will use in the update statement
	 * by default this string will have the value NULL.
	 * @param string $limit which is the LIMIT part of the statement by default it takes the
	 * value 1.
	 * @return true or false.
	 */
	function update($table , $values , $where = 1 , $limit = 1){
		$this->tableName = trim($table);
		$this->value = $values;
		$this->where = $where;
		$this->limit = $limit;
		if(!is_array($this->value)){
			die($this->debug('The Value that you are trying to deal with is not an array'));
		}
		$count = 0;

		$this->query = 'update '.$this->tableName.' set ';
		foreach($this->value as $key => $val ){
				if($count == 0)
				{
					$this->query.=" `$key`= ".$val." " ;
				}else{
					$this->query.=" , `$key`= ". $val ." " ;
				}
				$count++;
		}

		$this->query.="  WHERE $this->where  LIMIT $this->limit ";
		$result = @mysql_query( $this->query ) or die( $this->debug(mysql_error(),$this->query) );
		 //if($this->affect()){
		 	$done = true ;
		 //}else{
		// 	$done = false ;
		//}

		return $done;
	}

	function fullUpdate($table , $values , $where = 1){
		$this->tableName = trim($table);
		$this->value = $values;
		$this->where = $where;
		if(!is_array($this->value)){
			die($this->debug('The Value that you are trying to deal with is not an array'));
		}
		$count = 0;

		$this->query = 'update '.$this->tableName.' set ';
		foreach($this->value as $key => $val ){
				if($count == 0)
				{
					$this->query.=" `$key`= ".$val." " ;
				}else{
					$this->query.=" , `$key`= ". $val ." " ;
				}
				$count++;
		}

		$this->query.="  WHERE $this->where  ";
		$result = @mysql_query( $this->query ) or die( $this->debug(mysql_error(),$this->query) );
	 	$done = true ;
		return $done;
	}

	/**
	 * @access public
	 * This is the insert function .
	 *
	 * @param string $table which is the table name that we are going to use.
	 * @param array $values which is the values of the fileds.
	 * @return true or false.
	 */
	function insert($table , $values ){
		$this->tableName = trim($table);
		$this->value = $values;
		if(!is_array($this->value)){
			die($this->debug('The Value that you are trying to deal with is not an array'));
		}
		$count = 0;

		foreach($this->value as $key => $val ){
				if($count == 0)
				{
					$this->fields =       "`".$key."`";
					$this->fieldsValues = $val;
				}else{
					$this->fields  .=     ", "."`".$key."`";
					$this->fieldsValues.= ", ".$val." ";
				}
				$count++;
		}

		$this->query = sprintf("insert into %s (%s) values(%s)",$this->tableName,$this->fields,$this->fieldsValues);
		$result = @mysql_query( $this->query ) or die( $this->debug(mysql_error(),$this->query) );

		if( $this->affect() ){
			$done = true ;
		}else{
			$done = false ;
		}
		return $done;
	}

	/**
	 * @access public
	 * This is the delete function .
	 *
	 * @param string $table which is the table name that we are going to use.
	 * @param string $where which is the where condetion.
	 * @return true or false.
	 */
	function delete($table , $where){
		$this->table = trim($table);
		$this->where = $where;

		$this->query = sprintf( "DELETE from %s WHERE %s" , $this->table , $this->where );

		$result = @mysql_query($this->query) or die($this->debug(mysql_error(),$this->query));

		if($this->affect()){
			$done = true;
		}else{
			$done = false;
		}

		return $done;
	}

	/**
	 * @access public
	 * the getNav function which will give you a paging result
	 * @param string $query this is the query to get the result
	 * @param integer $max this is the number of the max result also known as result per page
	 * @param integer $min this is the number of the start result
	 * @param integer $page this is the page number
	 *
	 * @return array this is the paging numbers
	 */
	 function getNav( $numRows, $max ,$pageVar="pager"){
		$this->rowsPerPage = $max ;
		$this->numRows = $numRows;
		$this->pageNum = 1 ;

//		if( $_GET['pager'] == 0 ){	$_GET['pager'] = 1;	}
		if(isset( $_GET['pager']) ){ $this->pageNum = $_GET['pager'];}
		
		$this->offset = ( $this->pageNum-1 ) * $this->rowsPerPage;

		if($this->numRows > 0 )
		{
			$queryString = "";
			if (!empty($_SERVER['QUERY_STRING'])) {
				$params = explode("&", $_SERVER['QUERY_STRING']);
				$newParams = array();
					foreach ($params as $param) {
						if (stristr($param, $pageVar) == false) {
							array_push($newParams, $param);
						}
					}
				if (count($newParams) != 0) {
					$queryString = "&" . htmlentities(implode("&", $newParams));
				}
			}		
			
			$maxpage = ceil ( $this->numRows / $this->rowsPerPage );
			$self = $_SERVER['PHP_SELF'];
			$nav ='';

			if( $this->pageNum == 0 ){
				$nav.='&nbsp;<strong>'.($this->pageNum+1).' / '.$maxpage.' Pages</strong>&nbsp;';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($this->pageNum+1).$queryString.'" title="'.($this->pageNum +1).'">&gt;</a>';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($maxpage-1).$queryString.'" title="'.$maxpage.'" >&raquo;</a>';
			}elseif($this->pageNum < $maxpage){
				$nav.='&nbsp;<a href="'.$self.'?pager=0'.$queryString.'" title="1" >&laquo;</a>';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($this->pageNum -1).$queryString.'" title="'.($this->pageNum -1).'">&lt;</a>';
				$nav.='&nbsp;<strong>'.($this->pageNum+1).' / '.$maxpage.' Pages</strong>&nbsp;';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($this->pageNum +1).$queryString.'" title="'.($this->pageNum +1).'" >&gt;</a>';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($maxpage-1).$queryString.'" title="'.$maxpage.'" >&raquo;</a>';
			}elseif($this->pageNum == $maxpage-1){
				$nav.='&nbsp;<a href="'.$self.'?pager=0'.$queryString.'" title="1"  >&laquo;</a>';
				$nav.='&nbsp;<a href="'.$self.'?pager='.($this->pageNum -1).$queryString.'" title="'.($this->pageNum -1).'">&lt;</a>';
				$nav.='&nbsp;<strong>'.($this->pageNum+1).' / '.$maxpage.' Pages</strong>';
			}

		}

		return $nav;

	 }
	

	/**/
	#########################################
	# some random functions to be used      #
	# inside the db class                   #
	#########################################
	# Start # # # # # # # # # # # # # # # # #
	#########################################

	// affected rows function
	function affect(){
		return @mysql_affected_rows();
	}

	// Custom Query function
	// Sometimes you need more than just insert,update,delete and select
	// there for i have this custom function which will return the query result
	// and you have to deal with it outside the class.

	function CQuery($query){
		$this->query = $query;
		$result = @mysql_query($this->query) or die($this->debug(mysql_error(),$this->query));
		if(!$result){
			die($this->debug(mysql_error(),$this->query));
		}elseif($this->getNum($result)<1){
			die($this->debug(mysql_error(),$this->query));
		}else{
			$row = mysql_fetch_array($result, MYSQL_NUM);
		}
		return $row[0];
	}

	// get the num rows
	function getNum($query){
		$this->query = $query;
		return @mysql_num_rows($this->query);
	}

	//decode html entites
	function decodeHTML($variable){
		$this->decode = trim($variable);
		return html_entity_decode($this->decode);
	}


	//clean the value and try to make it safe for intering the data;
	function clean($value){
		$this->value = trim($value);
		$this->value = htmlspecialchars(htmlentities($this->value));
		$value = "'".$this->value."'";
		return $value;
	}
	#########################################
	#  END  # # # # # # # # # # # # # # # # #
	#########################################

	function sqlSafe($value, $quote="'"){
	// strip quotes if already in
		$value = str_replace(array("\'","'"),"&#39;",$value);

		// Stripslashes
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		// Quote value
		//---start check it
		if(version_compare(phpversion(),"4.3.0")=="-1") {
			$value = @mysql_escape_string($value);
		} else {
			if(!$this->dbConnect){
				$this->debug(mysql_error());
			}
			$value = @mysql_real_escape_string($value);
		}
		//---end check it
		$value = $quote . $value . $quote;

		return $value;
	}

	#########################################
	# END OF OLD FUNCTIONS ##################
	#########################################

	/**
	 * @access public
	 * This is the debug function .
	 *
	 * @param string $error which is the mysql error value
	 * @param string $query which is the select statment
	 * @return array it will be the result as a nested array
	 */
	function debug($error , $query = NULL){
		$this->error = $error;
		$this->query = $query;
		$message ='<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Test.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SQL Debug</title>
<link type="text/css" rel="stylesheet" href="lib/debug/SyntaxHighlighter.css"></link>
</head>

<body>
<!-- InstanceBeginEditable name="Code" -->';
		$message.= '<div align="center" ><div style="width:90%;border:1px dashed red;font-size:15px;padding:15px;margin:10px;direction:ltr;text-align:left;">' .
				  '<p style="color:red;	font-weight:bolder;">&nbsp;&nbsp;' .
				  'ERROR :</p>' .
				  '<p style="direction:ltr;text-align:left;"><strong>' .$this->error. '</strong></p>' ;
		if(!is_null($this->query)){
		$message.= '<p> your SQL Statement was  :</p> ' .
				   '<p style="direction:ltr;text-align:left;"><pre name="code" class="sql">'.$this->query.'</pre></p>';
		}
		$message .='</div></div>';
		$message .='<!-- InstanceEndEditable -->
		<script class="javascript" src="lib/debug/shCore.js"></script>
		<script class="javascript" src="lib/debug/shBrushSql.js"></script>' .
	   '<script class="javascript">dp.SyntaxHighlighter.ClipboardSwf = \'lib/clipboard.swf\';' .
				'dp.SyntaxHighlighter.HighlightAll(\'code\');' .
	  '</script>' .
	  '</body></html>';
		return $message;
	}

	function close(){
		mysql_close($this->dbConnect);
	}
}
?>