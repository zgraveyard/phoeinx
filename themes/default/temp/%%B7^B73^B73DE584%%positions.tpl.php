<?php /* Smarty version 2.6.19, created on 2008-06-21 11:49:37
         compiled from site/emp/positions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', 'site/emp/positions.tpl', 1, false),)), $this); ?>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo '<script>Event.observe(window,\'load\',function(){ addPos(); openME(\'add\'); });</script>'; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<div class="titles">
		<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/group.gif" align="left" class="icon" alt="Employees"/>
		&nbsp;Employees Positions
</div>
<div class="right">
	<a href="javascript:void(0);" id="add" class="aLink" >
		<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/add.gif" class="icon" />Add new position</a>&nbsp;<span id="note"></span>
	<div id="addMeForm" style="display:none;">
	<form id="addForm" name="addForm" action="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&modload=employees&file=position" method="post">
		<label for="Position Title">Position Title <input type="text" size="50" class="required" maxlength="255" name="title" id="title" /></label>
		<input type="hidden" name="action" value="add"/>
		<input type="submit" name="sbt" id="sbt" value="Add"/>
	</form>
	<script>var valid = new Validation('addForm');</script>
	</div>
</div>
<?php if ($_GET['done'] == '1'): ?>
<div class="right">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/accept.gif" class="icon" align="left" alt="Your request has been performed successfully"/>
	&nbsp;Your request has been performed successfully . </div>
<?php elseif ($_GET['error'] == '1'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;An error accrued while we were trying to perform your request , please try again later .. </div>
<?php elseif ($_GET['error'] == '2'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You didnt specify a record to delete , please try again .. </div>
<?php elseif ($_GET['error'] == '3'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You cant delete this position because there is employees belongs to it.. </div>
<?php endif; ?>
<div id="update">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'site/emp/allpositions.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>