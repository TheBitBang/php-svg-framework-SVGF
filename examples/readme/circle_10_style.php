<?php

/**
 * circle_10_style.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGRectElement;
use b1t\svgf\SVGFElement;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('50px');
$svg_svg->setHeight('50px');
$svg_svg->setViewBox('0 0 50 50');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create circle
$svg_circle = SVGFElement::circle($dom_doc_svg,10,'circle_10_style',25,25);
$svg_circle->style->setProperty('fill','#d9737a','');
$svg_circle->style->setProperty('stroke','#861a22','');
$svg_circle->style->setProperty('stroke-width','2','');
$svg_svg->appendChild($svg_circle);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;