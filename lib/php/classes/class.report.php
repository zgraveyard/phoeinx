<?php
/*
 *

**********************
*
* class.report.php, v 1.7 2007/07/15 willis : wvandevanter AT gmail.com
*
**********************

*/

//require_once "Smarty/Smarty.class.php";
//require_once "providedUtilities/fpdf/fpdf.php";
//require_once "providedUtilities/ziplib.php";

class report
{
	var $fileName = "";
	var $filetype = "";
	var $LastError = "";
	var $smarty = "";
	var $pdf = "";
	var $baseDir="";
	var $default = "xml";
	var $baseName = "report";
	var $reportText = "";
	var $header = "";
	var $footer = "";
	var $nonSeperated = "";
	var $supported = array("txt" => "txt",
			       "odt" => "odt",
			       "pdf" => "pdf",
			       "doc" => "doc",
			       "xml" => "xml",
			       "html" => "html",
			      );

 	/**********************************
	 * Default Constructor.
         *  - create smarty and pdf object
	 * Returns nothing
	 **********************************/

	function report(){
	  $this->createPDF();
	  $this->createSmarty();
	}


	/**************
	*  addPage()
	*
	*  - add a single report to a multi-report package
	*  - grabs the current output of the report, saves it, clears the template to add more
	*
        *  @returns none
	*
	***************/

	function addPage(){

  	  if($this->g_filetype() == "pdf"){
  	    $this->addPDFText();
	  }else{
	   $this->reportText = $this->reportText.$this->smarty->fetch($this->g_baseDir().$this->g_baseName().'.'.$this->g_filetype().'.tpl');
          }
	   $this->createSmarty();

	}

	/******************
	*  addPDFText()
	*
	*
	*  @returns content of the PDF
	*
	******************/

	function addPDFText(){

  	  $this->pdf->AddPage();
	  $content = array();

//	  $content = preg_split("/;~~;/",$this->smarty->fetch($this->g_baseDir().'report.pdf.tpl'));
	  $content = preg_split("/;~~;/",$this->smarty->fetch($this->g_baseDir().$this->g_fileName()));
	  foreach($content as $value){
	   //print "CMD:$value <br>"; //for debugging
	   if( strlen($value) > 1){  eval("\$this->pdf->$value;"); }
	    }

	}

	/**************
	*  createPDF()
	*
	*
	*
        *  @returns contents of the PDF
	*
	***************/

	function createPDF(){
	  unset($this->pdf);

	  $this->pdf=new FPDF();
	}


	/************
	*  createSmarty()
	*
	*  This method is to be used anytime a smarty object needs to be created (even if one already exists, fascilitates garbage collection).
	*
	*  @returns nothing
	*************/

	function createSmarty(){
      unset($this->smarty);  //clear the current smarty object
	  global $config;
	  $this->smarty = new Smarty;
	  $this->smarty->template_dir = $config['dir'].'/themes/'.$config['theme'].'/';
	  $this->smarty->compile_dir = $config['dir'].'/themes/'.$config['theme'].'/temp';
	}

	/**************
	*  g_basename()
	*
	*  @returns the default base filename (default is report) for the report
	*
	***************/

      function g_baseName(){

         return $this->baseName;

        }

	/**************
	*  g_default()
	*
	*  @returns the default file type for the report
	*
	***************/

      function g_default(){

	return $this->default;

	}

	/**************
	*  g_baseDir()
	*
	*  @returns the filetype of the current report
	*
	***************/

       function g_baseDir(){

	   return $this->baseDir;

       }
	/**************
	*  g_filetype()
	*
	*  @returns the filetype of the current report
	*
	***************/

       function g_filetype (){

	   return $this->filetype;

       }

	/**************
	*  g_footer()
	*
	*  @returns the footer of the current report
	*
	***************/

	function g_footer(){

	   return $this->footer;

	}


	/**************
	*  g_header()
	*
	*  @returns the header of the current report
	*
	***************/

	function g_header(){

	   return $this->header;

	}

	/**************
	*  g_nonSeperated()
	*
	*  @returns the state of seperation of the current report
	*
	***************/

	function g_nonSeperated(){

	   return $this->nonSeperated;

	}

	/**************
	*  is_supported()
	*
	*  @input the filetype to check for
	*  @returns if the filetype is supported
	*
	***************/

