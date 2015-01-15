<?php
/* @autor Jorge Alzate <jrglzt@gmail.com>
 *  @version 0.1
 *
 */

/*This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */

  
	session_start();
	unset($_SESSION['SESS_USER']);
	unset($_SESSION['SESS_PASS']);
	include("site/headerdashboard.html");

?>
<form name="loginform" action="login_exec.php" method="post">
<table width="309" border="0" align="center" cellpadding="2" cellspacing="5">
  <tr>
    <td colspan="2">

		 <?php
			<?php
			if(isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0) {
			echo '<ul class="err">';
			foreach($_SESSION['ERRMSG_ARR'] as $msg) {
				echo '<li>',$msg,'</li>'; 
				}
			echo '</ul>';
			unset($_SESSION['ERRMSG_ARR']);
			}
		?>
	</td>
  </tr>
  <tr>
    <td width="116"><div align="right">Usuario</div></td>
    <td width="177"><input name="username" type="text" value="admin" readonly/></td>
  </tr>
  <tr>
    <td><div align="right">Password</div></td>
    <td><input name="password" type="password" /></td>
  </tr>
  <tr>
    <td><div align="right"></div></td>
    <td><input name="" type="submit" value="login" /></td>
  </tr>
</table>
</form>
<?php
		
	include("site/footerdashboard.html");
?>

