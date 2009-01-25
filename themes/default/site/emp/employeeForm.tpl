<div>
<div class="titles">
	<img src="{$config.url}/images/icons/user_{$action}.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; {$action|capitalize} Employee
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
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&modload=employees&file=employee" method="post">
<div class="box_container">
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table_container3">
	<tr class="box">
		<td width="160" valign="top">Employee Name</td>
		<td width="572"><input type="text" id="ename" name="ename" size="30" class="required" value="{$info.name}" /></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Nationality</td>
		<td>{html_options name="ci" options=$country style="width:265px;" selected=$info.nationality|default:'148'}</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Department</td>
		<td>{html_options name="dep_id" options=$departments style="width:265px;" selected=$info.dep_id}</td>
	</tr>	
	<tr class="box">
		<td width="160" valign="top">Employee Work Position</td>
		<td>{html_options name="pos_id" options=$pos_id style="width:265px;" selected=$info.pos_id|default:'148'}</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Birth Year</td>
		<td>{* html_select_date start_year=-50 display_months=false display_days=false *}
			{html_select_date_adv start_year=-50 display_months=false display_days=false year_first_opt_selected=$info.birth_date}		</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Gender</td>
		<td>{html_options name="gender" options=$gender style="width:265px;" selected=$info.gender|default:'1'}</td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Certificate</td>
		<td><textarea name="certificate" id="certificate" class="required" rows="5" cols="50">{$info.certificate}</textarea></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Experince</td>
		<td><textarea name="experince" id="experince" class="required" rows="5" cols="50">{$info.experince}</textarea></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Mobile</td>
		<td><input type="text" id="emobile" name="emobile" size="20"  class="validate-number" value="{$info.mobile}"/></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Phone</td>
		<td><input type="text" id="ephone" name="ephone" size="20"  class="validate-number" value="{$info.phone}" /></td>
	</tr>
	<tr class="box">
		<td width="160" valign="top">Employee Address</td>
		<td><textarea name="eaddress" id="eaddress" class="required" rows="5" cols="50">{$info.address}</textarea></td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" id="action" value="{$action}" />
			<input type="hidden" name="empId" id="empId" value="{$smarty.get.id}" />		</td>
		<td><input type="submit" id="btn" name="btn" value="{$action|capitalize} Employee" /></td>
	</tr>
</table></div>
</form>
{head}<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/scripts/validation.js"></script>{/head}
<script>var valid = new Validation('addForm');</script>
</div>