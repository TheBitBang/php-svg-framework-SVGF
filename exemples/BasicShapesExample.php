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
use b1t\svgf\doc\CreateSVGPage;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-16');

$svg_svg = CreateSVGPage::svgPage($dom_doc_svg,'a4',CreateSVGPage::SIZE_A4);

// create rectangle
$svg_rect = new SVGRectElement($dom_doc_svg);
$svg_rect->setX('100');
$svg_rect->setY('100');
$svg_rect->setWidth('100');
$svg_rect->setHeight('100');
$svg_rect->setRx('10');
$svg_rect->setRy('10');
$svg_svg->appendChild($svg_rect);

// create rectangle 2
$svg_rect2 = new SVGRectElement($dom_doc_svg);
$svg_rect2->x = '200';
$svg_rect2->y = '200';
$svg_rect2->width = '10';
$svg_rect2->height = '10';
$svg_rect2->rx = '5';
$svg_rect2->ry = '5';
$svg_svg->appendChild($svg_rect2);

// create circle
$svg_circle = new SVGCircleElement($dom_doc_svg);
$svg_circle->cx = '250';
$svg_circle->cy = '60';
$svg_circle->r = '40';
$svg_svg->appendChild($svg_circle);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;