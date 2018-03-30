<?php

/**
 * align_1.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGGElement;
use b1t\svgf\SVGFNew;
use b1t\svgf\SVGFAlign;
use b1t\svgf\geometry\SVGFObjectBox;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('150px');
$svg_svg->setHeight('100px');
$svg_svg->setViewBox('0 0 150 100');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create rectangles
$svg_rect_1 = SVGFNew::rect($dom_doc_svg,30,30,'rect_1',15,35,null,null,'#d9737a','#1a867e',4);
$svg_rect_1->style->setProperty('stroke-dasharray','8 2','');
$svg_rect_2 = SVGFNew::rect($dom_doc_svg,20,20,'rect_2',115,40,null,null,'#861a22');
$svg_rect_0 = SVGFNew::rect($dom_doc_svg,50,50,'rect_0',50,25,null,null,'#d9737a');

// align
$svg_rect_1 = SVGFAlign::align($svg_rect_1,$svg_rect_0,SVGFObjectBox::ALIGN_BOTTOM);
$svg_rect_2 = SVGFAlign::align($svg_rect_2,$svg_rect_0,SVGFObjectBox::ALIGN_RIGHT);

$svg_svg->appendChild($svg_rect_0);
$svg_svg->appendChild($svg_rect_1);
$svg_svg->appendChild($svg_rect_2);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;