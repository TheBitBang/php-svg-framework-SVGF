<?php

/**
 * BasicShapesExample.php
 *
 * This file contains the following infographic template: vertical list.
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
use b1t\svgf\SVGFText;
use b1t\svgf\geometry\SVGFObjectBox;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;

// read json data
$str_data = file_get_contents("./list-vertical.json"); // read the json data file
$array_data = json_decode($str_data, true); // decode the data

// canvas definition
$canvas_size = SVGFElement::SIZE_FHD;
$canvas_width = SVGFElement::SIZE_FHD[2]; // 1920 px
$canvas_height = SVGFElement::SIZE_FHD[1]; // 1080 px

// document creation
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8'); // create the document
$svg_svg = SVGFElement::svg($dom_doc_svg,'infographic-list-vertical',$canvas_size); // create svg elment
//$svg_svg->style->setProperty('background',"#000000",''); // uncomment to visualize canvas

foreach ($array_data as $data)
{
	// read settings from configuration
	$data_id = $data['settings']['id'];
	$color_background = '#' . $data['settings']['color_background'];
	$color_text = '#' . $data['settings']['color_text'];
	$font_family = $data['settings']['font-family'];
	$alignment = $data['settings']['alignment'];
	$alignment_offset = $data['settings']['alignment_offset'];
	$orientation = $data['settings']['orientation'];
	$font_size = $data['settings']['font-size'];
	$margin_left = $data['settings']['margin-left'];
	$margin_right = $data['settings']['margin-right'];
	$fhd_x = $data['settings']['fhd_x'];
	$fhd_y = $data['settings']['fhd_y'];
	$fhd_row_witdh = $data['settings']['fhd_row_witdh'];
	$fhd_row_anchor_witdh = $data['settings']['fhd_row_anchor_witdh'];
	$fhd_row_connector_width = $data['settings']['fhd_row_connector_width'];
	$number_of_rows = count($data['content']['list']);

	// variable definition
	$entry_font_size = $canvas_width / 120 . 'px'; // 16 px
	$spacing_px = $canvas_width / 240; // 8
	$spacing_anchor_px = $spacing_px / 3;
	$row_height = ($canvas_width / 40);
	$x = $fhd_x * ($canvas_width / SVGFElement::SIZE_FHD[2]);
	$y = $fhd_y * ($canvas_height / SVGFElement::SIZE_FHD[1]);
	$row_anchor_height = $row_height / 20;
	$row_anchor_witdh = $fhd_row_anchor_witdh * ($canvas_width / SVGFElement::SIZE_FHD[2]);
	$row_width = $fhd_row_witdh * ($canvas_width / SVGFElement::SIZE_FHD[2]);
	$row_connector_width = $fhd_row_connector_width * ($canvas_width / SVGFElement::SIZE_FHD[2]);

	// draw content
	$title = $data['content']['title'];
	$svg_element__text = SVGFElement::text($dom_doc_svg,$title,"text_title",$x,$y,$font_family,$font_size,'normal',$color_background);
	$svg_svg->appendChild($svg_element__text);

	// set aligment reference
	$bbox_text = new SVGFObjectBoxTextElement($svg_element__text);
	$alignment_reference_y = $bbox_text->y_center;
	$alignment_reference_x = $bbox_text->x_min;
	$alignment_reference_width = $bbox_text->x_max - $bbox_text->x_min;
	$alignment_reference_element = SVGFElement::rect($dom_doc_svg,$alignment_reference_width,0,"aux_alignment_reference_element",$alignment_reference_x,$alignment_reference_y);

	$array_sides_items = array();
	$array_sides_items[$orientation] = $data['content']['list'];

	$is_orientation_both = ($orientation == 'both') ? true : false;

	if ($is_orientation_both)
	{
		$array_sides_items = array();
		$array_sides_items['left'] = array();
		$array_sides_items['right'] = array();
		$number_of_rows_left_side = ceil($number_of_rows / 2);
		$i=0;
		$i_side = 'left';
		foreach($data['content']['list'] as $row_key => $row_value)
		{
			if ($i==$number_of_rows_left_side)
			{
				$i_side = 'right';
			}
			$array_sides_items[$i_side][$row_key] = $row_value;
			$i++;
		}
		$orientation = 'left';
	}

	foreach ($array_sides_items as $side_items)
	{
		$number_of_rows = count($side_items);

		// set vertical anchor alignment
		$offset_anchor_vertical = getVerticalAnchorAlignment($number_of_rows, $row_anchor_height, $spacing_anchor_px);

		// set vertical alignment
		$offset_vertical = getVerticalAlignment($alignment, $orientation, $alignment_offset, $number_of_rows ,$row_height, $spacing_px, $row_anchor_height, $spacing_anchor_px);

		// create reference alignment element for anchor
		$row_anchor_reference_alignment = SVGFElement::rect($dom_doc_svg,1,1,"aux_alignment_anchor"); // element to be used as reference to position the first anchor row
		$row_anchor_reference_alignment = SVGFAlign::align($row_anchor_reference_alignment,$alignment_reference_element,SVGFObjectBox::POSITION_TOP,0,-$offset_anchor_vertical); // shift to fit first alignment
		$svg_svg->appendChild($row_anchor_reference_alignment);
		$svg_svg->removeChild($row_anchor_reference_alignment);

		// create reference alignment element for row
		$row_reference_alignment = SVGFElement::rect($dom_doc_svg,$row_width,$row_height+$spacing_px,"aux_alignment_row"); // element to be used as reference to position the first row
		$row_reference_alignment = SVGFAlign::align($row_reference_alignment,$alignment_reference_element,SVGFObjectBox::POSITION_TOP,0,-$offset_vertical); // shift to fit first alignment
		$svg_svg->appendChild($row_reference_alignment);
		$svg_svg->removeChild($row_reference_alignment);

		$i = 0;

		// create rows
		foreach($side_items as $row_key => $row_value)
		{
			// create row anchor
			$svg_element__row_anchor = SVGFElement::rect($dom_doc_svg,$row_anchor_witdh,$row_anchor_height,"anchor $data_id $row_key",0,0,0,0,$color_background);

			// align row anchor
			$svg_element__row_anchor = SVGFAlign::align($svg_element__row_anchor,$row_anchor_reference_alignment,SVGFObjectBox::POSITION_BOTTOM,0,$spacing_anchor_px); // align vertically
			// set orientation
			switch ($orientation)
			{
				case 'left':
					$svg_element__row_anchor = SVGFAlign::align($svg_element__row_anchor,$alignment_reference_element,SVGFObjectBox::POSITION_LEFT,-$spacing_px); // align horizontally  
					break;
				case 'right':
				default:
					$svg_element__row_anchor = SVGFAlign::align($svg_element__row_anchor,$alignment_reference_element,SVGFObjectBox::POSITION_RIGHT,$spacing_px); // align horizontally
					break;
			}

			$row_anchor_reference_alignment = $svg_element__row_anchor;

			// append row anchor
			$svg_svg->appendChild($svg_element__row_anchor);

			// create row
			$row_text = $row_value['text'];
			$svg_element__row_item = SVGFElement::rect($dom_doc_svg,$row_width,$row_height,"row_item $data_id $row_key",0,0,0,0,$color_background);
			$svg_element__row_text = SVGFElement::text($dom_doc_svg,$row_text,"row_item_text $data_id $row_key",0,0,$font_family,$entry_font_size,'normal',$color_text);

			// align row
			$svg_element__row_item = SVGFAlign::align($svg_element__row_item,$row_reference_alignment,SVGFObjectBox::POSITION_BOTTOM,0,$spacing_px); // align vertically

			// set orientation
			switch ($orientation)
			{
				case 'left':
					$svg_element__row_item = SVGFAlign::align($svg_element__row_item,$alignment_reference_element,SVGFObjectBox::POSITION_LEFT,-$row_anchor_witdh - 1 - $row_connector_width); // align horizontally
					$svg_element__row_text = SVGFAlign::align($svg_element__row_text,$svg_element__row_item,SVGFObjectBox::ALIGN_CENTER); 
					$svg_element__row_text = SVGFAlign::align($svg_element__row_text,$svg_element__row_item,SVGFObjectBox::ALIGN_RIGHT,-$spacing_px*5);  
					break;
				case 'right':
				default:
					$svg_element__row_item = SVGFAlign::align($svg_element__row_item,$alignment_reference_element,SVGFObjectBox::POSITION_RIGHT,$row_anchor_witdh + 1 + $row_connector_width); // align horizontally
					$svg_element__row_text = SVGFAlign::align($svg_element__row_text,$svg_element__row_item,SVGFObjectBox::ALIGN_CENTER); 
					$svg_element__row_text = SVGFAlign::align($svg_element__row_text,$svg_element__row_item,SVGFObjectBox::ALIGN_LEFT,$spacing_px*5); 
					break;
			}
			$row_reference_alignment = $svg_element__row_item;

			// append row
			$svg_svg->appendChild($svg_element__row_item);
			$svg_svg->appendChild($svg_element__row_text);

			// create row connector 
			$svg_element__row_connector = SVGFConnector::sides($dom_doc_svg,$svg_element__row_anchor,$svg_element__row_item,"connector $data_id $row_key",$color_background,0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
			$svg_element__row_connector_shadow = SVGFConnector::sides($dom_doc_svg,$svg_element__row_anchor,$svg_element__row_item,"connector_shadow $data_id $row_key","ffffff",0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
			$svg_element__row_connector_shadow->style->setProperty('opacity','0.3','');

			// append row connector
			$svg_svg->appendChild($svg_element__row_connector);
			$svg_svg->appendChild($svg_element__row_connector_shadow);

			$i++;
		}

	$orientation = 'right'; // only relevant when orientation is both

	}
}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;
 
function getVerticalAnchorAlignment($number_of_rows, $row_anchor_height, $spacing_anchor_px) 
{
	$offset_anchor_vertical = getStartingCoordinateOffsetToCenter($number_of_rows,$row_anchor_height,$spacing_anchor_px) + $spacing_anchor_px;

	return $offset_anchor_vertical;
}

function getVerticalAlignment($alignment, $orientation, $alignment_offset, $number_of_rows, $row_height, $spacing_px, $row_anchor_height, $spacing_anchor_px) 
{
	// set vertical anchor alignment
	$offset_anchor_vertical = getVerticalAnchorAlignment($number_of_rows, $row_anchor_height, $spacing_anchor_px);

	$offset_vertical = 0;
	switch ($alignment)
	{
		case 'top':
			$offset_vertical = $offset_anchor_vertical + $row_anchor_height + $spacing_anchor_px;
			break;
		case 'center':
			$offset_vertical = getStartingCoordinateOffsetToCenter($number_of_rows,$row_height,$spacing_px) + $spacing_px;
			break;
		case 'bottom':
		default:
			$offset_vertical = getStartingCoordinateOffsetToCenter($number_of_rows,$row_height,$spacing_px) * 2 + $spacing_px - $offset_anchor_vertical + $row_anchor_height + $spacing_anchor_px;
			break;
	}
	$offset_vertical = $offset_vertical + $alignment_offset;

	return $offset_vertical;
}

function getStartingCoordinateOffsetToCenter($number_of_elements, $size_element, $size_gap) 
{
	$size_elements = $number_of_elements * $size_element;
	$size_gaps = ($number_of_elements - 1) * $size_gap;
	$size_total = $size_elements + $size_gaps;
	$offset = ($size_total / 2);

	return $offset;
}