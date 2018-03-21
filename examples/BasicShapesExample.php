<?php

/**
 * BasicShapesExample.php
 *
 * This file contains basic shapes creation examples.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGCircleElement;
use b1t\svgf\utils\SVGUtils;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');

$svg_svg = SVGUtils::svg($dom_doc_svg,'a4',SVGUtils::SIZE_A4);

// create rectangle
$svg_rect_1 = new SVGRectElement($dom_doc_svg);
$svg_rect_1->setId('rect_1');
$svg_rect_1->setX('100');
$svg_rect_1->setY('100');
$svg_rect_1->setWidth('100');
$svg_rect_1->setHeight('100');
$svg_rect_1->setRx('10');
$svg_rect_1->setRy('10');
$svg_svg->appendChild($svg_rect_1);

// create rectangle 2
$svg_rect_2 = new SVGRectElement($dom_doc_svg);
$svg_rect_2->id = 'rect_2';
$svg_rect_2->x = '200';
$svg_rect_2->y = '200';
$svg_rect_2->width = '10';
$svg_rect_2->height = '10';
$svg_rect_2->rx = '2';
$svg_rect_2->ry = '2';
$svg_svg->appendChild($svg_rect_2);

// create rectangle 3
$svg_rect_3 = SVGUtils::rect($dom_doc_svg,'50','50','rect_3','220','120','5','5','#d9737a','black');
$svg_svg->appendChild($svg_rect_3);

// create circle 1
$svg_circle_1 = new SVGCircleElement($dom_doc_svg);
$svg_circle_1->setId('circle_1');
$svg_circle_1->setCx('250');
$svg_circle_1->setCy('60');
$svg_circle_1->setR('40');
$svg_svg->appendChild($svg_circle_1);

// create circle 2
$svg_circle_2 = new SVGCircleElement($dom_doc_svg);
$svg_circle_2->id = 'circle_2';
$svg_circle_2->cx = '150';
$svg_circle_2->cy = '50';
$svg_circle_2->r = '10';
$svg_svg->appendChild($svg_circle_2);

// create circle 3
$svg_circle_3 = SVGUtils::circle($dom_doc_svg,'10','circle_3','150','60','#d9737a','black','3');
$svg_svg->appendChild($svg_circle_3);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;