<div>
{if $showClose eq 1}
	<span style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</span>
{/if}
<br /><center>
	<div style="width:90%;padding:3px;margin:3px;border-bottom:1px solid #000;text-align:left;">
			<img src="{$config.url}/images/icons/user.gif" align="left" class="icon" alt="Clients"/>
			&nbsp;Project Information
	</div>
</center>
<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="200px;" valign="top"><label>Project Name</label></td>
		<td>{$project.name}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Company name</label></td>
		<td><a class="myLink" href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=client&amp;action=clientInfo&amp;id={$project.cId}" title="Client Information :: {$project.company}">{$project.company}</a></td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Department</label></td>
		<td>{$project.depName}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Project Type</label></td>
		<td>{$project.type}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Status</label></td>
		<td>{if $project.status_id eq 1}Pendding{elseif $project.status_id eq 2}Working{else}Finished{/if}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Start Date</label></td>
		<td>{$project.start_date}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>End Date</label></td>
		<td>{$project.end_date}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Cost</label></td>
		<td>{$project.cost}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Description</label></td>
		<td>{$project.description}</td>
	</tr>
</table>
<center>
	<div style="width:90%;padding:3px;margin:3px;border-bottom:1px solid #000;text-align:left;">
			<img src="{$config.url}/images/icons/note.gif" align="left" class="icon" alt="Clients"/>
			&nbsp;Project Notes
	</div>
</center>
<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><label>Note</label></td>
		<td style="width:10%" align="center" ><label>Date</label></td>
	</tr>
{section name=note loop=$notes}
	<tr class="{cycle values="odd,even"}">
		<td valign="top">{$notes[note].note}</td>
		<td valign="top" style="width:20%" align="center" >{$notes[note].issue_date}</td>
	</tr>
{sectionelse}
	<tr>
		<td valign="top" colspan="2"><div class="error">Sorry this Project has no notes yet</div></td>
	</tr>
{/section}
</table>
</div>
<script type="text/javascript">getWindow();</script>