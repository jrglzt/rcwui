<?php
  include("settings.inc");

  $secPeriods = array("1800", "3600", "10800", "43200",
			"86400", "604800", "2592000", "31536000");
  $namePeriods = array("30 minutes", "1 hour", "3 hours", "12 hours",
			"1 day", "7 days", "1 month", "1 year");
  $formPeriod = $_GET["formPeriod"];
  if (!in_array($formPeriod, $secPeriods)) {
    # Set default period - 1h
    $formPeriod = "3600"; 
  }
  $timeNow = time();
  $timePast = $timeNow - $formPeriod;
  mysql_connect($dbHost,$dbUser, $dbPass);
  @mysql_select_db($dbName) or die("Unable to connect to database");

  $dbQuery = "SELECT COUNT(alert.rule_id) AS count, description FROM alert,signature WHERE alert.rule_id = signature.rule_id AND timestamp BETWEEN $timePast AND $timeNow GROUP BY alert.rule_id ORDER BY count DESC LIMIT 10";
  $dbResult = mysql_query($dbQuery);
  while ($row = mysql_fetch_assoc($dbResult)) 
  {
    //   { label: "Series1",  data: 10}
$results[] = array('label'=>$row['description'],'data'=>$row['count']);
	//echo '<pre>';
	//	print_r($results);
	//echo '</pre>'; 
//   $results[] = array('Label:' . '"' . $row['description'] . '"', "data:" . $row['count']);
  }

  mysql_close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<link href="../css/examples.css" rel="stylesheet" type="text/css"> 
<style type="text/css">

	.demo-container {
		position: relative;
		height: 400px;
	}

	#placeholder {
		width: 750px;
	}
	</style>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../js/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="../js/jquery.flot.pie.js"></script>
	<script type="text/javascript">
	$(function() {
		
		var data = <?php echo json_encode($results); ?>;
			var placeholder = $("#placeholder");
			placeholder.unbind();
			$.plot(placeholder, data, {
				series: {
					pie: { 
						show: true
					}
				}
			});

		//$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
		
	});
       

	

	
	</script>
</head>
<body>
	<div id="content">

		<div class="demo-container">
			<div id="placeholder" class="demo-placeholder"></div>
		</div>

		<p></p>

		<p></p>

	</div>

	<div id="footer">
		
	</div>

</body>
</html>
