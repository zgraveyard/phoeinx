<div class="titles">
		<img src="{$config.url}/images/icons/telephone.gif" align="left" class="icon" alt="Departments"/>
		&nbsp;Departments
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
{elseif $smarty.get.error eq '3'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;The Department you choose can't be deleted ,
	because it has Child departments or an employees belongs to it .. </div>
{/if}
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%"><div align="center">Id</div></td>
		<td width="25%">Department Name</td>
		<td width="45%">Department Path</td>
		<td width="15%" align="center" >Employees Count</td>
		<td align="center" width="10%"><div align="center">Edit</div></td>
		<td align="center" width="10%">Delete</td>
	</tr>
{section name=dep loop=$departments}
	<tr class="{cycle values="odd,even"} box ">
		<td align="center">{$departments[dep].id}</td>
		<td align="left">{$departments[dep].name}</td>
		<td align="left">{$departments[dep].path}</td>
		<td align="center">{$departments[dep].count}</td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=department&amp;action=editForm&amp;id={$departments[dep].id}">
			<img src="{$config.url}/images/icons/telephone_edit.gif" class="icon" alt="edit {$departments[dep].name}"/>			</a></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=department&amp;action=delete&amp;id={$departments[dep].id}" onclick="return confirm('Are you sure ?\nThis will delete the child departments also');">
				<img src="{$config.url}/images/icons/telephone_delete.gif" class="icon" alt="delete {$departments[dep].name}"/>			</a>		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no departments in the database yet..</div>		</td>
	</tr>
{/section}
</table>
<div class="nav">{$nav}</div>