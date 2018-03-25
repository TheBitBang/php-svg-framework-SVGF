<?php

/**
 * xpath_select_elements_by_attribute_value.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svgf\file\SVGFImportFromSVG;

$path_to_file = './xpath_source_file.svg';
$dom_doc_svg = SVGFImportFromSVG::getSVGFromFile($path_to_file);

// get the DOM representation
$xpath = new \DOMXPath($dom_doc_svg);

// Create a corner radius of 15px in rect_1
$matches = $xpath->query("//rect[@id='rect_1']");
foreach ($matches as $match) {
	$match->rx = 15;
	$match->ry = 15;	
}

// Create a corner radius of 5px in rect_2
$matches = $xpath->query("//rect[@id='rect_2']");
foreach ($matches as $match) {
	$match->rx = 5;
	$match->ry = 5;
}

// Change fill color of rect elements with rx < 10 (or not set) to #1a867e.
$matches = $xpath->query("//rect[@rx<10] | rect[not(@rx)]");
foreach ($matches as $match) {
	$match->style->setProperty('fill','#1a867e','');
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;