<?php

/**
 * RectanglesXPathExample.php
 *
 * This file contains examples of finding elements in SVG using XPath.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\svg\SVGRectElement;
use b1t\svgf\SVGFNew;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');

$svg_svg = SVGFNew::svg($dom_doc_svg,'hd',SVGFNew::SIZE_HD);

$id = 1;

for ($i=100; $i<620; $i=$i+82) {
	for ($j=100; $j<1180; $j=$j+82) {
		// create rectangle
		$svg_rect = SVGFNew::rect($dom_doc_svg,80,80,$id++,$j,$i);
		$svg_svg->appendChild($svg_rect);
	}
}

// get the DOM representation
$xpath = new \DOMXPath($dom_doc_svg);

// perform search to change stroke color of the rectangles in the diagonal to #ad3d45
$matches = $xpath->query("//rect[@x=@y]");
foreach ($matches as $match) {
	$match->style->setProperty('stroke','#ad3d45','');
	$match->style->setProperty('stroke-width','5','');
}

// perform search to change fill color of the rectangles multiple of 4 to #d9737a
$matches = $xpath->query("//rect");
foreach ($matches as $match) {
	$id = $match->id;
	if ($id % 4 == 0) 
	{ // if id is a multiple of 4
		$match->style->setProperty('fill','#d9737a','');
	}
}

// perform search to round the corners of the rectangles multiple of 19
$matches = $xpath->query("//rect");
foreach ($matches as $match) {
	$id = $match->id;
	if ($id % 19 == 0) 
	{ // if id is a multiple of 19
		$match->rx = 20;
		$match->ry = 20;
	}
}

// perform search to change fill color of the rectangle number 10 to ruby red
$matches = $xpath->query("//rect[@id='10']");
foreach ($matches as $match) {
	$match->style->setProperty('fill','#861a22','');
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;