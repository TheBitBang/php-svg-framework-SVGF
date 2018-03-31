<?php

/**
 * text_align_offset.php
 *
 * This file contains an example for readme visualization.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGTextElement;
use b1t\svgf\SVGFRectElement;
use b1t\svgf\SVGFNew;
use b1t\svgf\SVGFAlign;
use b1t\svgf\geometry\SVGFObjectBox;

// create svg document
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('300px');
$svg_svg->setHeight('120px');
$svg_svg->setViewBox('0 0 300 120');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create rectangle
$svg_rect = SVGFNew::rect($dom_doc_svg,80,80,'rect',110,20,null,null,'#d9737a');

// create text
$svg_text_0 = SVGFNew::text($dom_doc_svg,'offset top','text_0',0,0,'Helvetica','8px','normal','#861a22');
$svg_text_1 = SVGFNew::text($dom_doc_svg,'offset right','text_1',0,0,'Helvetica','16px','normal','#861a22');
$svg_text_2 = SVGFNew::text($dom_doc_svg,'offset center','text_2',0,0,'Helvetica','10px','normal','#861a22');

// align text
$svg_text_0 = SVGFAlign::align($svg_text_0,$svg_rect,SVGFObjectBox::ALIGN_CENTER); // 'offset top' 8px
$svg_text_0 = SVGFAlign::align($svg_text_0,$svg_rect,SVGFObjectBox::POSITION_TOP,0,-10);
$svg_text_1 = SVGFAlign::align($svg_text_1,$svg_rect,SVGFObjectBox::ALIGN_CENTER); // 'offset right' 16px
$svg_text_1 = SVGFAlign::align($svg_text_1,$svg_rect,SVGFObjectBox::POSITION_RIGHT,20);
$svg_text_2 = SVGFAlign::align($svg_text_2,$svg_rect,SVGFObjectBox::ALIGN_CENTER,-5,20); // 'offset center' 10px

$svg_svg->appendChild($svg_rect);
$svg_svg->appendChild($svg_text_0);
$svg_svg->appendChild($svg_text_1);
$svg_svg->appendChild($svg_text_2);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;