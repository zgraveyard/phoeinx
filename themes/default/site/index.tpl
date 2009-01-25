<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
<title>{$config.title}</title>
<link rev="made" href="mailto:linux.juggler@gmail.com">
<meta name="keywords" content="management,managements,projects,project,gant chart,linux,php,mysql,ajax,zaher">
<meta name="description" content="This is our grad project , where we try to create a project management program like ( MS Project ) , but with our own ideas .">
<meta name="author" content="Mhd zaher Ghaibeh and others">
<meta name="ROBOTS" content="NONE">
<style>
	  @import url("{$config.url}/themes/{$config.theme}/style/style_ff.css");
	  @import url("{$config.url}/themes/{$config.theme}/style/chromestyle.css");
<!--[if IE]>
		@import url("{$config.url}/themes/{$config.theme}/style/style.css");
<![endif]-->
</style>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/prototype/prototype.js"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/lowpro.js"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/chrome.js"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/prototype/scriptaculous.js?load=effects,controls"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/control.modal.js"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/scripts/validation.js"></script>
		<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/scripts/scripts.js"></script>
		<link rel="stylesheet" href="{$config.url}/lib/jscript/date2/default.css" type="text/css" />
		<script language="javascript" type="text/javascript" src="{$config.url}/lib/jscript/date2/date.js"></script>
		<script language="javascript" type="text/javascript" src="{$config.url}/lib/jscript/date2/format_american.js"></script>
		<script type="text/javascript" language="javascript"> var website='{$config.url}';</script>

	</head>
	<body>
<div id="loading" style="position:absolute;z-index:3;background:#c44;color:white;font-size:75%;top:1px;right:1px;padding:2px;">
	<img src="{$config.url}/images/sloading.gif" align="left" />&nbsp;Loading ....
</div>
		<div id="content" class="content">
			{include file="site/header.tpl"}
			{include file=$incFile|default:"site/empty.tpl"}
			{include file='site/footer.tpl'|default:"site/empty.tpl"}
		</div>
	</body>
</html>