<?php /* Smarty version 2.6.19, created on 2008-06-16 16:16:24
         compiled from site/empty.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', 'site/empty.tpl', 1, false),)), $this); ?>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php echo '
	<script>document.observe("dom:loaded", function() { getNews(\'latestNews\'); });</script>'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<div class="news" id="news" width="800px;">
	<div id="latestNews"><img src="images/loading.gif" align="middle" />&nbsp;Loading Data ....</div>
</div>