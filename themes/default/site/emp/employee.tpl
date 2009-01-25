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
			&nbsp;Employee Information
	</div>
</center>
<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="200px;" valign="top"><label>Employee Name</label></td>
		<td>{$info.name}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Nationality</label></td>
		<td>{$info.cn}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Birth Year</label></td>
		<td>{$info.birth_date}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Gender</label></td>
		<td>{if $info.gender eq '1'}Male{else}Female{/if}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Certificate</label></td>
		<td>{$info.certificate}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Work Position</label></td>
		<td>{$info.posName}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Experince</label></td>
		<td>{$info.experince}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Department</label></td>
		<td>{$info.depname}</td>
	</tr>	
	<tr>
		<td width="200px;" valign="top"><label>Employee Mobile</label></td>
		<td>{$info.mobile|default:'no entery'}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Phone</label></td>
		<td>{$info.phone|default:'no entery'}</td>
	</tr>
	<tr>
		<td width="200px;" valign="top"><label>Employee Address</label></td>
		<td>{$info.address}</td>
	</tr>			
</table>
</div>