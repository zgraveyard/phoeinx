{head}{literal}<script type="text/javascript">
	Event.observe(window,'load',function(){
		$('myCal').observe('click',function(e){
			new CalendarDateSelect( $('myCal').next(), {year_range:10,month_year:'label',format:'american'});
		});
	});
</script>{/literal}{/head}
<div>
<div class="titles">
	<img src="{$config.url}/images/icons/money_add.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; {$action|capitalize} Payment
</div>
{if $smarty.get.error eq '1'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" class="icon" align="left" alt="error .."/>
	&nbsp;Please fill all required feilds .. </div>
{elseif $smarty.get.error eq '2'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" class="icon" align="left" alt="error .."/>
	&nbsp;It seems we have a problems with this record , can you please retry again. </div>
{elseif $smarty.get.error eq '3'}
<div class="error">
	<img src="{$config.url}/images/icons/emoticon_surprised.gif" class="icon" align="left" alt="surprised"/>
	&nbsp;You must be kidding right &nbsp;&nbsp;?!
	&nbsp;Fill all required feilds .. </div>
{/if}
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&modload=clients&file=payments" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="150" valign="top">Client Name</td>
		<td width="582"><input type="text" id="cname" name="cname" size="30" readonly="readonly" class="required" value="{$info.name}" style="background-color:#EDEAE4; border:#ADADAD 1px solid;"  /></td>
	</tr>
	<tr class="box">
		<td width="150" valign="top">Company Name</td>
		<td><input type="text" id="company" name="company" size="30" readonly="readonly" class="required" value="{$info.company}" style="background-color:#EDEAE4; border:#ADADAD 1px solid;" /></td>
	</tr>
	<tr class="box">
		<td width="150" valign="top">Payment Description</td>
		<td><input type="text" id="type" name="type" size="30" class="required" value="" /></td>
	</tr>
	<tr class="box">
		<td width="150" valign="top">Ammount</td>
		<td><input type="text" id="ammount" name="ammount" size="10" maxlength="10" class="required validate-number" value=""/></td>
	</tr>
	<tr class="box">
		<td width="150" valign="top">Payment Date</td>
		<td><img alt="Calendar" id="myCal" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
			<input id="regdate" class="required" name="regdate" type="text" value="{$info.regDate}" size="27" maxlength="255" />
    	</td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="addPayment" />
			<input type="hidden" name="cId" id="cId" value="{$smarty.get.id}" />
		</td>
		<td><input type="submit" id="btn" name="btn" value="Add Payment" /></td>
	</tr>
</table></div>
</form>
</div>
<script> var valid = new Validation('addForm');</script>