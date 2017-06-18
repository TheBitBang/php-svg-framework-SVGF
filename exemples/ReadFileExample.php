<?php

/**
 * BasicShapesExample.php
 *
 * This file contains an example of reading an SVG file.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\svgf\file\SVGFImportFromSVG;

$path_to_file = './RectanglesXPathExample.svg';
$dom_doc_svg = SVGFImportFromSVG::getSVGFromFile($path_to_file);

// get the DOM representation
$xpath = new \DOMXPath($dom_doc_svg);

// perform search to change fill color of the rectangles number 1 and 14 to green 
$matches = $xpath->query("//rect[@id='1'] | //rect[@id='14']");
foreach ($matches as $match) {
	$match->style->setProperty('fill','green','');
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;