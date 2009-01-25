<div>
{if $showClose eq 1}
	<div style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</div>
{/if}
<div id="msg" style="display:none;"></div>
<table border="0" cellpadding="2" cellspacing="0" class="list_container" style="width:80%;">
	<tr class="tblHeader">
		<td width="25%">Employee Name</td>
		<td>Department Name</td>
		<td align="center" width="10%">Delete</td>
	</tr>
{section name=pro loop=$emp}
	<tr class="{cycle values="odd,even"} box" id="box_{$emp[pro].tId}">
		<td>{$emp[pro].name}</td>
		<td>{$emp[pro].depName}</td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=delEmp&amp;id={$emp[pro].tId}"
				title="Are you Sure ?!" class="deleteME"  id="{$emp[pro].tId}" onclick="return false">
				<img src="{$config.url}/images/icons/delete.gif" class="icon" />
			</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="3">
			<div class="error">Sorry There is no Employee related to this task in the database yet..</div>
		</td>
	</tr>
{/section}
</table>
</div>