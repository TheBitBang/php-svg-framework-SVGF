<?php

/**
 * xpath_source_file.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGGElement;
use b1t\svgf\SVGFElement;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('150px');
$svg_svg->setHeight('100px');
$svg_svg->setViewBox('0 0 150 100');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create circles
$svg_circle_1 = SVGFElement::circle($dom_doc_svg,10,'circle_1',25,25);
$svg_circle_2 = SVGFElement::circle($dom_doc_svg,15,'circle_2',75,25,'#861a22');
$svg_circle_3 = SVGFElement::circle($dom_doc_svg,20,'circle_3',125,25,'#d9737a','#861a22',2);

// create rectangles
$svg_rect_1 = SVGFElement::rect($dom_doc_svg,40,40,'rect_1',5,55,null,null,'#d9737a','#861a22',2);
$svg_rect_2 = SVGFElement::rect($dom_doc_svg,30,30,'rect_2',60,60,null,null,'#861a22');
$svg_rect_3 = SVGFElement::rect($dom_doc_svg,20,20,'rect_3',115,65);

// create group
$svg_g =  new SVGGElement($dom_doc_svg);

$svg_svg->appendChild($svg_circle_2);
$svg_g->appendChild($svg_circle_1);
$svg_g->appendChild($svg_circle_3);
$svg_g->appendChild($svg_rect_2);
$svg_svg->appendChild($svg_g);
$svg_svg->appendChild($svg_rect_1);
$svg_svg->appendChild($svg_rect_3);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;