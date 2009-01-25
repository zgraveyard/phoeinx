<div class="titles">
		<img src="{$config.url}/images/icons/group.gif" align="left" class="icon" alt="Employees"/>
		&nbsp;Employees
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
		<td align="center" width="5%"><div align="center">Id</div></td>
		<td width="25%">Employee Name</td>
		<td width="50%">Department Name</td>
		<td align="center" width="10%"><div align="center">Active</div></td>
		<td align="center" width="10%"><div align="center">Edit</div></td>
		<td align="center" width="10%">Delete</td>
	</tr>
{section name=emp loop=$employees}
	<tr class="{cycle values="odd,even"} box ">
		<td align="center">{$employees[emp].id}</td>
		<td align="left">
			<a class="myLink" href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=empInfo&amp;id={$employees[emp].id}" title="Employee Information :: {$employees[emp].empName}" >{$employees[emp].empName}</a></td>
		<td align="left">{$employees[emp].depName}</td>
		<td align="center">
			<div align="center"><a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=active&amp;status={$employees[emp].active}&amp;id={$employees[emp].id}">
		    {if $employees[emp].active eq '1'}
			  <img src="{$config.url}/images/icons/status_online.gif" class="icon" />
		    {elseif $employees[emp].active eq '0'}
			  <img src="{$config.url}/images/icons/status_offline.gif" class="icon" />
		    {/if}			</a> </div></td>
		<td align="center">
			<div align="center"><a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=editForm&amp;id={$employees[emp].id}">
			  <img src="{$config.url}/images/icons/user_edit.gif" class="icon" alt="Edit {$employees[emp].empName}"/>			</a> </div></td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=employee&amp;action=delete&amp;id={$employees[emp].id}" onclick="return confirm('Are you sure ?\nDeleting the employee will delete all his related information.\nThis action cant be undo');">
				<img src="{$config.url}/images/icons/user_delete.gif" class="icon" alt="delete {$employees[emp].empName}"/>			</a>		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Employees in the database yet..</div>		</td>
	</tr>
{/section}
</table>
<div class="nav">{$nav}</div>