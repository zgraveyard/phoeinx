<?php /* Smarty version 2.6.19, created on 2008-06-16 15:38:15
         compiled from site/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'site/index.tpl', 38, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
<title><?php echo $this->_tpl_vars['config']['title']; ?>
</title>
<link rev="made" href="mailto:linux.juggler@gmail.com">
<meta name="keywords" content="management,managements,projects,project,gant chart,linux,php,mysql,ajax,zaher">
<meta name="description" content="This is our grad project , where we try to create a project management program like ( MS Project ) , but with our own ideas .">
<meta name="author" content="Mhd zaher Ghaibeh and others">
<meta name="ROBOTS" content="NONE">
<style>
	  @import url("<?php echo $this->_tpl_vars['config']['url']; ?>
/themes/<?php echo $this->_tpl_vars['config']['theme']; ?>
/style/style_ff.css");
	  @import url("<?php echo $this->_tpl_vars['config']['url']; ?>
/themes/<?php echo $this->_tpl_vars['config']['theme']; ?>
/style/chromestyle.css");
<!--[if IE]>
		@import url("<?php echo $this->_tpl_vars['config']['url']; ?>
/themes/<?php echo $this->_tpl_vars['config']['theme']; ?>
/style/style.css");
<![endif]-->
</style>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/prototype/prototype.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/lowpro.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/chrome.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/prototype/scriptaculous.js?load=effects,controls"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/control.modal.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/scripts/validation.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/scripts/scripts.js"></script>
		<link rel="stylesheet" href="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/date2/default.css" type="text/css" />
		<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/date2/date.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/date2/format_american.js"></script>
		<script type="text/javascript" language="javascript"> var website='<?php echo $this->_tpl_vars['config']['url']; ?>
';</script>

	</head>
	<body>
<div id="loading" style="position:absolute;z-index:3;background:#c44;color:white;font-size:75%;top:1px;right:1px;padding:2px;">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/sloading.gif" align="left" />&nbsp;Loading ....
</div>
		<div id="content" class="content">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "site/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=@$this->_tpl_vars['incFile'])) ? $this->_run_mod_handler('default', true, $_tmp, "site/empty.tpl") : smarty_modifier_default($_tmp, "site/empty.tpl")), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp='site/footer.tpl')) ? $this->_run_mod_handler('default', true, $_tmp, "site/empty.tpl") : smarty_modifier_default($_tmp, "site/empty.tpl")), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</body>
</html>