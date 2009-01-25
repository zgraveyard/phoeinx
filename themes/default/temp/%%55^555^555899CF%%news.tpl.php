<?php /* Smarty version 2.6.19, created on 2008-06-16 16:07:20
         compiled from site/news.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'site/news.tpl', 10, false),array('modifier', 'default', 'site/news.tpl', 13, false),)), $this); ?>
<table border=0 width="100%" cellspacing="10"><tr>
<?php unset($this->_sections['rss']);
$this->_sections['rss']['name'] = 'rss';
$this->_sections['rss']['loop'] = is_array($_loop=$this->_tpl_vars['rss']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['rss']['show'] = true;
$this->_sections['rss']['max'] = $this->_sections['rss']['loop'];
$this->_sections['rss']['step'] = 1;
$this->_sections['rss']['start'] = $this->_sections['rss']['step'] > 0 ? 0 : $this->_sections['rss']['loop']-1;
if ($this->_sections['rss']['show']) {
    $this->_sections['rss']['total'] = $this->_sections['rss']['loop'];
    if ($this->_sections['rss']['total'] == 0)
        $this->_sections['rss']['show'] = false;
} else
    $this->_sections['rss']['total'] = 0;
if ($this->_sections['rss']['show']):

            for ($this->_sections['rss']['index'] = $this->_sections['rss']['start'], $this->_sections['rss']['iteration'] = 1;
                 $this->_sections['rss']['iteration'] <= $this->_sections['rss']['total'];
                 $this->_sections['rss']['index'] += $this->_sections['rss']['step'], $this->_sections['rss']['iteration']++):
$this->_sections['rss']['rownum'] = $this->_sections['rss']['iteration'];
$this->_sections['rss']['index_prev'] = $this->_sections['rss']['index'] - $this->_sections['rss']['step'];
$this->_sections['rss']['index_next'] = $this->_sections['rss']['index'] + $this->_sections['rss']['step'];
$this->_sections['rss']['first']      = ($this->_sections['rss']['iteration'] == 1);
$this->_sections['rss']['last']       = ($this->_sections['rss']['iteration'] == $this->_sections['rss']['total']);
?>
<td valign="top" width="50%" class="<?php if ($this->_sections['rss']['index'] % 2 == 0): ?>table_container<?php else: ?>table_container2<?php endif; ?>">
<div style="display:table-cell;width:100%;">
	<div class="note" <?php if (! ereg ( '[a-zA-Z]' , $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['title'] )): ?>style="direction:rtl;text-align:right; padding:5px;"<?php endif; ?>>
		<img src="<?php echo $this->_tpl_vars['config']['url']; ?>
/images/icons/feed.gif" align="absmiddle" class="icon" />&nbsp;<?php echo $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['title']; ?>
</div>
	<?php unset($this->_sections['itm']);
$this->_sections['itm']['name'] = 'itm';
$this->_sections['itm']['loop'] = is_array($_loop=$this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['itm']['show'] = true;
$this->_sections['itm']['max'] = $this->_sections['itm']['loop'];
$this->_sections['itm']['step'] = 1;
$this->_sections['itm']['start'] = $this->_sections['itm']['step'] > 0 ? 0 : $this->_sections['itm']['loop']-1;
if ($this->_sections['itm']['show']) {
    $this->_sections['itm']['total'] = $this->_sections['itm']['loop'];
    if ($this->_sections['itm']['total'] == 0)
        $this->_sections['itm']['show'] = false;
} else
    $this->_sections['itm']['total'] = 0;
if ($this->_sections['itm']['show']):

            for ($this->_sections['itm']['index'] = $this->_sections['itm']['start'], $this->_sections['itm']['iteration'] = 1;
                 $this->_sections['itm']['iteration'] <= $this->_sections['itm']['total'];
                 $this->_sections['itm']['index'] += $this->_sections['itm']['step'], $this->_sections['itm']['iteration']++):
$this->_sections['itm']['rownum'] = $this->_sections['itm']['iteration'];
$this->_sections['itm']['index_prev'] = $this->_sections['itm']['index'] - $this->_sections['itm']['step'];
$this->_sections['itm']['index_next'] = $this->_sections['itm']['index'] + $this->_sections['itm']['step'];
$this->_sections['itm']['first']      = ($this->_sections['itm']['iteration'] == 1);
$this->_sections['itm']['last']       = ($this->_sections['itm']['iteration'] == $this->_sections['itm']['total']);
?>
	<div  class="inews" <?php if (! ereg ( '[a-zA-Z]' , $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['title'] )): ?>style="direction:rtl; text-align:right;"<?php endif; ?>>
	<span class="time" <?php if (! ereg ( '[a-zA-Z]' , $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['title'] )): ?>style="float:left;"<?php endif; ?>>
		<img src="images/icons/time.gif" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['date_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y")); ?>
" class="icon" />
	</span>
		<a href="<?php echo $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['link']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['title']; ?>
"><?php echo $this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['title']; ?>
</a>
		<blockquote><?php echo ((is_array($_tmp=@$this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['description_content'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['description']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['rss'][$this->_sections['rss']['index']]['item'][$this->_sections['itm']['index']]['description'])); ?>
</blockquote>
	</div>
	<?php endfor; endif; ?>
</div></td>
<?php if ($this->_sections['rss']['index'] % 2 == 1): ?></tr><tr><?php endif; ?>
<?php endfor; else: ?>
<blockquote>Sorry we couldnt get any news , are you sure your connected to the internet ?!</blockquote>
<?php endif; ?>
</tr></table>