<div>
	<div class="titles">
			<img src="{$config.url}/images/icons/telephone_{$act}.gif" align="left" class="icon" alt="Departments"/>
			&nbsp; {$act|capitalize} Departments
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
<p>&nbsp;</p>
<form name="addForm" id="addForm" action="{$config.url}/module.php?act=load&modload=employees&file=department" method="post">
<div class="box_container">
<table border="0" cellpadding="5" cellspacing="0" width="100%" class="table_container3">
	<tr class="box">
		<td width="20%"><label>Department Name </label>:</td>
		<td width="80%">
			<input name="depName" type="text" class="required" id="depName" style="width:300px" value="{$info.name}" size="30" />
		</td>
	</tr>
	<tr class="box">
		<td><label>Department Father </label>:</td>
		<td>
			<select name="fatherId" style="width:300px;">
				<option value="0">Main Department</option>
				{html_options options=$departments.path selected=$info.fatherId}
			</select>
		</td>
	</tr>
	<tr class="box">
		<td>&nbsp;
			<input type="hidden" name="action" value="{$act}" id="action" />
			<input type="hidden" name="did" value="{$smarty.get.id}" id="did" />
			<input type="hidden" name="fid" value="{$info.fatherId}" id="fid" />
		</td>
		<td>
			<input type="submit" value="&nbsp;&nbsp; {$act|capitalize} Department &nbsp;&nbsp;" />
		</td>
	</tr>
</table></div>
</form>
{head}<script type="text/javascript" language="javascript" src="{$config.url}/lib/jscript/scripts/validation.js"></script>{/head}
<script>var valid = new Validation('addForm');</script>
</div>