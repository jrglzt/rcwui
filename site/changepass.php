<?php
/* @(#) $Id: changepass.php,v 0.1 2015/01/01 19:37:26 */

/* Autor: Jorge Alzate
 * email: jrglzt@gmail.com
 * 
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */

/*
 *Variables auxiliares de conexión a mysql
 *
 */
$nwp="";/*almacena primera contraseña para comparación*/
$nwp2=""; /*almacena segunda contraseña para comparación*/
$mens=""; /*Variable que almacena el mensaje de resultado de operación*/     
$mysql_hostname = "localhost";/*Parametro para conectividad*/  
$mysql_user = "root";/*Parametro para conectividad*/  
$mysql_password = "35060";/*Parametro para conectividad*/  
$mysql_database = "bdrcwui";/*Parametro para conectividad*/  

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");
/*Función para evitar SQL Injection
 *@param $str cadena a evaluar
 *@return String	
 */
function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
if(isset($_POST['newpass']))
{    
   $nwp = trim($_POST['newpass']);
   $nwp2 = trim($_POST['newpass2']);
  
   if(strlen($nwp) > 0 && strlen($nwp2) > 0)
   {	
	   if(strcmp($nwp,$nwp2) != 0)
	   {
	   	$mens = "<b class='red'>Password does not match</b><br />\n";
	   }
	   else
	   { //codigo sql
		
		$qry="update rcwui_user set password='$nwp' WHERE login='admin'";
		$result=mysql_query($qry);
		if($result) 
		{

			   	$mens = "<b class='green'>Password Update</b><br />\n";
			
		}
	   }
   }
   else
    {
	$mens = "<b class='red'>Password Empty</b><br />\n";
    }

}
/* Impresión fecha y hora actual */
echo '<div class="smaller2">'.date('F dS Y h:i:s A').'<br />';
echo "<h2>Change Password:</h2>\n";
/* Formulario */
echo '
<form name="dosearch" method="post" action="index.php?f=c">
<table>
  </tr><tr><td>    
    New Password: </td><td><input type="password" name="newpass" size="16" 
                     class="formText" /></td></tr>
    <tr><td>    
    Confirm Password: </td><td>
    <input type="password" name="newpass2" size="16" class="formText"/></td></tr>&nbsp;&nbsp;';
echo '
    <tr><td>                    
    <input type="submit" name="change" value="Change" class="button" />
';
echo '</td></tr></table>
      </form><br /> <br />
     ';
echo "<h2>Results:</h2>\n";
echo $mens;






