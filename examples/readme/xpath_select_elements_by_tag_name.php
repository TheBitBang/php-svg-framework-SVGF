<?php

/**
 * xpath_select_elements_by_tag_name.php
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

// Change fill color of circle elements to #1a867e. Move them 25px down and 20px to the right
$matches = $xpath->query("//circle");
foreach ($matches as $match) {
	$match->style->setProperty('fill','#1a867e','');
	$match->cy = $match->cy + 25;
	$match->cx = $match->cx + 20;
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;