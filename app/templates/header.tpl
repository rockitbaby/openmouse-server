<!DOCTYPE html> 
<html> 
	<head> 
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" media="screen" href="/public/css/960gs.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/public/css/screen.css" />
		<script type="text/javascript" src="/public/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="/public/js/jquery.sparklines.min.js"></script>
		<title>
		Open Mouse Browser
		</title>
		<script type="text/javascript">
		    $(function() {
			
				var linesRendered = 0;
				var $lines = $('.inlinesparkline');
				var renderTimer = null;
				function renderSparkline() {
					
					if($lines.size() > linesRendered) {
						$($lines.eq(linesRendered)).sparkline('html', {type: 'discrete', lineColor: '#00cccd', height: 25, thresholdColor: '#000', thresholdValue: '20', lineHeight: 5});
						linesRendered++;
					} else {
						window.clearInterval(renderTimer);
					}
					
				}
				
				renderTimer = window.setInterval(renderSparkline, 100);
				
			});
		</script>
	</head>
<?php
$bodyclass = isset($bodyclass) ? $bodyclass : '';
?>
	<body id="muffin">
	
	<div id="global">
		<div id="wrapper">
	<header>
		<h1>Open Mouse Browser</h1>
	</header>
	<div id="content" class="container_12">
		