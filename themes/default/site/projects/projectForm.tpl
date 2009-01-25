{head}{literal}<script type="text/javascript">
	Event.observe(window,'load',function(){
		$('myCal1').observe('click',function(e){
			new CalendarDateSelect( $('myCal1').next(), {year_range:10,month_year:'label',format:'american'});
		});
		$('myCal2').observe('click',function(e){
			new CalendarDateSelect( $('myCal2').next(), {year_range:10,month_year:'label',format:'american'});
		});
		checkValue('startDate','endDate','addForm');
	});
</script>{/literal}{/head}
<div>
<div class="titles">
	<img src="{$config.url}/images/icons/{$action}.gif" align="left" class="icon" alt="Project"/>
			&nbsp; {$action|capitalize} Project
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
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="107" valign="top">Project Name</td>
		<td colspan="3"><input type="text" id="pname" name="pname" size="30" class="required" value="{$project.name}" /></td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Client Company</td>
		<td colspan="3">{html_options name="cln" options=$clients style="width:265px;" selected=$project.cId}</td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Project Type</td>
		<td colspan="3">{html_options name="ptype" options=$types style="width:265px;" selected=$project.type_id}</td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Department</td>
		<td colspan="3">{html_options name="dep_id" options=$departments style="width:265px;" selected=$project.depId}</td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Project Status</td>
		<td colspan="3">{html_options name="pStatus" options=$status style="width:265px;" selected=$project.status_id}</td>
	</tr>
	<tr class="box" id="startDate_div">
		<td width="107" valign="top">Start Date</td>
		<td width="186">
			<img alt="Calendar" id="myCal1" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
		<input id="startDate" name="startDate" class="required" type="text" value="{$project.start_date}" size="20" maxlength="255" />    	</td>
	    <td width="62">End Date</td>
	    <td width="337"><img alt="Calendar" id="myCal2" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
		<input id="endDate" name="endDate" class="required" type="text" value="{$project.end_date}" size="20" maxlength="255" />	</td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Project Cost</td>
		<td colspan="3"><input type="text" id="cost" name="cost" class="required validate-number" size="4" maxlength="10" value="{$project.cost}" width="10"/></td>
	</tr>
	<tr class="box">
		<td width="107" valign="top">Project Description</td>
		<td colspan="3"><textarea name="note" id="note" rows="5" cols="50">{$project.description}</textarea></td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="{$action}" />
			<input type="hidden" name="pId" id="pId" value="{$smarty.get.id}" />		</td>
		<td colspan="3"><input type="submit" id="btn" name="btn" value="{$action|capitalize} Project" /></td>
	</tr>
</table></div>
</form>
</div>
<script>var valid = new Validation('addForm');</script>