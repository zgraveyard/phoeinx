<div class="titles">
		<img src="{$config.url}/images/icons/key.gif" align="left" class="icon" alt="Change Password"/>
		&nbsp;Change Password
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
      <td  class="error">There was an error while we are processing your request, please try again later.</td>
    </tr>
   {elseif $smarty.get.error == 3}
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
      <td  class="error">The old password does not match the one we have in our database.</td>
    </tr>
    {elseif $smarty.get.error == 4}
  <tr>
    <td>&nbsp;</td>
  </tr>
     <tr>
       <td class="right">Your password has been changed successfully</td>
    </tr>
   {elseif $smarty.get.error == 5}
  <tr>
    <td>&nbsp;</td>
  </tr>
     <tr>
       <td class="error">There is no such user ..</td>
    </tr>
   {elseif $smarty.get.error == 6}
  <tr>
    <td>&nbsp;</td>
  </tr>
     <tr>
       <td class="error">Your new Password didnt match the verified one.</td>
    </tr>
  {/if}
  <tr>
    <td>
		<form action="change.php" method="post" style="padding-right:20px;" name="passForm" target="_self" id="passForm">
		  <div align="left">
		    <table border="0"  align="center" cellpadding="5" cellspacing="0" id="box_container" width="100%">
		      <tr class="box">
		        <td valign="top">&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr class="box">
		        <td width="20%" valign="top"><strong>Old Password : </strong></td>
		        <td width="202"><input name="oldPass" class="required" type="password" id="oldPass" size="25" maxlength="255" /></td>
		      </tr>
		      <tr class="box">
		        <td width="20%" valign="top"><strong>New Password : </strong></td>
		        <td><input name="newPass" class="required" type="password" id="newPass" size="25" maxlength="255" /></td>
		      </tr>
		      <tr class="box">
		        <td width="20%" valign="top"><strong>Confirm Password : </strong></td>
		        <td><input name="newPass2" class="required" type="password" id="newPass2" size="25" maxlength="255" /></td>
		      </tr>
		      <tr>
		        <td width="20%"><input name="userid" type="hidden" id="userid" value="{$admin.id}" />
	            <input name="act" type="hidden" id="act" value="{$act}" />
	           </td>
		        <td><input type="submit" name="Submit" value=" Change Password " /></td>
		      </tr>
	        </table>
	      </div>
		</form>	</td>
  </tr>
</table>
{literal}<script>var valid1= new Validation('passForm');</script>{/literal}