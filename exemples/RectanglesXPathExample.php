<?php

/**
 * BasicShapesExample.php
 *
 * This file contains examples of finding elements in SVG using XPath.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\svg\SVGRectElement;
use b1t\svgf\utils\SVGUtils;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');

$svg_svg = SVGUtils::svg($dom_doc_svg,'hd',SVGUtils::SIZE_HD);

$id = 1;

for ($i=100; $i<620; $i=$i+82) {
	for ($j=100; $j<1180; $j=$j+82) {
		// create rectangle
		$svg_rect = SVGUtils::rect($dom_doc_svg,80,80,$id++,$j,$i);
		$svg_svg->appendChild($svg_rect);
	}
}

// get the DOM representation
$xpath = new \DOMXPath($dom_doc_svg);

// perform search to change stroke color of the rectangles in the diagonal to red 
$matches = $xpath->query("//rect[@x=@y]");
foreach ($matches as $match) {
	$match->style->setProperty('stroke','#ff0000','');
	$match->style->setProperty('stroke-width','5','');
}		

// perform search to change fill color of the rectangles multiple of 4 to blue
$matches = $xpath->query("//rect");
foreach ($matches as $match) {
	$id = $match->id;
	if ($id % 4 == 0) 
	{ // if id is a multiple of 4
		$match->style->setProperty('fill','#0000ff','');
	}
}		

// perform search to round the corners of the rectangles multiple of 6
$matches = $xpath->query("//rect");
foreach ($matches as $match) {
	$id = $match->id;
	if ($id % 19 == 0) 
	{ // if id is a multiple of 6
		$match->rx = 20;
		$match->ry = 20;
	}
}		

// perform search to change fill color of the rectangle number 10 to green
$matches = $xpath->query("//rect[@id='10']");
foreach ($matches as $match) {
	$match->style->setProperty('fill','green','');
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;