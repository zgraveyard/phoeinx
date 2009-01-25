<div class="titles">
		<img src="{$config.url}/images/icons/chart_organisation.gif" align="left" class="icon" alt="Projects"/>
		&nbsp;Tasks
</div>
{if $smarty.get.done eq '1'}
<div class="right">
	<img src="{$config.url}/images/icons/accept.gif" class="icon" align="left" alt="Your request has been performed successfully"/>
	&nbsp;Your request has been performed successfully . </div>
{elseif $smarty.get.error eq '1'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;An error accrued while we were trying to perform your request , please try again later .. </div>
{elseif $smarty.get.error eq '2'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You didnt specify a record to delete , please try again .. </div>
{/if}
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td>Task Name</td>
		<td>Project Name</td>
		<td align="center" width="10%">Status</td>
		<td align="center" width="10%">Add Relation</td>
		<td align="center" width="10%">Add Note</td>
		<td align="center" width="20%">Start / End Date</td>
		<td align="center" width="13%">View Employee</td>
		<td align="center" width="5%">Edit</td>
		<td align="center" width="5%">Delete</td>
	</tr>
{section name=pro loop=$tasks}
	<tr class="{cycle values="odd,even"}">
		<td><a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=info&amp;id={$tasks[pro].id}" title="Task Notes" class="myLink aLink">{$tasks[pro].name}</a></td>
		<td><a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=info&amp;id={$tasks[pro].pId}" title="Project Information :: {$tasks[pro].proName}" class="myLink aLink">{$tasks[pro].proName}</a></td>
		<td align="center">{if $tasks[pro].status_id eq 1}Pendding{elseif $tasks[pro].status_id eq 2}Working{else}Finished{/if}</td>
		<td align="center">
			<a class="myLink aLink" href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=addReal&amp;id={$tasks[pro].id}&amp;pId={$tasks[pro].pId}" title="add Relation">
				<img src="{$config.url}/images/icons/chart_organisation_add.gif" class="icon" /></a></td>
		<td align="center">
			<a class="myLink aLink" href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=addNote&amp;id={$tasks[pro].id}" title="add note">
				<img src="{$config.url}/images/icons/note_add.gif" class="icon" /></a></td>
		<td align="center">{$tasks[pro].start_date} - {$tasks[pro].end_date}</td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=viewEmp&amp;id={$tasks[pro].id}" title="View Employee" class="myLink aLink" >
				<img src="{$config.url}/images/icons/page_white_stack.gif" class="icon" /></a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=editForm&amp;id={$tasks[pro].id}" title="Edit">
				<img src="{$config.url}/images/icons/edit.gif" class="icon" /></a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=delete&amp;id={$tasks[pro].id}" title="Delete"  onclick="return confirm('are you sure ?!');">
				<img src="{$config.url}/images/icons/delete.gif" class="icon" />
			</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="8">
			<div class="error">Sorry There is no Tasks related to this project / any project in the database yet..</div>
		</td>
	</tr>
{/section}
</table>
<div class="nav">{$nav}</div>