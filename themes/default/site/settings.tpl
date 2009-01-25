<div class="titles">
		<img src="{$config.url}/images/icons/wrench.gif" align="left" class="icon" alt="Settings"/>
		&nbsp;Settings
</div>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
  {if $smarty.get.error == 1}
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
      <td  class="error">Please Fill all required feilds.</td>
  </tr>
  {elseif $smarty.get.error == 2}
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
      <td  class="error">The Settings has been updated.</td>
  </tr>
  {elseif $smarty.get.error == 3}
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
      <td  class="error">An Error accrued.</td>
  </tr>
  {/if}
  <tr>
    <td>
		<form action="settings.php" method="post" style="padding-right:20px;" name="passForm" target="_self" id="passForm">
		<div class="box_container">
		  <table border="0" cellpadding="5" cellspacing="0" width="100%" class="table_container3">
		    <tr class="box">
		      <td width="87" valign="top">Site Name: </td>
		      <td width="601"><input name="sitename" class="required" type="text" id="sitename" value="{$info.sitename}" size="50" maxlength="255" /></td>
		    </tr>
		    <tr class="box">
		      <td width="87" valign="top">Site URL : </td>
		      <td><input name="url" class="required validate-url" type="text" value="{$info.url}"  id="url" size="50" maxlength="255" />
		      <span><label>Without the ' / ' at the end.</label></span>		      </td>
		    </tr>
		    <tr class="box">
		      <td width="87" valign="top">Admin Email : </td>
		      <td><input name="email" class="required validate-email" type="text" value="{$email}"  id="email" size="50" maxlength="255" />&nbsp;We use this email to get the lost password back
		     </td>
		    </tr>
		    <tr class="box">
		      <td width="87" valign="top">Item Per Page : </td>
		      <td><input name="perPage" class="required" type="text" value="{$info.perPage}"  id="perPage" size="5" maxlength="5" />		     </td>
		    </tr>
		    <tr class="box">
		      <td width="87" valign="top">Curency : </td>
		      <td><input name="curency" class="required" type="text" value="{$info.curency|default:'$'}"  id="curency" size="5" maxlength="5" />		     </td>
		    </tr>
		    <tr class="box">
		      <td width="87" valign="top">Theme : </td>
		      <td>{html_options name="theme" options=$theme selected=$info.theme}</td>
		    </tr>
		    <tr class="box">
		      <td>
		        <input name="id" type="hidden" id="id" value="{$info.id}" />
		        <input name="act" type="hidden" id="act" value="{$act}" />
		      </td>
		      <td><input type="submit" name="Submit" value=" Save Settings " /></td>
		    </tr>
		  </table>
		</div>
		</form>
	</td>
  </tr>
</table>
{literal}<script>var valid1= new Validation('passForm');</script>{/literal}