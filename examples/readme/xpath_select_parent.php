<?php

/**
 * xpath_select_parent.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svgf\SVGFImportFromSVG;

$path_to_file = './xpath_source_file.svg';
$dom_doc_svg = SVGFImportFromSVG::getSVGFromFile($path_to_file);

// get the DOM representation
$xpath = new \DOMXPath($dom_doc_svg);

// Create style for parent of rect_2 (the style settings will be overriden if they are definied in the child element).
$matches = $xpath->query("//rect[@id='rect_2']");
foreach ($matches as $match) {
	$parent_svg = $match->parentNode;
	$parent_svg->style = 'stroke:#d9737a; stroke-width: 5; stroke-dasharray: 10 5; fill:#1a867e';
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;