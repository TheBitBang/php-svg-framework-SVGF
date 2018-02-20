<?php

/**
 * SplitPathExample.php
 *
 * This file contains examples of a path being split in its component paths.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\css\CSSStyleDeclaration;
use b1t\svg\SVGSVGElement;
use b1t\svg\SVGPathElement;
use b1t\svgf\utils\SVGUtils;
use b1t\svgf\utils\SVGPathDataUtils;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$dom_doc_svg_aux = new \DOMDocument('1.0', 'utf-8');

$svg_svg = SVGUtils::svg($dom_doc_svg,'a4',SVGUtils::SIZE_A4);

// create path
$svg_path = new SVGPathElement($dom_doc_svg_aux);
$svg_path->style= 'fill:none;fill-rule:evenodd;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1';
$svg_path->setD('m 129.39192,24.869297 c -0.75878,0.0692 2.78503,2.92273 12.23402,10.53204 l 30.23667,24.35009 -48.08167,-13.91461 c 57.49941,27.82834 57.99511,57.644813 57.49942,27.82873 -0.49568,-29.81608 36.68075,-21.3683 -1.48696,-29.81619 -26.2403,-5.80792 -48.73218,-19.13219 -50.40148,-18.98006 z m -26.92539,38.3603 -3.469898,41.245643 41.637838,-13.914133 c 41.6375,-13.91417 13.38337,-2.4846 -29.74118,-6.46008 l -8.42676,-20.87143 z m 77.82237,43.730323 -71.87404,1.98794 71.87404,-1.98794 z m -11.89619,17.88952 32.21961,70.06786 -32.21961,-70.06786 z M 123.60225,55.599477 A 31.202026,7.1161235 0 0 1 102.0148,62.369338 31.202026,7.1161235 0 0 1 67.123462,59.7716 a 31.202026,7.1161235 0 0 1 0.0847,-8.370793 31.202026,7.1161235 0 0 1 34.943508,-2.561005 l -9.751398,6.759675 z');

$svg_g_aux = SVGPathDataUtils::splitPathInPaths($dom_doc_svg_aux,$svg_path); // split path
$svg_g = $dom_doc_svg->importNode($svg_g_aux, true); // copy element to display document
$svg_svg->appendChild($svg_g);
$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;