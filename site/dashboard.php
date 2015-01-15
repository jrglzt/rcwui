<?php
/* @(#) $Id: dashboard.php,v 0.1 2014/11/26 12:34:21 */

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
?>
<html>
<head>
<?
  
  $formAuto = $_GET["formAuto"];
  if ($formAuto == "on") {
    echo '<META HTTP-EQUIV="refresh" CONTENT="60">';
  }
include("headerdashboard.html");
?>
<SCRIPT type="text/javascript" src="../js/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../js/jquery.cookie.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></SCRIPT>
<link type="text/css" href="../css/jquery-ui-1.8.2.custom.css" rel="Stylesheet" />
<link type="text/css" href="../css/tables.css" rel="Stylesheet" />
<style type="text/css" media="screen">
    .column { width: 400px; float: left; padding-bottom: 200px; }
    .tablecolumn { width: 600px; float: left; padding-bottom: 200px; }
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header {
        font-size:13px; margin: 0.3em;
        padding-bottom: 4px; padding-left: 0.2em; }
    .portlet-header .ui-icon { float: right; }
    .portlet-content { padding: 0.4em; }
    .ui-sortable-placeholder {
        border: 1px dotted black;
        visibility: visible !important;
        height: 200px !important; }
    .ui-sortable-placeholder * { visibility: hidden; }

    body { font: 62.5% "Trebuchet MS", sans-serif; }
</style>

<script type="text/javascript">

$(document).ready( function () {
    $(".column").sortable({
        connectWith: ['.column'],
        stop: function() {/* saveOrder();*/ }
    }); 

    $(".portlet")
        .addClass("ui-widget ui-widget-content")
        .addClass("ui-helper-clearfix ui-corner-all")
        .find(".portlet-header")
        .addClass("ui-widget-header ui-corner-all")
        .prepend('<span class="ui-icon ui-icon-minus"></span>')
        .end()
        .find(".portlet-content");

    //restoreOrder();

    $(".portlet-header .ui-icon").click(function() {
        $(this).toggleClass("ui-icon-minus");
        $(this).toggleClass("ui-icon-plus");
        $(this).parents(".portlet:first").find(".portlet-content").toggle();
        //saveOrder(); // This is important
    });
    $(".portlet-header .ui-icon").hover(
        function() {$(this).addClass("ui-icon-hover"); },
        function() {$(this).removeClass('ui-icon-hover'); }
    );
}); 

</script>
</head>

<body>
<?
  $secPeriods = array("1800", "3600", "10800", "43200",
                      "86400", "604800", "2592000", "31536000");
  $namePeriods = array("30 minutes", "1 hour", "3 hours", "12 hours",
                       "1 day", "7 days", "1 month", "1 year");
  $formPeriod = $_GET["formPeriod"];
  if (!in_array($formPeriod, $secPeriods)) {
    /* Por defecto en una hora*/
    $formPeriod = "3600";
  }
?>
<form action="dashboard.php" method="GET">
<table width="100%" align="top" >
<td align="right" valign="middle">
<select name="formPeriod">
<?
  for ($i = 0; $i < count($secPeriods); $i++) {
        echo '<option ';
        if ($secPeriods[$i] == $formPeriod) {
                echo 'selected ';
        }
        echo 'value="' . $secPeriods[$i] . '">' . $namePeriods[$i] . '</option>';
  }
  echo '</select><input type="submit" value="Go">';
  echo '<br><input type="checkbox" name="formAuto"';
  if ($formAuto == "on") { echo " checked"; }
  echo '>Auto-reload';
  if ($formAuto == "on") { echo '<div id="javascript_countdown_time"></div>'; }
?>
</td></tr></table>
</form>
<script>
var javascript_countdown = function () {
	var time_left = 60; //Número de segundo para el contador
	var output_element_id = 'javascript_countdown_time';
	var keep_counting = 1;
	var no_time_left_message = 'No time left for JavaScript countdown!';
 
	function countdown() {
		if(time_left < 2) {
			keep_counting = 0;
		}
 
		time_left = time_left - 1;
	}
 
	function add_leading_zero(n) {
		if(n.toString().length < 2) {
			return '0' + n;
		} else {
			return n;
		}
	}
 
	function format_output() {
		var hours, minutes, seconds;
		seconds = time_left % 60;
		minutes = Math.floor(time_left / 60) % 60;
		hours = Math.floor(time_left / 3600);
 
		seconds = add_leading_zero( seconds );
		minutes = add_leading_zero( minutes );
		hours = add_leading_zero( hours );
 
		/* return hours + ':' + minutes + ':' + seconds; */
		return time_left + ' seconds';
	}
 
	function show_time_left() {
		document.getElementById(output_element_id).innerHTML = format_output();//time_left;
	}
 
	function no_time_left() {
		document.getElementById(output_element_id).innerHTML = no_time_left_message;
	}
 
	return {
		count: function () {
			countdown();
			show_time_left();
		},
		timer: function () {
			javascript_countdown.count();
 
			if(keep_counting) {
				setTimeout("javascript_countdown.timer();", 1000);
			} else {
				no_time_left();
			}
		},
		init: function (t, element_id) {
			time_left = t;
			output_element_id = element_id;
			javascript_countdown.timer();
		}
	};
}();
 
//Tiempo para el contador en segundos, y el elemento ID
javascript_countdown.init(180, 'javascript_countdown_time');
</script>
<hr>
<div class="column" id="col1">
    <div class="portlet" id="top10alerts">
        <div class="portlet-header">Top-1O Alerts</div>
        <div class="portlet-content">
		<p align="center">
		<? include("../lib/top10alerts.php"); ?>
		</p>
        </div>
    </div>
    <div class="portlet" id="top10suspicious">
        <div class="portlet-header">Top-10 Suspicious</div>
        <div class="portlet-content">
		<p align="center">
		<? include("../lib/top10suspicious.php"); ?>
		</p>
        </div>
    </div>
 <?php echo '<a href="../index.php">Back to Main</a>';?>

</div>
<div class="column" id="col2">
    <div class="portlet" id="top10agents.php">
        <div class="portlet-header">Top-10 Agents</div>
        <div class="portlet-content">
		<p align="center">
		<? include("../lib/top10agents.php"); ?>
		</p>
        </div>
    </div>
    <div class="portlet" id="top10attackers">
	<div class="portlet-header">Top-10 Attackers</div>
	<div class="portlet-content">
		<p align="center">
		<? include("../lib/top10attackers.php"); ?>
		</p>
	</div>
    </div>
</div>
<div class="column" id="col3">
    <div class="portlet" id="Chart1.php">
        <div class="portlet-header">Chart Alerts</div>
        <div class="portlet-content">
		<p align="center">
		<? include("../lib/chart1.php"); ?>
		</p>
        </div>
    </div>
    <div class="portlet" id="Chart2.php">
	<div class="portlet-header">Chart Suspicious</div>
	<div class="portlet-content">
		<p align="center">
		<? include("../lib/chart2.php"); ?>
		</p>
	</div>
    </div>
</div>
 

</body>
</html>
