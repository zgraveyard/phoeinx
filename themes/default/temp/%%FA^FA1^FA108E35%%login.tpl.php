<?php /* Smarty version 2.6.19, created on 2008-06-16 15:51:06
         compiled from site/login.tpl */ ?>
<div class="container">
	<center>
		<div id="login">

			<div align="center" style="padding-top:100px; padding-bottom:100px; vertical-align:middle; width:50%;">
			<p>
				<form name="loginForm" action="<?php echo $this->_tpl_vars['config']['url']; ?>
/dologin.php" method="post" id="loginForm">
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
                          <td width="227" rowspan="2" valign="top"  id="loginTitle">Welcome Administrator ..</td>
                          <td width="79" valign="top"><label>
                          <div align="right" style="color:#FFFFFF;">User Name</div>
                          </label></td>
                          <td width="144px"><input name="user" id="user" type="text" tabindex="1" class="required" value="<?php echo $this->_tpl_vars['userName']; ?>
" maxlength="15"/></td>
                        </tr>
                        <tr>
                          <td valign="top"><label>
                          <div align="right" style="color:#FFFFFF;">Password</div>
                          </label></td>
                          <td><input name="pass" id="pass" type="password" tabindex="2" class="required" value="" maxlength="15" size="22" /></td>
                        </tr>
                        <tr>
                          <td align="center"></td>
                          <td align="center"><div align="right">
                            <input type="hidden" name="redir" id="redir" value="<?php echo $this->_tpl_vars['redir']; ?>
" />
                            <input type="submit" tabindex="4" name="loginBtn" value="Login"  id="login_button"/>
                          </div></td>
                          <td align="center"><a href="<?php echo $this->_tpl_vars['config']['url']; ?>
/lost.php">FORGET PASSWORD</a></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="login-bottom"></td>
                  </tr>
                 </table>
                 <table cellpadding="0" cellspacing="0" border="0" width="500" align="center">
                  <tr>
                    <td class="login_error"> <?php if ($_GET['error'] == 1): ?>
                      <p > &nbsp;
                        The <strong><u>User Name</u></strong> that you give us didn't match the one we have in our system .. </p>
                      <?php elseif ($_GET['error'] == 2): ?>
                      <p > &nbsp;
                        The <strong><u>Password</u></strong> that you give us didn't match the one we have in our system .. </p>
                      <?php elseif ($_GET['error'] == 3): ?>
                      <p >&nbsp;
                        You have to provide us with your <strong><u>User Name</u></strong> and <strong><u>Password</u></strong> to gain access to the system .. </p>
                      <?php elseif ($_GET['error'] == 5): ?>
                      <p > &nbsp;
                        You didn't type the <strong><u>Validation Code</u></strong> correctly .. </p>
                      <?php elseif ($_GET['logout'] == 1): ?>
                      <p > &nbsp;
                        You have <strong><u>Logout Successfully</u></strong> from the system .. </p>
                      <?php elseif ($_GET['login'] == 1): ?>
                      <p >&nbsp;
                        You have to <strong><u>Login</u></strong> first to access the system .. </p>
                      <?php endif; ?> </td>
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