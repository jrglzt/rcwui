<?php
/* @(#) $Id: login_exec.php,v 0.1 2014/12/26 12:34:21 */

/* Autor: Jorge Alzate
 * email: jrglzt@gmail.com
 * 
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */	
	session_start();
	require_once('lib/connection.php');
 
	/*Array para almacena los mensajes de error*/
	$errmsg_arr = array();
 
	
	$errflag = false;
 
	/*Función para prevenir SQL Injection
	 *@param $str cadena para ser evaluada
	 *@return String
	 */
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
 
	
	$username = clean($_POST['username']);
	$password = clean($_POST['password']);
 
	//*Validaciones de entrada*/
	if($username == '') {
		$errmsg_arr[] = 'Username missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
 
	
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index3.php");
		exit();
	}
 
	/*Creación de consulta*/
	$qry="SELECT * FROM rcwui_user WHERE login='$username' AND  password like binary '$password'";
	$result=mysql_query($qry);
 
	/*Verificando la ejecución de la consulta*/
	if($result) {
		if(mysql_num_rows($result) > 0) {
			/*Autenticación OK*/
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			
			$_SESSION['SESS_USER'] = $member['login'];
			$_SESSION['SESS_PASS'] = $member['password'];
			session_write_close();
			header("location: index.php");
			exit();
		}else {
			/*La autenticación ha fallado*/
			$errmsg_arr[] = 'user name and password not found';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				session_write_close();
				header("location: index3.php");
				exit();
			}
		}
	}else {
		die("Query failed");
	}
?>
