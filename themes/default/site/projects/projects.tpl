<div class="titles">
		<img src="{$config.url}/images/icons/layout.gif" align="left" class="icon" alt="Projects"/>
		&nbsp;Projects
</div>
{if $smarty.get.done eq '1'}
<div class="right">
	<img src="{$config.url}/images/icons/accept.gif" class="icon" align="left" alt="Your request has been performed successfully"/>
	&nbsp;Your request has been performed successfully . </div>
{elseif $smarty.get.error eq '1'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;An error accrued while we were trying to perform your request , please try again later .. </div>
{elseif $smarty.get.error eq '512'}
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;We Cant draw the gantt chart since there is no tasks related to this project .. </div>
{elseif $smarty.get.error eq '2'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You didnt specify a record to delete , please try again .. </div>
{/if}
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td >Project Name</td>
		<td align="center" width="10%">Gantt</td>
		<td align="center" width="10%">Status</td>
		<td align="center" width="10%">Add Note</td>
		<td align="center" width="10%">Add Task</td>
		<td align="center" width="10%">View Tasks</td>
		<td align="center" width="10%">Edit</td>
		<td align="center" width="10%">Delete</td>
	</tr>
{section name=pro loop=$projects}
	<tr class="{cycle values="odd,even"} box">
		<td>
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=info&amp;id={$projects[pro].id}" title="Project Information :: {$projects[pro].name}" class="myLink aLink">
			{$projects[pro].name}</a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=gantt&amp;pId={$projects[pro].id}">
			<img src="{$config.url}/images/icons/chart_line.gif" class="icon" />
		</a></td>
		<td align="center">{if $projects[pro].status_id eq 1}Pendding{elseif $projects[pro].status_id eq 2}Working{else}Finished{/if}</td>
		<td align="center">
			<a class="myLink aLink" href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=addNote&amp;id={$projects[pro].id}" title="add note">
				<img src="{$config.url}/images/icons/note_add.gif" class="icon" /></a></td>
		<td align="center"><a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=new&amp;id={$projects[pro].id}" title="add task"><img src="{$config.url}/images/icons/add.gif" class="icon" /></a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=view&amp;id={$projects[pro].id}" title="View Tasks">
				<img src="{$config.url}/images/icons/page_white_stack.gif" class="icon" /></a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=editForm&amp;id={$projects[pro].id}" title="Edit">
				<img src="{$config.url}/images/icons/layout_edit.gif" class="icon" /></a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=delete&amp;id={$projects[pro].id}" title="Delete"  onclick="return confirm('are you sure ?!');">
				<img src="{$config.url}/images/icons/layout_delete.gif" class="icon" />
			</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="8">
			<div class="error">Sorry There is no Projects in the database yet..</div>
		</td>
	</tr>
{/section}
</table>
<div class="nav">{$nav}</div>