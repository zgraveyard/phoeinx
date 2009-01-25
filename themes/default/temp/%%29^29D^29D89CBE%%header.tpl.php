<?php /* Smarty version 2.6.19, created on 2008-06-16 15:38:15
         compiled from site/header.tpl */ ?>
<div class="header"><?php echo $this->_tpl_vars['config']['title']; ?>
</div>
<?php if ($this->_tpl_vars['showMenu'] == 1): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'site/menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<div id="errorMSG"></div>