<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr class="box">
<td width="200px;" valign="top">Employee Name</td>
<td ><span style="width:16px;height:16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<select name="empID">
		{html_options options=$employee}
	</select>
</td>
</tr>
<tr class="box" id="startDate_div">
	<td width="200px;" valign="top">Starting Date</td>
	<td><img alt="Calendar" id="myCal1" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
		<input id="startDate" class="required" name="startDate" type="text" value="" size="40" maxlength="255" />

    </td>
</tr>
<tr class="box" id="endDate_div">
	<td width="200px;" valign="top">Ending Date</td>
	<td><img alt="Calendar" id="myCal2" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
		<input id="endDate" class="required" name="endDate" type="text" value="" size="40" maxlength="255" />
    </td>
</tr>
<tr class="box">
	<td width="200px;" valign="top">Paid</td>
	<td><input type="checkbox" name="paid" id="paid" value="1" checked="checked"/></td>
</tr>
<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="{$act}" />
		</td>
		<td><input type="submit" id="btn" name="btn" value="Add Dayoff" /></td>
</tr>
</table>
<script>
var valid = new Validation('addForm');
{literal}
		$('myCal1').observe('click',function(e){
			new CalendarDateSelect( $('myCal1').next(), {year_range:10,month_year:'label',format:'american'});
		});
		$('myCal2').observe('click',function(e){
			new CalendarDateSelect( $('myCal2').next(), {year_range:10,month_year:'label',format:'american'});
		});
{/literal}
</script>