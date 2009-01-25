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
			<img src="{$config.url}/images/icons/vcard.gif" align="left" class="icon" alt="Clients"/>
			&nbsp;Client Information :: {$info.name}
	</div>
</center>
<table border="0" cellpadding="10" cellspacing="0" width="90%" align="center" >
	<tr>
		<td width="150"><label>Client Name</label></td>
		<td align="left">{$info.name}</td>
	</tr>
	<tr>
		<td width="150"><label>Company Name</label></td>
		<td align="left">{$info.company}</td>
	</tr>
	<tr >		
		<td width="150"><label>Reg Date</label></td>
		<td align="left">{$info.regDate}</td>	
	</tr>
	<tr>
		<td width="150"><label>Phone</label></td>
		<td align="left">{$info.phone|default:'no entery'}</td>			
	</tr>
	<tr>		
		<td width="150"><label>Mobile</label></td>
		<td>{$info.mobile|default:'no entery'}</td>
	</tr>
	<tr>
		<td width="150"><label>Fax</label></td>
		<td>{$info.fax|default:'no entery'}</td>		
	</tr>
	<tr>		
		<td width="150"><label>Wrok Type</label></td>
		<td>{$info.work_type}</td>
	</tr>
	<tr>
		<td width="150"><label>Company Nationality</label></td>
		<td>{$info.cn}</td>		
	</tr>	
	<tr>		
		<td width="150"><label>Company Address</label></td>
		<td>{$info.address}</td>
	</tr>
	<tr>
		<td width="150"><label>More Information</label></td>
		<td>{$info.moreInfo|default:'no entery'}</td>		
	</tr>				
</table>
</div>