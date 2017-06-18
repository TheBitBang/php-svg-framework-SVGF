<?php

/**
 * BasicShapesExample.php
 *
 * This file contains basic shapes creation examples.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/..' . '/vendor/autoload.php');;

use b1t\css\CSSStyleDeclaration;
use b1t\svg\SVGSVGElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGCircleElement;
use b1t\svgf\doc\CreateSVGPage;

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');

$svg_svg = CreateSVGPage::svgPage($dom_doc_svg,'a4',CreateSVGPage::SIZE_A4);

// create rectangle
$svg_rect = new SVGRectElement($dom_doc_svg);
$svg_rect->setX('100');
$svg_rect->setY('130');
$svg_rect->setWidth('60');
$svg_rect->setHeight('60');
$svg_rect->style = 'stroke:#ff0000;stroke-width:2;';
$svg_svg->appendChild($svg_rect);

// create circle
$svg_circle = new SVGCircleElement($dom_doc_svg);
$svg_circle->cx = '250';
$svg_circle->cy = '100';
$svg_circle->r = '40';
$svg_circle->style->setProperty('fill','#ff0000','');
$svg_circle->style->setProperty('stroke','black','');
$svg_svg->appendChild($svg_circle);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;