      function is_supported ($filetype){
	if(strlen($this->supported[$filetype]) > 0){
	   return TRUE;
	}else{
	   return FALSE;
	}
      }

	/**************
	*  printReport()
	*
	*  - modifies the header of the file to send the report, rather than display it in the browser
	*   - thank you to http://www.floridia.net/en/OpenDocumentFormat/Artigo/html/index.htm which I followed for the ODT reports
        *  @returns the report
	*
	***************/

       function printReport($filename){

	 if($this->g_filetype() == "pdf"){  //use the fpdf's outfunction to gather the binary data
  	   $this->reportText =  $this->pdf->Output("report",s);
	 }
	 if($this->g_filetype() == "odt"){ //the odt file must be zipped

	    $zipfile = new ZipWriter("Comment", $filename.".odt", "application/odt");
            $ooofiles = array(
		   "mimetype",
                   "styles.xml",
		   "meta.xml",
                   "settings.xml",
                   "META-INF/manifest.xml",
             );

	     foreach ($ooofiles as $file) {
  		$filedata = file_get_contents("ooFiles/$file");
    		$zipfile -> AddRegularFile($file, $filedata);
	       }

	  //content.xml should be in reportText
  	  $zipfile -> AddRegularFile("content.xml", $this->odtHeader().$this->reportText.$this->odtFooter());

	  print $zipfile->finish();

	}else{
	  if($this->g_filetype() == "xml"){
	     $this->reportText = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n <osvdb_report> \n".$this->reportText."\n </osvdb_report>";
	  }

	  if($this->g_filetype() == "html" && $this->g_nonSeperated() == t){

		$this->reportText = $this->g_header().$this->reportText.$this->g_footer().$this->smarty->fetch("footer_noad.html.tpl");

	  }

	  header("Content-Description: File Transfer");
 	  header("Content-Type: application/".$this->g_filetype());
 	  header("Content-Length:".strlen($this->reportText));  //not correct for binary formats
 	  header("Content-Disposition: attachment; filename=".$filename.".".$this->g_filetype());
	  print $this->reportText;

 	 }
	}

	/*****
	* recursiveSanitize
	*
	* if the $value to sanitize is a array or an object, then scroll through it
	*
	*******/


	function recursiveSanitize($value){

	 if(is_array($value)){
            //print_r($value);

	    foreach($value as $key => &$val){
		$val = $this->recursiveSanitize($val);
  	    }

            //print_r($value);
	 }else if(is_object($value)){

            foreach (get_object_vars($value) as $key => $val) {
                $value->$key = $this->recursiveSanitize($val);
            }

	 }else{
	  if($this->g_filetype() == "pdf"){
            $value = $this->sanitizePDF($value);
          }else{
	    $value = $this->sanitizeODT($value);
	  }
        }

	  return $value;
	}


	/**************
	*  sanitizeODT()
	*
	*  -sanitize input
	*  - list execution possibilities (XSS sources)
	*
	*  @input the string to sanitize
        *  @return sanitized text
	*
	***************/

	function sanitizeODT($value){

        if(is_array($value) || is_object($value)){

	    $value = $this->recursiveSanitize($value);

	 }else{
	    if(is_string($value)){
	     $value = str_replace("<","&lt; ",$value);
	     $value = str_replace(">"," &gt;",$value);
  	     $value = str_replace("&",'&amp;',$value);
            }
 	  }
          return $value;
	}

	/**************
	*  sanitizePDF()
	*
	*  -sanitize input, as it will be eval'd
	*  - list execution possibilities (XSS sources)
	*
	*  @input the string to sanitize
        *  @return sanitized text
	*
	***************/

	function sanitizePDF($value){

	if(is_array($value) || is_object($value)){

		$value = $this->recursiveSanitize($value);

	  }else{
	    if(is_string($value)){
   	      $value = str_replace(";~~;",";~~~;",$value);  //replace ;~~;
   	      $value = str_replace('"',"''",$value);  //replace "
	     }
          }
         return $value;
	}

	/**************
	*  s_baseName()
	*
	*  the template used by the report is "report".filetype.tpl
	* to use something other than "report", set it here
	*
        *  @input the baseName other than "report"
	*
	***************/

      function s_baseName($name){
	 $this->baseName = $name;
	}

	/**************
	*  s_baseDir()
    *  @input the baseDir other than ""
	***************/

