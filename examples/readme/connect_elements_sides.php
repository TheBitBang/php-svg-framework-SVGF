<?php

/**
 * connect_elements_sides.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGPoint;
use b1t\svgf\SVGFElement;
use b1t\svgf\SVGFConnector;
use b1t\svgf\lib\SVGFMarker;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('300');
$svg_svg->setHeight('150');
$svg_svg->setViewBox('0 0 300 150');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create elements
$svg_rect_left = SVGFElement::rect($dom_doc_svg,80,40,'rect_left',5,90,null,null,'#d9737a');
$svg_rect_left_top = SVGFElement::rect($dom_doc_svg,80,40,'rect_left_top',50,20,null,null,'#d9737a');
$svg_rect_left_bottom = SVGFElement::rect($dom_doc_svg,40,20,'rect_left_bottom',130,90,null,null,'#d9737a');
$svg_rect_right_top = SVGFElement::rect($dom_doc_svg,80,40,'rect_right_top',135,20,null,null,'#d9737a');
$svg_rect_right_bottom = SVGFElement::rect($dom_doc_svg,40,20,'rect_right_bottom',175,90,null,null,'#d9737a');

// create connectors
$svg_connector_1 = SVGFConnector::sides($dom_doc_svg,$svg_rect_left_bottom,$svg_rect_left,'connector_1','#861a22');
$svg_connector_2 = SVGFConnector::sides($dom_doc_svg,$svg_rect_left_top,$svg_rect_left_bottom,'connector_2','#861a22');
$svg_connector_3 = SVGFConnector::sides($dom_doc_svg,$svg_rect_right_bottom,$svg_rect_right_top,'connector_3','#861a22');

$svg_svg->appendChild($svg_rect_left);
$svg_svg->appendChild($svg_rect_left_top);
$svg_svg->appendChild($svg_rect_left_bottom);
$svg_svg->appendChild($svg_rect_right_top);
$svg_svg->appendChild($svg_rect_right_bottom);
$svg_svg->appendChild($svg_connector_1);
$svg_svg->appendChild($svg_connector_2);
$svg_svg->appendChild($svg_connector_3);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;