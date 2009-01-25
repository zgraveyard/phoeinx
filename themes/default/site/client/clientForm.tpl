{head}{literal}<script type="text/javascript">
	Event.observe(window,'load',function(){
		$('myCal').observe('click',function(e){
			new CalendarDateSelect( $('myCal').next(), {year_range:10,month_year:'label',format:'american'});
		});
	});
</script>{/literal}{/head}
<div>
<div class="titles">
	<img src="{$config.url}/images/icons/vcard_{$action}.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; {$action|capitalize} Cleint
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
{elseif $smarty.get.error neq '1'}
<div class="hint">
	<img src="{$config.url}/images/icons/lightbulb.gif" class="icon" align="left" alt="Hint .."/>
	&nbsp;Remember to enter all required fields . </div>
{/if}
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&modload=clients&file=client" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Client Name</div></td>
		<td colspan="3"><input type="text" id="cname" name="cname" size="30" class="required" value="{$info.name}" /></td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Company Name</div></td>
		<td colspan="3"><input type="text" id="company" name="company" size="30" class="required" value="{$info.company}" /></td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Company Nationality</div></td>
		<td colspan="3">{html_options name="ci" options=$country style="width:265px;" selected=$info.nationality|default:'148'}</td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Contracting Date</div></td>
		<td colspan="3"><img alt="Calendar" id="myCal" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" /><input id="regdate" name="regdate"  class="required" type="text" value="{$info.regDate}" size="30" maxlength="255" />	    </td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Company Specialization</div></td>
		<td colspan="3">
			{html_options name="workType" options=$work style="width:265px;" selected=$info.workId}		</td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Client Mobile</div></td>
		<td width="134"><input type="text" id="mobile" name="mobile" size="20"  class="validate-number" value="{$info.mobile}"/></td>
	    <td width="79"><div align="right">Client Phone</div></td>
	    <td width="200"><div align="left">
	      <input type="text" id="phone" name="phone" size="20"  class="validate-number" value="{$info.phone}" />
        </div></td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Client Fax</div></td>
		<td colspan="3"><input type="text" id="fax" name="fax" size="20"  class="validate-number" value="{$info.fax}" /></td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">Client Address</div></td>
		<td colspan="3"><textarea name="address" id="address" class="required" rows="5" cols="50">{$info.address}</textarea></td>
	</tr>
	<tr class="box">
		<td width="96" valign="middle"><div align="left">More Information</div></td>
		<td colspan="3"><textarea name="moreInfo" id="moreInfo" rows="5" cols="50">{$info.moreInfo}</textarea></td>
	</tr>
	<tr class="box">
		<td valign="middle">&nbsp;

		  <div align="left">
		    <input type="hidden" name="action" id="action" value="{$action}" />
		    <input type="hidden" name="cId" id="cId" value="{$smarty.get.id}" />
          </div></td>
		<td colspan="3"><input type="submit" id="btn" name="btn" value="{$action|capitalize} Client" /></td>
	</tr>
</table></div>
</form>
</div>
<script>var valid = new Validation('addForm');</script>