<?php

/**
 * connect_elements_sides_text_offset.php
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
$svg_svg->setWidth('300px');
$svg_svg->setHeight('100px');
$svg_svg->setViewBox('0 0 300 100');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create elements
$svg_text_left_top = SVGFElement::text($dom_doc_svg,'Hello World!','text_left_top',30,20,'Helvetica','12px','normal','#861a22');
$svg_text_left_middle = SVGFElement::text($dom_doc_svg,'Hello World!','text_left_middle',80,50,'Helvetica','8px','normal','#d9737a');
$svg_text_left_bottom = SVGFElement::text($dom_doc_svg,'Hello World!','text_left_bottom',30,80,'Helvetica','12px','normal','#861a22');
$svg_text_right_top = SVGFElement::text($dom_doc_svg,'Hello World!','text_right_top',160,20,'Helvetica','12px','normal','#861a22');
$svg_text_right_middle = SVGFElement::text($dom_doc_svg,'Hello World!','text_right_middle',130,50,'Helvetica','8px','normal','#d9737a');
$svg_text_right_bottom = SVGFElement::text($dom_doc_svg,'Hello World!','text_right_bottom',160,80,'Helvetica','12px','normal','#861a22');

// create connectors
$svg_connector_1 = SVGFConnector::sides($dom_doc_svg,$svg_text_left_top,$svg_text_left_middle,'connector_1','#d9737a',2);
$svg_connector_2 = SVGFConnector::sides($dom_doc_svg,$svg_text_left_middle,$svg_text_left_bottom,'connector_2','#d9737a',2);
$svg_connector_3 = SVGFConnector::sides($dom_doc_svg,$svg_text_right_top,$svg_text_right_middle,'connector_3','#d9737a',2);
$svg_connector_4 = SVGFConnector::sides($dom_doc_svg,$svg_text_right_middle,$svg_text_right_bottom,'connector_4','#d9737a',2);

$svg_svg->appendChild($svg_text_left_top);
$svg_svg->appendChild($svg_text_left_middle);
$svg_svg->appendChild($svg_text_left_bottom);
$svg_svg->appendChild($svg_text_right_top);
$svg_svg->appendChild($svg_text_right_middle);
$svg_svg->appendChild($svg_text_right_bottom);
$svg_svg->appendChild($svg_connector_1);
$svg_svg->appendChild($svg_connector_2);
$svg_svg->appendChild($svg_connector_3);
$svg_svg->appendChild($svg_connector_4);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;