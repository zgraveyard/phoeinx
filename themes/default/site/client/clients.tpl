<div class="titles">
		<img src="{$config.url}/images/icons/vcard.gif" align="left" class="icon" alt="Clients"/>
		&nbsp;Clients
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
		<td width="25%">Client Name</td>
		<td width="30%">Company Name</td>
		<td align="center" width="10%">Payments</td>
		<td align="center" width="10%"><div align="center">Reg Date</div></td>
		<td align="center" width="10%"><div align="center">Edit</div></td>
		<td align="center" width="10%"><div align="center">Delete</div></td>
	</tr>
{section name=cln loop=$cleints}
	<tr class="{cycle values="odd,even"} box">
		<td align="left"><div align="center">{$cleints[cln].id}</div></td>
		<td align="left">
		<a class="myLink" href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=client&amp;action=clientInfo&amp;id={$cleints[cln].id}" title="Client Information :: {$cleints[cln].clnName}">{$cleints[cln].clnName}</a> </td>
		<td align="left">{$cleints[cln].company}</td>
		<td align="center">
			<a class="myLink" href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=payments&amp;action=pay&amp;id={$cleints[cln].id}" title="View Payments">
				<img src="{$config.url}/images/icons/money.gif" class="icon" alt="View Payments"></a> |
			<a href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=payments&amp;action=addPay&amp;id={$cleints[cln].id}" title="Add Payments">
				<img src="{$config.url}/images/icons/money_add.gif" class="icon" alt="Add Payments">			</a>		</td>
		<td align="center"><div align="center">{$cleints[cln].regDate}</div></td>
		<td align="center">
			<div align="center"><a href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=client&amp;action=editForm&amp;id={$cleints[cln].id}">
			  <img src="{$config.url}/images/icons/vcard_edit.gif" class="icon" alt="Edit {$employees[emp].empName}"/>			</a> </div></td>
		<td align="center">
			<div align="center"><a href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=client&amp;action=delete&amp;id={$cleints[cln].id}" onclick="return confirm('are you sure ?!');">
			  <img src="{$config.url}/images/icons/vcard_delete.gif" class="icon" alt="delete {$employees[emp].empName}"/>			</a> </div></td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="7">
			<div class="error">Sorry There is no Clients in the database yet..</div>		</td>
	</tr>
{/section}
</table>
<div class="nav">{$nav}</div>