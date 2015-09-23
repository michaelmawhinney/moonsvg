<?php

// Moon SVG Drawer v1.0 (Wed Sep 23 17:44:45 EDT 2015)
// This function returns a string containing HTML code for svg of the current moon phase.
// The returned HTML element SVG has id "moon-svg" and is contained in a DIV with id "moon-container".
// - $illumination is a percentage value between 0 and 100.
// - $waxing is a boolean: waxing phase = true, waning phase = false.
// - $precision can be adjusted, however a value higher than 2 has no effect when rendered.
function moonsvg( $illumination = 100, $waxing = true, $fill = "black", $precision = 2 ) {

	$output = "";
	$width = 100;
	$height = $width;
	$vbw = $width + 2; // viewBox width
	$vbh = $height + 2; // viewBox height
	$color = $fill;

	// calculate the center point and radius, and offset by 1 to avoid clipping at edges
	$cx = round(($width)/2,$precision)+1;
	$cy = round(($height)/2,$precision)+1;
	$radius = round(($width)/2,$precision)-1;

	// calculate the arc's x-radius -- i.e. the second radius of the half-ellipse
	$arcrad = round((abs($illumination-50)/50)*$radius,$precision);

	// set the sweep flag for the 3 arcs
	$sf1=1; $sf2=0; $sf3=0;

	// determine moon phase direction
	if( $waxing == false ) { // waning
		$sf1=0;	$sf3=1;
		if( $illumination<50 ) {
			$sf2=1;
		}
	}
	else { // waxing
		if( $illumination>=50 ) {
			$sf2=1;
		}
	}

	if ($illumination==100): // full moon -- draw 1 circle

		$output = <<<EOD
<div class="moon-container">
<svg class="moon-svg" preserveAspectRatio="xMinYMin meet" viewBox="0 0 $vbw $vbh">
<g><circle cx="$cx" cy="$cy" r="$radius" style="stroke:$color;stroke-width:2;fill:$color"></circle></g>
</svg>
</div>
EOD;

	elseif ($illumination==0): // new moon -- draw 1 circle

		$output = <<<EOD
<div class="moon-container">
<svg class="moon-svg" preserveAspectRatio="xMinYMin meet" viewBox="0 0 $vbw $vbh">
<g><circle cx="$cx" cy="$cy" r="$radius" style="stroke:$color;stroke-width:2;stroke-dasharray:5,5;fill:$color"></circle></g>
</svg>
</div>
EOD;

	elseif ($illumination==50): // half moon -- draw 2 circular arcs and a line

		$output = <<<EOD
<div class="moon-container">
<svg class="moon-svg" preserveAspectRatio="xMinYMin meet" viewBox="0 0 $vbw $vbh"><g>
<path d="M $cx 1 A $radius,$radius 0 0 $sf1 $cx,$height Z" style="stroke:$color;stroke-width:2;fill:$color"></path>
<path d="M $cx 1 A $radius,$radius 0 0 $sf3 $cx,$height" style="stroke:$color;stroke-width:2;stroke-dasharray:5,5;fill:none"></path>
</g></svg>
</div>
EOD;

	else: // crescent or gibbous -- draw 2 circular arcs and an elliptical arc

	$output = <<<EOD
<div class="moon-container">
<svg class="moon-svg" preserveAspectRatio="xMinYMin meet" viewBox="0 0 $vbw $vbh"><g>
<path d="M $cx 1 A $radius,$radius 0 0 $sf1 $cx,$height A $arcrad,$radius 0 0 $sf2 $cx,1" style="stroke:$color;stroke-width:2;fill:$color"></path>
<path d="M $cx 1 A $radius,$radius 0 0 $sf3 $cx,$height" style="stroke:$color;stroke-width:2;stroke-dasharray:5,5;fill:none"></path>
</g></svg>
</div>
EOD;

	endif;

	return $output;

}

?>
