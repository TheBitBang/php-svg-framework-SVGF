<?php

/**
 * rect_100x100.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGRectElement;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('50px');
$svg_svg->setHeight('50px');
$svg_svg->setViewBox('0 0 50 50');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create rectangle
$svg_rect = new SVGRectElement($dom_doc_svg);
$svg_rect->id = 'rect_50x50_2';
$svg_rect->x = '0';
$svg_rect->y = '0';
$svg_rect->width = '50';
$svg_rect->height = '50';
$svg_rect->rx = '10';
$svg_rect->ry = '10';
$svg_svg->appendChild($svg_rect);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;