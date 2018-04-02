<?php

/**
 * connect_elements_center.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGPoint;
use b1t\svgf\SVGFNew;
use b1t\svgf\SVGFConnectors;
use b1t\svgf\lib\SVGFMarkers;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('150px');
$svg_svg->setHeight('100px');
$svg_svg->setViewBox('0 0 150 100');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create defs
$svg_defs = SVGFNew::defs($dom_doc_svg,'marker');

// create markers
$svg_marker_arrow_end = SVGFMarkers::markerArrowEnd($dom_doc_svg,'marker_arrow_end','path_arrow_end','#861a22',7);

$svg_defs->appendChild($svg_marker_arrow_end);

// create elements
$svg_circle = SVGFNew::circle($dom_doc_svg,10,'circle',25,50,'#d9737a');
$svg_rect = SVGFNew::rect($dom_doc_svg,40,40,'rect',65,10,null,null,'#d9737a');
$svg_text = SVGFNew::text($dom_doc_svg,'Hello World!','text_hello',60,90,'Helvetica','12px','normal','#d9737a');

// create connectors
$svg_connector_1 = SVGFConnectors::connectElements($dom_doc_svg,$svg_circle,$svg_rect,'#861a22','1px','connector_1',null,'marker_arrow_end');
$svg_connector_2 = SVGFConnectors::connectElements($dom_doc_svg,$svg_rect,$svg_text,'#861a22','1px','connector_2',null,'marker_arrow_end');

$svg_svg->appendChild($svg_defs);
$svg_svg->appendChild($svg_circle);
$svg_svg->appendChild($svg_rect);
$svg_svg->appendChild($svg_text);
$svg_svg->appendChild($svg_connector_1);
$svg_svg->appendChild($svg_connector_2);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;