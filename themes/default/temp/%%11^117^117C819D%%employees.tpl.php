<?php /* Smarty version 2.6.19, created on 2008-06-16 16:21:02
         compiled from site/emp/employees.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'site/emp/employees.tpl', 28, false),)), $this); ?>
<div class="titles">
		<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/group.gif" align="left" class="icon" alt="Employees"/>
		&nbsp;Employees
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
<?php endif; ?>
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%"><div align="center">Id</div></td>
		<td width="25%">Employee Name</td>
		<td width="50%">Department Name</td>
		<td align="center" width="10%"><div align="center">Active</div></td>
		<td align="center" width="10%"><div align="center">Edit</div></td>
		<td align="center" width="10%">Delete</td>
	</tr>
<?php unset($this->_sections['emp']);
$this->_sections['emp']['name'] = 'emp';
$this->_sections['emp']['loop'] = is_array($_loop=$this->_tpl_vars['employees']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['emp']['show'] = true;
$this->_sections['emp']['max'] = $this->_sections['emp']['loop'];
$this->_sections['emp']['step'] = 1;
$this->_sections['emp']['start'] = $this->_sections['emp']['step'] > 0 ? 0 : $this->_sections['emp']['loop']-1;
if ($this->_sections['emp']['show']) {
    $this->_sections['emp']['total'] = $this->_sections['emp']['loop'];
    if ($this->_sections['emp']['total'] == 0)
        $this->_sections['emp']['show'] = false;
} else
    $this->_sections['emp']['total'] = 0;
if ($this->_sections['emp']['show']):

            for ($this->_sections['emp']['index'] = $this->_sections['emp']['start'], $this->_sections['emp']['iteration'] = 1;
                 $this->_sections['emp']['iteration'] <= $this->_sections['emp']['total'];
                 $this->_sections['emp']['index'] += $this->_sections['emp']['step'], $this->_sections['emp']['iteration']++):
$this->_sections['emp']['rownum'] = $this->_sections['emp']['iteration'];
$this->_sections['emp']['index_prev'] = $this->_sections['emp']['index'] - $this->_sections['emp']['step'];
$this->_sections['emp']['index_next'] = $this->_sections['emp']['index'] + $this->_sections['emp']['step'];
$this->_sections['emp']['first']      = ($this->_sections['emp']['iteration'] == 1);
$this->_sections['emp']['last']       = ($this->_sections['emp']['iteration'] == $this->_sections['emp']['total']);
?>
	<tr class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
 box ">
		<td align="center"><?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['id']; ?>
</td>
		<td align="left">
			<a class="myLink" href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=empInfo&amp;id=<?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['id']; ?>
" title="Employee Information :: <?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['empName']; ?>
" ><?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['empName']; ?>
</a></td>
		<td align="left"><?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['depName']; ?>
</td>
		<td align="center">
			<div align="center"><a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=active&amp;status=<?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['active']; ?>
&amp;id=<?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['id']; ?>
">
		    <?php if ($this->_tpl_vars['employees'][$this->_sections['emp']['index']]['active'] == '1'): ?>
			  <img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/status_online.gif" class="icon" />
		    <?php elseif ($this->_tpl_vars['employees'][$this->_sections['emp']['index']]['active'] == '0'): ?>
			  <img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/status_offline.gif" class="icon" />
		    <?php endif; ?>			</a> </div></td>
		<td align="center">
			<div align="center"><a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=editForm&amp;id=<?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['id']; ?>
">
			  <img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/user_edit.gif" class="icon" alt="Edit <?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['empName']; ?>
"/>			</a> </div></td>
		<td align="center">
			<a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=delete&amp;id=<?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['id']; ?>
" onclick="return confirm('Are you sure ?\nDeleting the employee will delete all his related information.\nThis action cant be undo');">
				<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/user_delete.gif" class="icon" alt="delete <?php echo $this->_tpl_vars['employees'][$this->_sections['emp']['index']]['empName']; ?>
"/>			</a>		</td>
	</tr>
<?php endfor; else: ?>
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Employees in the database yet..</div>		</td>
	</tr>
<?php endif; ?>
</table>
<div class="nav"><?php echo $this->_tpl_vars['nav']; ?>
</div>