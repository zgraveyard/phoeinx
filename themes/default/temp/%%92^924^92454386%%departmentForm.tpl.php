<?php /* Smarty version 2.6.19, created on 2008-06-21 11:49:28
         compiled from site/emp/departmentForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'site/emp/departmentForm.tpl', 4, false),array('function', 'html_options', 'site/emp/departmentForm.tpl', 39, false),array('block', 'head', 'site/emp/departmentForm.tpl', 55, false),)), $this); ?>
<div>
	<div class="titles">
			<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/telephone_<?php echo $this->_tpl_vars['act']; ?>
.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['act'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 Departments
	</div>
<?php if ($_GET['error'] == '1'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/exclamation.gif" class="icon" align="left" alt="error .."/>
	&nbsp;Please fill all required feilds .. </div>
<?php elseif ($_GET['error'] == '2'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/exclamation.gif" class="icon" align="left" alt="error .."/>
	&nbsp;It seems we have a problems with this record , can you please retry again. </div>
<?php elseif ($_GET['error'] == '3'): ?>
<div class="error">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/emoticon_surprised.gif" class="icon" align="left" alt="surprised"/>
	&nbsp;You must be kidding right &nbsp;&nbsp;?!
	&nbsp;Fill all required feilds .. </div>
<?php elseif ($_GET['error'] != '1'): ?>
<div class="hint">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/lightbulb.gif" class="icon" align="left" alt="Hint .."/>
	&nbsp;Remember to enter all required fields . </div>
<?php endif; ?>
<p>&nbsp;</p>
<form name="addForm" id="addForm" action="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&modload=employees&file=department" method="post">
<div class="box_container">
<table border="0" cellpadding="5" cellspacing="0" width="100%" class="table_container3">
	<tr class="box">
		<td width="20%"><label>Department Name </label>:</td>
		<td width="80%">
			<input name="depName" type="text" class="required" id="depName" style="width:300px" value="<?php echo $this->_tpl_vars['info']['name']; ?>
" size="30" />
		</td>
	</tr>
	<tr class="box">
		<td><label>Department Father </label>:</td>
		<td>
			<select name="fatherId" style="width:300px;">
				<option value="0">Main Department</option>
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['departments']['path'],'selected' => $this->_tpl_vars['info']['fatherId']), $this);?>

			</select>
		</td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" value="<?php echo $this->_tpl_vars['act']; ?>
" id="action" />
			<input type="hidden" name="did" value="<?php echo $_GET['id']; ?>
" id="did" />
			<input type="hidden" name="fid" value="<?php echo $this->_tpl_vars['info']['fatherId']; ?>
" id="fid" />
		</td>
		<td>
			<input type="submit" value="&nbsp;&nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['act'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 Department &nbsp;&nbsp;" />
		</td>
	</tr>
</table></div>
</form>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/scripts/validation.js"></script><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<script>var valid = new Validation('addForm');</script>
</div>