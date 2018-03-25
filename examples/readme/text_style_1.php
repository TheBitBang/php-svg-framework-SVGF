<?php

/**
 * text_style_1.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGTextElement;
use b1t\svgf\utils\SVGUtils;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('200px');
$svg_svg->setHeight('40px');
$svg_svg->setViewBox('0 0 200 40');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create text
$svg_text = new SVGTextElement($dom_doc_svg);
$svg_text->nodeValue = 'Hello World!';
$svg_text->id = 'text_hello';
$svg_text->x = 0;
$svg_text->y = 20;
$svg_text->style->setProperty('font-family','Helvetica','');
$svg_text->style->setProperty('font-size','16px','');
$svg_text->style->setProperty('font-weight','bold','');
$svg_text->style->setProperty('fill','#d9737a','');
$svg_svg->appendChild($svg_text);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;