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

// Create border for elements with fill #861a22.
$matches = $xpath->query("//*");
foreach ($matches as $match) {
	$fill = $match->style->getPropertyValue('fill');
	if ($fill == '#861a22') {
		$match->style->setProperty('stroke','#1a867e','');
		$match->style->setProperty('stroke-width',5,'');
	}
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;