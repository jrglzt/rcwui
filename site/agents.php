<?php
/* @(#) $Id: agents.php,v 0.1 2014/12/20 05:17:21 */

/* Autor: Jorge Alzate
 * email: jrglzt@gmail.com
 * 
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */
$agent='';
$ip='';
$mens='';
$idagent='';
if(isset($_POST['agentname']))
{    
   $agent = trim($_POST['agentname']);
   $ip = trim($_POST['ip']);
    
   if(strlen($agent) > 0 && strlen($ip) > 0)
   {	
	$descr = array(
	    0 => array(
		'pipe',
		'r'
	    ) ,
	    1 => array(
		'pipe',
		'w'
	    ) ,
	    2 => array(
		'pipe',
		'w'
	    )
	);
	$pipes = array();
	
	/*Limpiar archivo para la creación de agente.*/
	$process = proc_open("cat /dev/null > /var/ossec/newagent.tmp", $descr, $pipes);
	if (is_resource($process)) {
	    while ($f = fgets($pipes[1])) {
		$mens= $mens . "<b class='green'>" . $f . "</b><br />\n";
	    }
	    fclose($pipes[1]);
	    while ($f = fgets($pipes[2])) {
		$mens= $mens ."<b class='red'>Error:" . $f . "</b><br />\n";
	    }
	    fclose($pipes[2]);
	    proc_close($process);
	}
	/*Escribir datos del agente al archivo*/	
	$pipes = array();
	$comando = 'echo "'. $ip . ',' . $agent . '" > /var/ossec/newagent.tmp';	
	$process = proc_open($comando, $descr, $pipes);
	if (is_resource($process)) {
	    while ($f = fgets($pipes[1])) {
		$mens= $mens . "<b class='green'>" . $f . "</b><br />\n";
	    }
	    fclose($pipes[1]);
	    while ($f = fgets($pipes[2])) {
		$mens= $mens ."<b class='red'>Error:" . $f . "</b><br />\n";
	    }
	    fclose($pipes[2]);
	    proc_close($process);
	}
	/*Ejecutar creación agente a través de la función proc_open invocando manage_agents*/
	$pipes = array();
	$process = proc_open("sudo /var/ossec/bin/manage_agents -f /newagent.tmp", $descr, $pipes);
	if (is_resource($process)) {
	    while ($f = fgets($pipes[1])) {
		$mens= $mens . "<b class='green'>" . $f . "</b><br />\n";
	    }
	    fclose($pipes[1]);
	    while ($f = fgets($pipes[2])) {
		$mens= $mens ."<b class='red'>Error:" . $f . "</b><br />\n";
	    }
	    fclose($pipes[2]);
	    proc_close($process);
	}
	
   }
   else
    {
	$mens = "<b class='red'>Error: Fields Empty</b><br />\n";
    }

}
else
{
	if(isset($_POST['idagent']))
	{    
		$idagent = trim($_POST['idagent']);
		if(strlen($idagent) > 0)
		   {	
			
			$descr = array(
			    0 => array(
				'pipe',
				'r'
			    ) ,
			    1 => array(
				'pipe',
				'w'
			    ) ,
			    2 => array(
				'pipe',
				'w'
			    )
			);
			
			$pipes = array();
			/*Ejecutar generación de llave para el agente*/			
			$comando = "sudo /var/ossec/bin/manage_agents -e " . $idagent;
			$process = proc_open($comando, $descr, $pipes);
			if (is_resource($process)) {
			    while ($f = fgets($pipes[1])) {
				$mens= $mens . "<b class='green'>" . $f . "</b><br />\n";
			    }
			    fclose($pipes[1]);
			    while ($f = fgets($pipes[2])) {
				$mens= $mens ."<b class='red'>Error:" . $f . "</b><br />\n";
			    }
			    fclose($pipes[2]);
			    proc_close($process);
			}
		  }

		
	}
}
/* Impresión fecha y hora actual */
echo '<div class="smaller2">'.date('F dS Y h:i:s A').'<br />';

echo "<div align=center>";

echo "<h2>List Agents</h2>\n";
$descr = array(
    0 => array(
        'pipe',
        'r'
    ) ,
    1 => array(
        'pipe',
        'w'
    ) ,
    2 => array(
        'pipe',
        'w'
    )
);
$pipes = array();
/*Listar agentes*/
$process = proc_open("sudo /var/ossec/bin/manage_agents -l ", $descr, $pipes);
if (is_resource($process)) {
    while ($f = fgets($pipes[1])) {
          echo '<b>'. $f . '</b><br/>';
    }
    fclose($pipes[1]);
    while ($f = fgets($pipes[2])) {
        echo "-pipe 2--->";
        echo $f;
    }
    fclose($pipes[2]);
    proc_close($process);
}
echo "</div>";
echo "<h2>Add Agent</h2>\n";

/* Formulario Add Agent */
echo '
<form name="dosearch" method="post" action="index.php?f=ag">
<table>
  <tr><td>    
    IP(Unique): </td><td><input type="text" name="ip" size="16" 
                     class="formText" /></td></tr>
    <tr><td>    
    Agent Name (Unique): </td><td>
    <input type="text" name="agentname" size="16" class="formText"/></td></tr>&nbsp;&nbsp;';
echo '
    <tr><td>                    
    <input type="submit" name="add" value="Add" class="button" />
';
echo '</td></tr></table>
      </form><br /> <br />
     ';
/*Formulario get key*/
echo '<form name="getkey" method="post" action="index.php?f=ag">
<table>
  <tr><td>    
    ID Agent(Unique): </td><td><input type="text" name="idagent" size="16" 
                     class="formText" /></td></tr>
    ';
echo '
    <tr><td>                    
    <input type="submit" name="getkey" value="Key" class="button" />
';
echo '</td></tr></table>
      </form><br /> <br />
     ';
echo "<h2>Results:</h2>\n";
echo $mens;






