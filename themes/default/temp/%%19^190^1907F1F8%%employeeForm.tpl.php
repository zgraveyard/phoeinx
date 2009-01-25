<?php /* Smarty version 2.6.19, created on 2008-06-21 11:49:45
         compiled from site/emp/employeeForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'site/emp/employeeForm.tpl', 4, false),array('modifier', 'default', 'site/emp/employeeForm.tpl', 33, false),array('function', 'html_options', 'site/emp/employeeForm.tpl', 33, false),array('function', 'html_select_date_adv', 'site/emp/employeeForm.tpl', 46, false),array('block', 'head', 'site/emp/employeeForm.tpl', 80, false),)), $this); ?>
<div>
<div class="titles">
	<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/user_<?php echo $this->_tpl_vars['action']; ?>
.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['action'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 Employee
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
<form name="addForm" id="addForm" action="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&modload=employees&file=employee" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="160" valign="top">Employee Name</td>
		<td width="572"><input type="text" id="ename" name="ename" size="30" class="required" value="<?php echo $this->_tpl_vars['info']['name']; ?>
" /></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Nationality</td>
		<td><?php echo smarty_function_html_options(array('name' => 'ci','options' => $this->_tpl_vars['country'],'style' => "width:265px;",'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['nationality'])) ? $this->_run_mod_handler('default', true, $_tmp, '148') : smarty_modifier_default($_tmp, '148'))), $this);?>
</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Department</td>
		<td><?php echo smarty_function_html_options(array('name' => 'dep_id','options' => $this->_tpl_vars['departments'],'style' => "width:265px;",'selected' => $this->_tpl_vars['info']['dep_id']), $this);?>
</td>
	</tr>	
	<tr class="box">
		<td width="160" valign="top">Employee Work Position</td>
		<td><?php echo smarty_function_html_options(array('name' => 'pos_id','options' => $this->_tpl_vars['pos_id'],'style' => "width:265px;",'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['pos_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '148') : smarty_modifier_default($_tmp, '148'))), $this);?>
</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Birth Year</td>
		<td>			<?php echo smarty_function_html_select_date_adv(array('start_year' => -50,'display_months' => false,'display_days' => false,'year_first_opt_selected' => $this->_tpl_vars['info']['birth_date']), $this);?>
		</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Gender</td>
		<td><?php echo smarty_function_html_options(array('name' => 'gender','options' => $this->_tpl_vars['gender'],'style' => "width:265px;",'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['gender'])) ? $this->_run_mod_handler('default', true, $_tmp, '1') : smarty_modifier_default($_tmp, '1'))), $this);?>
</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Certificate</td>
		<td><textarea name="certificate" id="certificate" class="required" rows="5" cols="50"><?php echo $this->_tpl_vars['info']['certificate']; ?>
</textarea></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Experince</td>
		<td><textarea name="experince" id="experince" class="required" rows="5" cols="50"><?php echo $this->_tpl_vars['info']['experince']; ?>
</textarea></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Mobile</td>
		<td><input type="text" id="emobile" name="emobile" size="20"  class="validate-number" value="<?php echo $this->_tpl_vars['info']['mobile']; ?>
"/></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Phone</td>
		<td><input type="text" id="ephone" name="ephone" size="20"  class="validate-number" value="<?php echo $this->_tpl_vars['info']['phone']; ?>
" /></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Address</td>
		<td><textarea name="eaddress" id="eaddress" class="required" rows="5" cols="50"><?php echo $this->_tpl_vars['info']['address']; ?>
</textarea></td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
			<input type="hidden" name="empId" id="empId" value="<?php echo $_GET['id']; ?>
" />		</td>
		<td><input type="submit" id="btn" name="btn" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['action'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 Employee" /></td>
	</tr>
</table></div>
</form>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['config']['url']; ?>
/lib/jscript/scripts/validation.js"></script><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<script>var valid = new Validation('addForm');</script>
</div>