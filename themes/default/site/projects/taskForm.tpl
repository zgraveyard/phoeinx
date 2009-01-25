{head}{literal}<script type="text/javascript">
	Event.observe(window,'load',function(){
		$('myCal1').observe('click',function(e){
			new CalendarDateSelect( $('myCal1').next(), {year_range:10,month_year:'label',format:'american'});
		});
		$('myCal2').observe('click',function(e){
			new CalendarDateSelect( $('myCal2').next(), {year_range:10,month_year:'label',format:'american'});
		});
		checkValue('startDate','endDate','addForm');
});</script>{/literal}{/head}
<div>
<div class="titles">
	<img src="{$config.url}/images/icons/{$action}.gif" align="left" class="icon" alt="Project"/>
			&nbsp; {$action|capitalize} Task
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
{*{elseif $smarty.get.error neq '1'}
<div class="hint">
	<img src="{$config.url}/images/icons/lightbulb.gif" class="icon" align="left" alt="Hint .."/>
	&nbsp;Remember to enter all required fields . </div>*}
{/if}
{if is_array($dayOff)}
<div class="login_error">
<img src="{$config.url}/images/icons/lightbulb.gif" class="icon" align="left" alt="Hint .."/>&nbsp;<label>Note : </label>
<ul>
	{section name=daysOff loop=$dayOff}
		<li>
			<strong>{$dayOff[daysOff].name|capitalize}</strong> from department
			<strong>{$dayOff[daysOff].depName|capitalize}</strong> has take a days off from
			<strong>{$dayOff[daysOff].start_date}</strong> to <strong>{$dayOff[daysOff].end_date}</strong>.
		</li>
	{/section}
</ul></div>
{/if}
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=tasks" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="128" valign="top">Project Name</td>
		<td width="584"><a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=projects&amp;action=info&amp;id={$project.id}" title="Project Information :: {$project.name}" class="aLink myLink"><strong>{$project.name}</strong></a></td>
	</tr>
	<tr class="box">
		<td width="128" valign="top">Client Name</td>
		<td><a href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=client&amp;action=clientInfo&amp;id={$project.cId}" title="Client Information :: {$project.cName}" class="myLink"><strong>{$project.cName}</strong></a></td>
	</tr>
	<tr class="box">
		<td width="128" valign="top">Department</td>
		<td><strong>{$project.depName}</strong></td>
	</tr>
	<tr class="box">
		<td width="128" valign="top">Project Type</td>
		<td><strong>{$project.typeName}</strong></td>
	</tr>
	<tr class="box ">
		<td width="128" valign="top">Task Name</td>
		<td><input type="text" id="tName" name="tName" class="required" size="40" maxlength="255" value="{$info.name}"/></td>
	</tr>
	<tr class="box">
		<td width="128" valign="top">Task Description</td>
		<td><textarea name="note" id="note" rows="5" cols="30">{$info.description}</textarea></td>
	</tr>
	<tr class="box" id="startDate_div">
		<td width="128" valign="top">Start Date</td>
		<td>
			<img alt="Calendar" id="myCal1" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
			<input id="startDate" name="startDate" class="required" type="text" value="{$info.start_date}" size="40" maxlength="255" />
    	</td>
	</tr>
	<tr class="box" id="endDate_div">
		<td width="128" valign="top">End Date</td>
		<td>
			<img alt="Calendar" id="myCal2" src="{$config.url}/lib/jscript/date2/calendar.gif" class="myCalc" />
			<input id="endDate" name="endDate" class="required" type="text" value="{$info.end_date}" size="40" maxlength="255" />
		</td>
	</tr>
	<tr class="box">
		<td width="128" valign="top">Task Status</td>
		<td>{html_options name="tStatus" options=$status style="width:265px;" selected=$info.status_id}</td>
	</tr>
	<tr class="box ">
		<td width="128" valign="top">Task Progress</td>
		<td><input type="text" id="progress" name="progress" class="required validate-number" size="5" maxlength="11" value="{$info.progress}"/></td>
	</tr>

	<tr class="box">
		<td width="128" valign="top">Employees</td>
		<td>
			{html_options class="required" name="employee[]" options=$employee style="width:265px;" size="10" selected=$tty multiple="multiple"}
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="{$action}" />
			<input type="hidden" name="pId" id="pId" value="{$project.id}" />
			<input type="hidden" name="tId" id="tId" value="{$smarty.get.id}" />
		</td>
		<td><input type="submit" id="btn" name="btn" value="{$action|capitalize} Task" /></td>
	</tr>
</table></div>
</form>
</div>
<script>var valid = new Validation('addForm');</script>