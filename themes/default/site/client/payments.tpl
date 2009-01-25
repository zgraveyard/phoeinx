<div>
{if $showClose eq 1}
	<span style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</span>
{/if}
<br />
	<div style="width:98%;padding:3px;margin:3px;border-bottom:1px solid #000;text-align:left;">
		<h1>
			<img src="{$config.url}/images/icons/vcard.gif" align="left" class="icon" alt="Clients"/>
			&nbsp;Client Payments
		</h1>
	</div>
<table border="0" cellpadding="10" cellspacing="0" class="list_container" style="width:90%">
	<tr>
		<td width="25%" class="tblHeader">Client Name</td>
		<td width="30%" class="tblHeader">Company Name</td>
		<td align="center" width="10%" class="tblHeader">Description</td>
		<td align="center" width="10%" class="tblHeader">Ammount</td>
		<td align="center" width="10%" class="tblHeader">Date</td>
	</tr>
{section name=pay loop=$info}
	<tr class="{cycle values="odd,even"} box">
		<td align="left">{$info[pay].name}</td>
		<td align="left">{$info[pay].company}</td>
		<td align="center">{$info[pay].type}</td>
		<td align="center">{$info[pay].ammount}{$config.curency}</td>
		<td align="center">{$info[pay].pay_date}</td>
	</tr>
{/section}
	<tr>
		<td colspan="5" style="border-bottom:1px solid #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="right">Payments :</td>
		<td>{$config.curency} {$total|default:'0'}</td>
	</tr>
	<tr>
		<td colspan="4" align="right">Projects Cost :</td>
		<td>{$config.curency} {$mustPay|default:'0'}</td>
	</tr>
	<tr>
		<td colspan="4" align="right">Total : </td>
		<td>{$config.curency} {math equation="x - y" x=$mustPay|default:'0' y=$total|default:'0'}</td>
	</tr>
</table>
</div>