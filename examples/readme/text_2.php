<?php

/**
 * text_2.php
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
$svg_text = SVGUtils::text($dom_doc_svg,'Hello World!','text_hello','0','20');
$svg_svg->appendChild($svg_text);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;