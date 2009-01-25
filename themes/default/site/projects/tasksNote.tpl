<div>
{if $showClose eq 1}
	<div style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</div>
{/if}
<div id="msg" style="display:none;"></div>
<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td>Frist Task Name </td>
		<td>Second Task Name </td>
		<td>Relation</td>
		<td align="center" width="30%"><div align="center">Delete</div></td>
	</tr>
{section name=pro loop=$rel}
	<tr class="{cycle values="odd,even"} box" id="box_{$rel[pro].id}">
		<td>{$rel[pro].name1} </td>
		<td>{$rel[pro].name2}</td>
		<td>{$rel[pro].relation}</td>
		<td align="center" width="30%">
			<a href="javascript:void(0)"
				onclick="return aresure('Are you Sure?!','{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks&amp;action=delRel&amp;id={$rel[pro].id}','box_{$rel[pro].id}');return false;">
				<img src="{$config.url}/images/icons/delete.gif" class="icon" />			</a>		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="3">
			<div class="error">Sorry There is no notes related to this task in the database yet..</div>		</td>
	</tr>
{/section}
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="box_container">
	<tr class="tblHeader">
		<td>Note</td>
		<td align="center" width="30%">Date</td>
	</tr>
{section name=pro loop=$notes}
	<tr class="{cycle values="odd,even"} box" id="box_{$notes[pro].id}">
		<td>{$notes[pro].note}</td>
		<td align="center">{$notes[pro].issue_date}</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="3">
			<div class="error">Sorry There is no notes related to this task in the database yet..</div>
		</td>
	</tr>
{/section}
</table>
</div>