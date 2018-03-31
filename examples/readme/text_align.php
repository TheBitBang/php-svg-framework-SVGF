<?php

/**
 * text_align.php
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
$svg_svg->setWidth('400px');
$svg_svg->setHeight('120px');
$svg_svg->setViewBox('0 0 400 120');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

// create rectangle
$svg_rect = SVGFNew::rect($dom_doc_svg,80,80,'rect',180,20,null,null,'#d9737a');

// create text
$svg_text_0 = SVGFNew::text($dom_doc_svg,'CENTERED','text_0',0,0,'Helvetica','10px','normal','#861a22');
$svg_text_1 = SVGFNew::text($dom_doc_svg,'On top and left aligned','text_1',0,0,'Helvetica','16px','normal','#861a22');
$svg_text_2 = SVGFNew::text($dom_doc_svg,'Aligned with bottom-right corner','text_2',0,0,'Helvetica','10px','normal','#861a22');
$svg_text_3 = SVGFNew::text($dom_doc_svg,'Below and to the right','text_3',0,0,'Helvetica','14px','normal','#861a22');
$svg_text_4 = SVGFNew::text($dom_doc_svg,'To the left','text_4',0,50,'Helvetica','24px','normal','#861a22');

// align text
$svg_text_0 = SVGFAlign::align($svg_text_0,$svg_rect,SVGFObjectBox::ALIGN_CENTER); // 'CENTERED' 10px
$svg_text_1 = SVGFAlign::align($svg_text_1,$svg_rect,SVGFObjectBox::ALIGN_LEFT); // 'On top and left aligned' 16px
$svg_text_1 = SVGFAlign::align($svg_text_1,$svg_rect,SVGFObjectBox::POSITION_TOP);
$svg_text_2 = SVGFAlign::align($svg_text_2,$svg_rect,SVGFObjectBox::ALIGN_RIGHT); // 'Aligned with bottom-right corner' 10px
$svg_text_2 = SVGFAlign::align($svg_text_2,$svg_rect,SVGFObjectBox::ALIGN_BOTTOM);
$svg_text_3 = SVGFAlign::align($svg_text_3,$svg_rect,SVGFObjectBox::POSITION_BOTTOM); // 'Below and to the right' 14px
$svg_text_3 = SVGFAlign::align($svg_text_3,$svg_rect,SVGFObjectBox::POSITION_RIGHT);
$svg_text_4 = SVGFAlign::align($svg_text_4,$svg_rect,SVGFObjectBox::POSITION_LEFT); // 'To the left' 24px (y=50)

$svg_svg->appendChild($svg_rect);
$svg_svg->appendChild($svg_text_0);
$svg_svg->appendChild($svg_text_1);
$svg_svg->appendChild($svg_text_2);
$svg_svg->appendChild($svg_text_3);
$svg_svg->appendChild($svg_text_4);

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;