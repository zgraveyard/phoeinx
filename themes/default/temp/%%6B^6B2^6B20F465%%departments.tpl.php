<?php /* Smarty version 2.6.19, created on 2008-06-21 11:49:26
         compiled from site/emp/departments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'site/emp/departments.tpl', 34, false),)), $this); ?>
<div class="titles">
		<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/telephone.gif" align="left" class="icon" alt="Departments"/>
		&nbsp;Departments
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
	&nbsp;The Department you choose can't be deleted ,
	because it has Child departments or an employees belongs to it .. </div>
<?php endif; ?>
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%"><div align="center">Id</div></td>
		<td width="25%">Department Name</td>
		<td width="45%">Department Path</td>
		<td width="15%" align="center" >Employees Count</td>
		<td align="center" width="10%"><div align="center">Edit</div></td>
		<td align="center" width="10%">Delete</td>
	</tr>
<?php unset($this->_sections['dep']);
$this->_sections['dep']['name'] = 'dep';
$this->_sections['dep']['loop'] = is_array($_loop=$this->_tpl_vars['departments']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['dep']['show'] = true;
$this->_sections['dep']['max'] = $this->_sections['dep']['loop'];
$this->_sections['dep']['step'] = 1;
$this->_sections['dep']['start'] = $this->_sections['dep']['step'] > 0 ? 0 : $this->_sections['dep']['loop']-1;
if ($this->_sections['dep']['show']) {
    $this->_sections['dep']['total'] = $this->_sections['dep']['loop'];
    if ($this->_sections['dep']['total'] == 0)
        $this->_sections['dep']['show'] = false;
} else
    $this->_sections['dep']['total'] = 0;
if ($this->_sections['dep']['show']):

            for ($this->_sections['dep']['index'] = $this->_sections['dep']['start'], $this->_sections['dep']['iteration'] = 1;
                 $this->_sections['dep']['iteration'] <= $this->_sections['dep']['total'];
                 $this->_sections['dep']['index'] += $this->_sections['dep']['step'], $this->_sections['dep']['iteration']++):
$this->_sections['dep']['rownum'] = $this->_sections['dep']['iteration'];
$this->_sections['dep']['index_prev'] = $this->_sections['dep']['index'] - $this->_sections['dep']['step'];
$this->_sections['dep']['index_next'] = $this->_sections['dep']['index'] + $this->_sections['dep']['step'];
$this->_sections['dep']['first']      = ($this->_sections['dep']['iteration'] == 1);
$this->_sections['dep']['last']       = ($this->_sections['dep']['iteration'] == $this->_sections['dep']['total']);
?>
	<tr class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
 box ">
		<td align="center"><?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['id']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['name']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['path']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['count']; ?>
</td>
		<td align="center">
			<a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=department&amp;action=editForm&amp;id=<?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['id']; ?>
">
			<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/telephone_edit.gif" class="icon" alt="edit <?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['name']; ?>
"/>			</a></td>
		<td align="center">
			<a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=department&amp;action=delete&amp;id=<?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['id']; ?>
" onclick="return confirm('Are you sure ?\nThis will delete the child departments also');">
				<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/telephone_delete.gif" class="icon" alt="delete <?php echo $this->_tpl_vars['departments'][$this->_sections['dep']['index']]['name']; ?>
"/>			</a>		</td>
	</tr>
<?php endfor; else: ?>
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no departments in the database yet..</div>		</td>
	</tr>
<?php endif; ?>
</table>
<div class="nav"><?php echo $this->_tpl_vars['nav']; ?>
</div>