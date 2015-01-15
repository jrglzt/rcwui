<?
/* @(#) $Id: chart2.php,v 0.1 2015/01/06 19:37:26 */

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

  $dbQuery = "SELECT COUNT(alert.rule_id) AS count, description FROM alert,signature WHERE alert.rule_id = signature.rule_id AND timestamp BETWEEN $timePast AND $timeNow GROUP BY alert.rule_id ORDER BY count ASC LIMIT 10";
  $dbResult = mysql_query($dbQuery);
  
  while ($row = mysql_fetch_assoc($dbResult)) 
  {
	/*construyendo arreglo para enviar a gráfico JavaScript*/
	$results2[] = array('label'=>$row['description'],'data'=>$row['count']);

  }


  mysql_close();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<link href="../css/examples.css" rel="stylesheet" type="text/css"> 
<style type="text/css">

	.demo-container2 {
		position: relative;
		height: 400px;
	}

	#placeholder2 {
		width: 850px;
	}


	</style>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../js/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="../js/jquery.flot.pie.js"></script>
	<script type="text/javascript">
	$(function() {
		
		var data2 = <?php echo json_encode($results2); ?>;
			var placeholder2 = $("#placeholder2");
			placeholder2.unbind();
			$.plot(placeholder2, data2, {
				series: {
					pie: { 
						show: true
					}
				}
			});

		
		
	});
       
	
	</script>
</head>
<body>

	<div id="content">

		<div class="demo-container2">
			<div id="placeholder2" class="demo-placeholder"></div>
		</div>

		<p></p>

		<p></p>

	</div>

	<div id="footer">
		
	</div>

</body>
</html>
