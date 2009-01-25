{head}{literal}<script type="text/javascript">
	Event.observe(window,'load',function(){
		checkValue('startDate','endDate','addForm');
	});
</script>{/literal}{/head}
<div class="titles">
	<img src="{$config.url}/images/icons/application_view_gallery.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; Employee Dayoff
</div>
{if $smarty.get.error eq 1}
	<div class="error">Please fill all required information. </div>
{elseif $smarty.get.error eq 2}
	<div class="error">An error accured while we trying to process your request.</div>
{elseif $smarty.get.error eq 3}
	<div class="right">Your request has been executed successfuly.</div>
{/if}
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&modload=employees&file=dayoff" method="post">
<table width="100%" cellpadding="0" cellspacing="5" border="0" id="box_container">
	<tr class="box">
		<td width="200px;" valign="top">Department</td>
		<td><select name="depID" onchange="getEmployee('{$config.url}/module.php?act=load&modload=employees&file=dayoff&action=addForm',this)">
				<option>Select Department</option>
				{html_options options=$departments}
			</select>
	</td>
	</tr>
	<tr>
		<td colspan="2">
			<div id='data' style="display:none;"></div>
		</td>
	</tr>
</table>
</form>