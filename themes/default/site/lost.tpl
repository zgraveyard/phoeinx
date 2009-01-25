<div class="container">
	<center>
		<div id="login">

			<div align="center" style="padding-top:100px; padding-bottom:100px; vertical-align:middle; width:50%;">
			<p>
				<form name="loginForm" action="{$config.url}/lost.php" method="post" id="loginForm">
                <p></p>
          <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td rowspan="3" class="login-left">&nbsp;</td>
                    <td class="login-top"></td>
                    <td rowspan="3" class="login-right">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="login-body"><table width="100%" align="center" cellpadding="3" cellspacing="3" border="0">
                        <tr>
                          <td width="198" rowspan="2" valign="top"  id="loginTitle">Lost Password</td>
                          <td width="63" valign="top"><label>
                          <div align="right" style="color:#FFFFFF;">Email</div>
                          </label></td>
                          <td width="189">
                          	<input name="email" type="text" class="required validate-email" id="email" tabindex="1" value="{$email}" size="25" maxlength="15"/>                          </td>
                        </tr>
                        <tr>
                          <td align="center"><div align="right">
                           
                          </div></td>
                          <td align="center">
					       <div align="left">
						    <input type="hidden" name="action" id="action" value="{$action}" />
                            <input type="submit" tabindex="4" name="loginBtn" value="Send"  id="login_button"/>
						   &nbsp;<a href="index.php" target="_self">RETURN TO LOGIN PAGE</a>				            </div></td>
                          </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="login-bottom"></td>
                  </tr>
                 </table>
                 <table cellpadding="0" cellspacing="0" border="0" width="500" align="center">
                  <tr>
                    <td class="login_error">
                    {if $smarty.get.error eq 1}
                      <p > &nbsp;The <strong><u>Email</u></strong> that you give us didn't match the one we have in our system .. </p>
                    {elseif $smarty.get.error eq 2}
                    <p > &nbsp;You didnt type your email ... </p>
                    {elseif $smarty.get.error eq 3}
                    <p > &nbsp;The Email which you give is not a valid email... </p>
                    {elseif $smarty.get.error eq 4}
                    <p > &nbsp;An Error accoured while we try to send you and email , try again... </p>
                    {elseif $smarty.get.done eq 1}
                    <p > &nbsp;The New Password has been sent successfully... </p>
                    {/if} </td>
                  </tr>
                </table>                  <p >&nbsp;</p>


			  </form>
			</div>
		</div>
	</center>
</div>
<script>
	var valid1 = new Validation("loginForm");
</script>