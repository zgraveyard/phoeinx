<?php /* Smarty version 2.6.19, created on 2008-06-21 11:49:37
         compiled from site/emp/allpositions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'site/emp/allpositions.tpl', 8, false),)), $this); ?>
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%" ><div align="center">Id</div></td>
		<td >Position Title</td>
		<td align="center" width="10%" ><div align="center">Delete</div></td>
	</tr>
<?php unset($this->_sections['pos']);
$this->_sections['pos']['name'] = 'pos';
$this->_sections['pos']['loop'] = is_array($_loop=$this->_tpl_vars['positions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pos']['show'] = true;
$this->_sections['pos']['max'] = $this->_sections['pos']['loop'];
$this->_sections['pos']['step'] = 1;
$this->_sections['pos']['start'] = $this->_sections['pos']['step'] > 0 ? 0 : $this->_sections['pos']['loop']-1;
if ($this->_sections['pos']['show']) {
    $this->_sections['pos']['total'] = $this->_sections['pos']['loop'];
    if ($this->_sections['pos']['total'] == 0)
        $this->_sections['pos']['show'] = false;
} else
    $this->_sections['pos']['total'] = 0;
if ($this->_sections['pos']['show']):

            for ($this->_sections['pos']['index'] = $this->_sections['pos']['start'], $this->_sections['pos']['iteration'] = 1;
                 $this->_sections['pos']['iteration'] <= $this->_sections['pos']['total'];
                 $this->_sections['pos']['index'] += $this->_sections['pos']['step'], $this->_sections['pos']['iteration']++):
$this->_sections['pos']['rownum'] = $this->_sections['pos']['iteration'];
$this->_sections['pos']['index_prev'] = $this->_sections['pos']['index'] - $this->_sections['pos']['step'];
$this->_sections['pos']['index_next'] = $this->_sections['pos']['index'] + $this->_sections['pos']['step'];
$this->_sections['pos']['first']      = ($this->_sections['pos']['iteration'] == 1);
$this->_sections['pos']['last']       = ($this->_sections['pos']['iteration'] == $this->_sections['pos']['total']);
?>
	<tr class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
 box " id="pos_<?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
">
		<td align="center"><?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
</td>
		<td align="left">
			<div id="editMe_<?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['name']; ?>
</div>
		<script type="text/javascript">editMe(<?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
,'<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&modload=employees&file=position&action=save&id=<?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
');</script>		</td>
		<td align="center">
			<div align="center">
			<a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/module.php?act=load&amp;modload=employees&amp;file=position&amp;action=delete&amp;id=<?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['id']; ?>
"
				onclick="return confirm('Are you sure ?\nDeleting the position will delete all his related information.\nThis action cant be undo.');">
			  <img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/table_delete.gif" class="icon" alt="delete <?php echo $this->_tpl_vars['positions'][$this->_sections['pos']['index']]['name']; ?>
"/>
	    </a>	        </div></td>
	</tr>
<?php endfor; else: ?>
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Positions in the database yet..</div>		</td>
	</tr>
<?php endif; ?>
</table>