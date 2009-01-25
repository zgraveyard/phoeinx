<div style="padding:10px;">
	<span style="float:right;"><a href="reportGenExample.php?type=pdf&amp;id={$project.id}" title="Export to PDF">
	<img src="{$config.url}/images/icons/page_white_acrobat.png" alt="export to pdf" class="icon" /></a></span>
	{if isset($project)}
	{head}{literal}<script type="text/javascript">Event.observe(window,'load',getWindow);</script>{/literal}{/head}
		<p>
			<label>Project Name</label>:&nbsp;
				<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=info&amp;id={$project.id}" class="myLink aLink">{$project.name}</a>
		</p>
	{/if}
	<p><label>Gantt Chart</label>:&nbsp;</p>
	<p><img src="{$config.url}/cache/gantt.jpg" style="border:1px solid #ccc;" /></p>
</div>