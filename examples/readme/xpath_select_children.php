<?php

/**
 * rect_100x100.php
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

// Change fill color of the g children elements to #1a867e
$matches = $xpath->query("//g/*");
foreach ($matches as $match) {
	$match->style->setProperty('fill','#1a867e','');
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;