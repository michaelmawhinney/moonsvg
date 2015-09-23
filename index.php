<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title>Moon SVG Drawer</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<style>

body {
	background: black;
	color: white;
	font-family: "Open Sans", sans-serif;
}

.moon-container {
    width: 20em;
}

</style>

</head>
<body>

<h1>SVG Rendering of the Moon<h1>

<?php

require("moonsvg.php");

$illum = rand(0,100);
$waxing = boolval( rand(0,1) );
$fill = "white";
$precision = 2;

echo "<h2>$illum% illuminated</h2>\n";

echo moonsvg($illum, $waxing, $fill, $precision);

?>

</body>
</html>


