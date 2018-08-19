<?php

/**
 * BasicShapesExample.php
 *
 * This file contains the following infographic template: nested horizontal list.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGGElement;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svgf\SVGFElement;
use b1t\svgf\SVGFConnector;
use b1t\svgf\lib\SVGFMarker;
use b1t\svgf\SVGFAlign;
use b1t\svgf\geometry\SVGFObjectBox;

// read json data
$str_data = file_get_contents("./nested_list-horizontal.json"); // read the json data file
$data = json_decode($str_data, true); // decode the data

// read settings from configuration
$font_family = $data['settings']['font_family'];
$lvl_1_background_color = '#' . $data['settings']['level_1_background_color'];
$lvl_2_background_color = '#' . $data['settings']['level_1_background_color'];
$lvl_3_background_color = '#' . $data['settings']['level_1_background_color'];
$lvl_1_text_color = '#' . $data['settings']['level_1_text_color'];
$lvl_2_text_color = '#' . $data['settings']['level_1_text_color'];
$lvl_3_text_color = '#' . $data['settings']['level_1_text_color'];

// variable definition
$canvas_size = SVGFElement::SIZE_FHD;
$infographic_width = SVGFElement::SIZE_FHD[2]; // 1920 px
$lvl_1_width = ceil($infographic_width * 0.833); // 1600 px
$lvl_1_y = $infographic_width / 192; // 10px
$lvl_1_height = $infographic_width / 24; // 80 px
$lvl_2_height = $infographic_width / 24; // 80 px
$lvl_3_height = $infographic_width / 48; // 40 px
$lvl_2_indent =  $infographic_width / 32; // 60 px
$lvl_3_indent = $infographic_width / 96; // 20 px
$lvl_3_indent_text = $infographic_width / 96; // 20 px
$connector_lvls_1_2_height =  $infographic_width / 48; // 40 px
$connector_lvls_2_3_height = $infographic_width / 96; // 20 px
$spacing_px = $infographic_width / 960; // 2 px;
$spacing_between_levels_px = $infographic_width / 960; // 2 px;
$lvl_1_font_size = $infographic_width / 60 . 'px'; // 32 px
$lvl_2_font_size = $infographic_width / 76.8 . 'px'; // 25 px
$lvl_3_font_size = $infographic_width / 128 . 'px'; // 15 px

$dom_doc_svg = new \DOMDocument('1.0', 'utf-8'); // create the document

$svg_svg = SVGFElement::svg($dom_doc_svg,'infographic-nested-horizontal-list',$canvas_size); // create svg elment
//$svg_svg->style->setProperty('background',"#000000",''); // uncomment to visualize canvas

// calculations for level 1
$lvl_1_num_elements = count($data['content']); // get number of elements in level 1
$lvl_1_x = ($infographic_width - $lvl_1_width) / 2; // calculate x of first level 1 element
$lvl_1_width_element = ($lvl_1_width - (($lvl_1_num_elements - 1) * $spacing_px) ) / $lvl_1_num_elements; // calculate width of level 1 elements

$lvl_1_reference_alignment = null;


foreach ($data['content'] as $lvl_1_key => $lvl_1_value) { // first level

	// create the element
	$lvl_1_element = SVGFElement::rect($dom_doc_svg,$lvl_1_width_element,$lvl_1_height,"element_root",$lvl_1_x,$lvl_1_y,null,null,$lvl_1_background_color);

	// align element
	if($lvl_1_reference_alignment != null)
	{
		$lvl_1_element = SVGFAlign::align($lvl_1_element,$lvl_1_reference_alignment,SVGFObjectBox::POSITION_RIGHT,$spacing_px);
	}
	$lvl_1_reference_alignment = $lvl_1_element; // change level 1 alignment element

	// create text
	$lvl_1_element_text = SVGFElement::text($dom_doc_svg,$lvl_1_key,"text_root",0,0,$font_family,$lvl_1_font_size,'bold',$lvl_1_text_color);
	$lvl_1_element_text = SVGFAlign::align($lvl_1_element_text,$lvl_1_element,SVGFObjectBox::ALIGN_CENTER);
	// add elements
	$svg_svg->appendChild($lvl_1_element);
	$svg_svg->appendChild($lvl_1_element_text);


	// calculations for level 2
	$lvl_2_reference_alignment = null;
	$num_elements_level_2 = count($lvl_1_value);
	$lvl_2_width = $lvl_1_width_element - ($lvl_2_indent * 2);
	$lvl_2_width_element = ($lvl_2_width - (($num_elements_level_2 -1) * $spacing_px)) / $num_elements_level_2;

	foreach ($lvl_1_value as $lvl_2_key => $lvl_2_value) {
		// create the element
		$lvl_2_element = SVGFElement::rect($dom_doc_svg,$lvl_2_width_element,$lvl_2_height,"element_$lvl_2_key",0,0,null,null,$lvl_2_background_color);

		// align element
		if($lvl_2_reference_alignment == null)
		{
			$lvl_2_element = SVGFAlign::align($lvl_2_element,$lvl_1_reference_alignment,SVGFObjectBox::ALIGN_LEFT,$lvl_2_indent);  // align horizontally
		}
		else
		{
			$lvl_2_element = SVGFAlign::align($lvl_2_element,$lvl_2_reference_alignment,SVGFObjectBox::POSITION_RIGHT,$spacing_px); // align horizontally
		}
		$lvl_2_element = SVGFAlign::align($lvl_2_element,$lvl_1_reference_alignment,SVGFObjectBox::POSITION_BOTTOM,0,$connector_lvls_1_2_height); // align vertically
		$lvl_2_reference_alignment = $lvl_2_element; // change level 2 alignment element

		// create text
		$lvl_2_element_text = SVGFElement::text($dom_doc_svg,$lvl_2_key,"text_$lvl_2_key",0,0,$font_family,$lvl_2_font_size,'bold',$lvl_2_text_color);
		$lvl_2_element_text = SVGFAlign::align($lvl_2_element_text,$lvl_2_element,SVGFObjectBox::ALIGN_CENTER);

		// create connector
		$lvl_1_element_aux;
		$aux_y = $lvl_1_y + $lvl_1_height;
		if ($num_elements_level_2 == 1) {
			$lvl_1_element_aux = SVGFElement::rect($dom_doc_svg,$lvl_1_width_element,1,"aux_element",$lvl_1_x,$aux_y,null,null,'#000000');
		} else {
			switch (array_search($lvl_2_key,array_keys($lvl_1_value))) {
				case 0: // first element
					$lvl_1_element_aux = SVGFElement::rect($dom_doc_svg,($lvl_2_indent + $lvl_2_width_element),1,"aux_element",0,$aux_y,null,null,'#000000');
					$lvl_1_element_aux = SVGFAlign::align($lvl_1_element_aux,$lvl_2_reference_alignment,SVGFObjectBox::ALIGN_RIGHT);
					break;
				case $num_elements_level_2 - 1: // last element
					$lvl_1_element_aux = SVGFElement::rect($dom_doc_svg,$lvl_2_indent + $lvl_2_width_element,1,"aux_element",0,$aux_y,null,null,'#000000');
					$lvl_1_element_aux = SVGFAlign::align($lvl_1_element_aux,$lvl_2_reference_alignment,SVGFObjectBox::ALIGN_LEFT);
					break;
				default:
					$lvl_1_element_aux = SVGFElement::rect($dom_doc_svg,$lvl_2_width_element,1,"aux_element",0,$aux_y,null,null,'#000000');
					$lvl_1_element_aux = SVGFAlign::align($lvl_1_element_aux,$lvl_2_reference_alignment,SVGFObjectBox::ALIGN_LEFT);
					break;
			}
		}

		$lvl_2_element_connector = SVGFConnector::sides($dom_doc_svg,$lvl_1_element_aux,$lvl_2_element,"connector_$key",'#861a22',$spacing_between_levels_px);
		$svg_svg->appendChild($lvl_2_element_connector);

		// remove aux element
		$svg_svg->appendChild($lvl_1_element_aux);
		$svg_svg->removeChild($lvl_1_element_aux);

		// add elements
		$svg_svg->appendChild($lvl_2_element);
		$svg_svg->appendChild($lvl_2_element_text);

		// calculations for level 3
		$lvl_3_reference_alignment = null;
		$num_elements_level_3 = count($lvl_2_value);
		$lvl_3_width_element = $lvl_2_width_element - ($lvl_3_indent * 2);

		if ($num_elements_level_3 > 0) {
			foreach ($lvl_2_value as $lvl_3_key => $lvl_3_value) {

				// create the element and align with the level 1
				$lvl_3_element = SVGFElement::rect($dom_doc_svg,$lvl_3_width_element,$lvl_3_height,"element_$lvl_3_key",0,0,null,null,$lvl_3_background_color);

				// align element
				$lvl_3_element = SVGFAlign::align($lvl_3_element,$lvl_2_reference_alignment,SVGFObjectBox::ALIGN_LEFT,$lvl_3_indent); // align horizontally

				// create connector
				if (array_search($lvl_3_key,array_keys($lvl_2_value)) == 0) { // first element
					$lvl_3_element = SVGFAlign::align($lvl_3_element,$lvl_2_reference_alignment,SVGFObjectBox::POSITION_BOTTOM,0,$connector_lvls_2_3_height); // align vertically
					$lvl_2_element_connector = SVGFConnector::sides($dom_doc_svg,$lvl_2_element,$lvl_3_element,"connector_$lvl_1_key",'#861a22',$spacing_between_levels_px);
					$svg_svg->appendChild($lvl_2_element_connector);
				}
				else
				{
					$lvl_3_element = SVGFAlign::align($lvl_3_element,$lvl_3_reference_alignment,SVGFObjectBox::POSITION_BOTTOM,0,$spacing_between_levels_px); // align vertically
				}

				// create text
				$lvl_3_element_text = SVGFElement::text($dom_doc_svg,$lvl_3_key,"text_$lvl_3_key",0,0,$font_family,$lvl_3_font_size,'bold',$lvl_3_text_color);
				$lvl_3_element_text = SVGFAlign::align($lvl_3_element_text,$lvl_3_element,SVGFObjectBox::ALIGN_CENTER);
				$lvl_3_element_text = SVGFAlign::align($lvl_3_element_text,$lvl_3_element,SVGFObjectBox::ALIGN_LEFT,$lvl_3_indent_text);

				$svg_svg->appendChild($lvl_3_element);
				$svg_svg->appendChild($lvl_3_element_text);

				$lvl_3_reference_alignment = $lvl_3_element; // change level 3 alignment element

			}
		}

	}

}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;