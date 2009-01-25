<?php /* Smarty version 2.6.19, created on 2008-06-21 11:50:00
         compiled from site/emp/employee.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'site/emp/employee.tpl', 50, false),)), $this); ?>
<div>
<?php if ($this->_tpl_vars['showClose'] == 1): ?>
	<span style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</span>
<?php endif; ?>
<br /><center>
	<div style="width:90%;padding:3px;margin:3px;border-bottom:1px solid #000;text-align:left;">
			<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/user.gif" align="left" class="icon" alt="Clients"/>
			&nbsp;Employee Information
	</div>
</center>
<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="200px;" valign="top"><label>Employee Name</label></td>
		<td><?php echo $this->_tpl_vars['info']['name']; ?>
</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Nationality</label></td>
		<td><?php echo $this->_tpl_vars['info']['cn']; ?>
</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Birth Year</label></td>
		<td><?php echo $this->_tpl_vars['info']['birth_date']; ?>
</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Gender</label></td>
		<td><?php if ($this->_tpl_vars['info']['gender'] == '1'): ?>Male<?php else: ?>Female<?php endif; ?></td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Certificate</label></td>
		<td><?php echo $this->_tpl_vars['info']['certificate']; ?>
</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Work Position</label></td>
		<td><?php echo $this->_tpl_vars['info']['posName']; ?>
</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Experince</label></td>
		<td><?php echo $this->_tpl_vars['info']['experince']; ?>
</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Department</label></td>
		<td><?php echo $this->_tpl_vars['info']['depname']; ?>
</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Mobile</label></td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['mobile'])) ? $this->_run_mod_handler('default', true, $_tmp, 'no entery') : smarty_modifier_default($_tmp, 'no entery')); ?>
</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Phone</label></td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['phone'])) ? $this->_run_mod_handler('default', true, $_tmp, 'no entery') : smarty_modifier_default($_tmp, 'no entery')); ?>
</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Address</label></td>
		<td><?php echo $this->_tpl_vars['info']['address']; ?>
</td>
	</tr>			
</table>
</div>