    function s_baseDir($name){
	 $this->baseDir = $name;
	}

	/**************
	*  s_default()
	*
        *  @input the filetype to set as the default
	*
	***************/

      function s_default($default){
	 $this->default = $default;
	return TRUE;

	}

	/**************
	*  s_filetype()
	*
        *  @input the filetype to set for this report
	*
	***************/

       function s_filetype ($filetype){

	 $this->filetype=$filetype;
	 return TRUE;

	}

	/**************
	*  s_footer()
	*
        *  @input the footer to set for this report
	*
	***************/

	function s_footer ($footer){

	 $this->footer = $footer;
	 return TRUE;

	}


	/**************
	*  s_header()
	*
        *  @input the header to set for this report
	*
	***************/

	function s_header ($header){

	 $this->header = $header;
	 return TRUE;

	}


	/**************
	*  s_nonSeperated()
	*
        *  @input the header to set for this report
	*
	***************/

	function s_nonSeperated ($sep){

	 $this->nonSeperated = $sep;
	 return TRUE;

	}



/************************************************
*  The following are osvdb specific details and can be replaced
*     IF being used on another system.
*
*
************************************************/

	/*********************

        Unfortunetly this hideous garbage needs to be stored in here for multi-page
	   odt reports.

	*********************/


     function odtHeader(){
	$headerInfo = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>

<office:document-content xmlns:office=\"urn:oasis:names:tc:opendocument:xmlns:office:1.0\" xmlns:style=\"urn:oasis:names:tc:opendocument:xmlns:style:1.0\" xmlns:text=\"urn:oasis:names:tc:opendocument:xmlns:text:1.0\" xmlns:table=\"urn:oasis:names:tc:opendocument:xmlns:table:1.0\" xmlns:draw=\"urn:oasis:names:tc:opendocument:xmlns:drawing:1.0\" xmlns:fo=\"urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:meta=\"urn:oasis:names:tc:opendocument:xmlns:meta:1.0\" xmlns:number=\"urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0\" xmlns:svg=\"urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0\" xmlns:chart=\"urn:oasis:names:tc:opendocument:xmlns:chart:1.0\" xmlns:dr3d=\"urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0\" xmlns:math=\"http://www.w3.org/1998/Math/MathML\" xmlns:form=\"urn:oasis:names:tc:opendocument:xmlns:form:1.0\" xmlns:script=\"urn:oasis:names:tc:opendocument:xmlns:script:1.0\" xmlns:ooo=\"http://openoffice.org/2004/office\" xmlns:ooow=\"http://openoffice.org/2004/writer\" xmlns:oooc=\"http://openoffice.org/2004/calc\" xmlns:dom=\"http://www.w3.org/2001/xml-events\" xmlns:xforms=\"http://www.w3.org/2002/xforms\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" office:version=\"1.0\">
              ";
	   return $headerInfo;
	}

	function odtFooter(){
	 $footer ="</office:document-content>";
	  return $footer;
	}


	/************************
	* SMARTY METHODS
	*
	*************************/

       function assign($name, $value){
	  //print "BEFORE $value <br>";

          if($this->g_filetype() == "pdf" && $name != "params"){ $value = $this->sanitizePDF($value); }
	  if(($this->g_filetype() == "odt" || $this->g_filetype() == "xml" || $this->g_filetype() == "html" || $this->g_filetype() == "doc") && $name != "params" && $name != "ERROR"){ $value = $this->sanitizeODT($value); }

          //print "AFTER $value <Br>";

          $this->smarty->assign($name,$value);

	}

      function assign_by_ref($name, $value){
          //print "BEFORE $name $value ";

          if($this->g_filetype() == "pdf"){ $value = $this->sanitizePDF($value); }
	  if($this->g_filetype() == "odt" || $this->g_filetype() == "xml" ||  $this->g_filetype() == "html" || $this->g_filetype() == "doc"){ $value = $this->sanitizeODT($value); }


	  //print "AFTER $name $value <br>";

          $this->smarty->assign_by_ref($name,$value);

	}


      function display($template){

 	$this->smarty->display($template);

      }

      function fetch($template){

	return $this->smarty->fetch($template);

	}

	function s_fileName($name){
		$this->fileName = $name;
	}

	function g_fileName(){
		return $this->fileName;
	}

}
?>