<?
/* @(#) $Id: top10agents.php,v 0.1 2014/12/29 12:34:21 */

/* Autor: Jorge Alzate
 * email: jrglzt@gmail.com
 * 
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */	
  include("settings.inc");

  $secPeriods = array("1800", "3600", "10800", "43200",
			"86400", "604800", "2592000", "31536000");
  $namePeriods = array("30 minutes", "1 hour", "3 hours", "12 hours",
			"1 day", "7 days", "1 month", "1 year");
  $formPeriod = $_GET["formPeriod"];
  if (!in_array($formPeriod, $secPeriods)) {
    /* Por defecto en una hora*/
    $formPeriod = "3600"; 
  }
/*Calculando períodos de tiempo*/
  $timeNow = time();
  $timePast = $timeNow - $formPeriod;
  mysql_connect($dbHost,$dbUser, $dbPass);
  @mysql_select_db($dbName) or die("Unable to connect to database");

  $dbQuery = "SELECT COUNT(location.id) AS count,name FROM location,alert WHERE alert.location_id = location.id AND timestamp BETWEEN $timePast AND $timeNow GROUP BY location.name ORDER BY count DESC LIMIT 10";
  $dbResult = mysql_query($dbQuery);
  $num=mysql_numrows($dbResult);
  $i=0;
  echo '<table class="sample"><tr><th>Count</th><th>Alert</th></tr>';
  while ($i < $num) {
    $count=mysql_result($dbResult,$i,"count");
    $name=mysql_result($dbResult,$i,"name");
	echo '<tr><td>' . $count . '</td><td>' . $name . '</td></tr>';
    $i++;
  }
  echo '</table>';

  mysql_close();

?>
