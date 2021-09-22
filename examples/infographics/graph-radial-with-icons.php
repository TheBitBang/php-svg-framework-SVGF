<?php

/**
 * graph-radial-with-icons.php
 *
 * This file contains the following infographic template: graph radial.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');

use b1t\svg\SVGCircleElement;
use b1t\svg\SVGGElement;
use b1t\svg\SVGImageElement;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGSVGElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svgf\SVGFAlign;
use b1t\svgf\SVGFConnector;
use b1t\svgf\SVGFElement;
use b1t\svgf\SVGFImportFromSVG;
use b1t\svgf\SVGFText;
use b1t\svgf\lib\SVGFMarker;
use b1t\svgf\geometry\SVGFObjectBox;

// read the json data
$str_data = file_get_contents("./graph-radial-with-icons.json");
$data = json_decode($str_data, true);

// read settings from configuration
$font_family = $data['settings']['font_family'];
$x_center_canvas_offset_relative_to_canvas_width = $data['settings']['x_center_canvas_offset_relative_to_canvas_width'];
$y_center_canvas_offset_relative_to_canvas_width = $data['settings']['y_center_canvas_offset_relative_to_canvas_width'];
$level_2_radius_relative_to_canvas_width = $data['settings']['level_2_radius_relative_to_canvas_width'];
$level_3_horizontal_offset_reference = $data['settings']['level_3_horizontal_offset_reference'];
$level_3_horizontal_offset_relative_to_canvas_width = $data['settings']['level_3_horizontal_offset_relative_to_canvas_width'];
$level_3_spacing_relative_to_canvas_width = $data['settings']['level_3_spacing_relative_to_canvas_width'];
$level_1_element_width_relative_to_canvas_width = $data['settings']['level_1_element_width_relative_to_canvas_width'];
$level_1_element_height_relative_to_element_width = $data['settings']['level_1_element_height_relative_to_element_width'];
$level_2_element_width_relative_to_canvas_width = $data['settings']['level_2_element_width_relative_to_canvas_width'];
$level_2_element_height_relative_to_element_width = $data['settings']['level_2_element_height_relative_to_element_width'];
$level_3_element_width_relative_to_canvas_width = $data['settings']['level_3_element_width_relative_to_canvas_width'];
$level_3_element_height_relative_to_element_width = $data['settings']['level_3_element_height_relative_to_element_width'];
$title_box_color = '#' . $data['settings']['title_box_color'];
$title_text_color = '#' . $data['settings']['title_text_color'];
$level_1_background_color = '#' . $data['settings']['level_1_background_color'];
$level_2_background_color = '#' . $data['settings']['level_2_background_color'];
$level_3_background_color = '#' . $data['settings']['level_3_background_color'];
$level_1_border_color = '#' . $data['settings']['level_1_border_color'];
$level_2_border_color = '#' . $data['settings']['level_2_border_color'];
$level_3_border_color = '#' . $data['settings']['level_3_border_color'];
$level_1_text_color = '#' . $data['settings']['level_1_text_color'];
$level_2_text_color = '#' . $data['settings']['level_2_text_color'];
$level_3_text_color = '#' . $data['settings']['level_3_text_color'];
$title_font_size = $data['settings']['title_font_size'];
$level_1_font_size = $data['settings']['level_1_font_size'];
$level_2_font_size = $data['settings']['level_2_font_size'];
$level_3_font_size = $data['settings']['level_3_font_size'];
$level_2_stroke_dasharray = $data['settings']['level_2_stroke_dasharray'];
$level_3_stroke_dasharray = $data['settings']['level_3_stroke_dasharray'];
$level_3_alignment = $data['settings']['level_3_alignment'];
$level_3_alignment_offset = $data['settings']['level_3_alignment_offset'];
$title = $data['title'];
$level_1_image = $data['image'];
$CONST_MARGIN_TEXT = 10;

// variable definition
$canvas_size = SVGFElement::SIZE_FHD;
$canvas_width = SVGFElement::SIZE_FHD[2]; // 1920 px
$canvas_height = SVGFElement::SIZE_FHD[1]; // 1080 px
$canvas_pixel_unit = $canvas_width / 1000; // used to have a reference of mesurement dependent of canvas width, to keep proportions independent to canvas size

// document creation
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8'); // create the document
$svg_svg = SVGFElement::svg($dom_doc_svg,'infographic-graph-radial',$canvas_size); // create svg elment
//$svg_svg->style->setProperty('background',"#000000",''); // uncomment to visualize canvas

// create defs
$svg_defs = SVGFElement::defs($dom_doc_svg,'marker');

// create markers
$svg_marker_arrow_end = SVGFMarker::markerArrowEnd($dom_doc_svg,'marker_arrow_end','path_arrow_end',$level_1_border_color,7);
$svg_defs->appendChild($svg_marker_arrow_end);
$svg_svg->appendChild($svg_defs);

// title calculations
$title_height = $canvas_pixel_unit * 30;

// level 1 calculations
$level_1_element_width = $canvas_pixel_unit * $level_1_element_width_relative_to_canvas_width;
$level_1_element_height = $level_1_element_width * $level_1_element_height_relative_to_element_width;

// level 2 calculations
$level_2_element_width = $canvas_pixel_unit * $level_2_element_width_relative_to_canvas_width;
$level_2_element_height = $level_2_element_width * $level_2_element_height_relative_to_element_width;
$level_2_num_elements = sizeof(reset($data['content']));
$angle_offset = 360 / $level_2_num_elements;
$angle_accumulated = 90;
$level_2_radius = $level_2_radius_relative_to_canvas_width * $canvas_pixel_unit;

// level 3 calculations
$level_3_element_width = $canvas_pixel_unit * $level_3_element_width_relative_to_canvas_width;
$level_3_element_height = $level_3_element_width * $level_3_element_height_relative_to_element_width;
$level_3_offset_horizontal = $canvas_pixel_unit * $level_3_horizontal_offset_relative_to_canvas_width;
$level_3_spacing_px = $canvas_pixel_unit * $level_3_spacing_relative_to_canvas_width;

// add title
$is_title_defined = ($title != "");
if ($is_title_defined) {
	$svg_element_title_box = SVGFElement::rect($dom_doc_svg,$canvas_width,$title_height,"element_title_box",0,0,null,null,$title_box_color);
	$svg_svg->appendChild($svg_element_title_box);
	$svg_element_title_text = SVGFElement::text($dom_doc_svg,$title,"text_title",0,0,$font_family,$title_font_size,'bold',$title_text_color);
	$svg_element_title_text = SVGFAlign::align($svg_element_title_text,$svg_element_title_box,SVGFObjectBox::ALIGN_CENTER);
	$svg_svg->appendChild($svg_element_title_text);
}

// create elements
$x_center_canvas_offset = $x_center_canvas_offset_relative_to_canvas_width * $canvas_pixel_unit;
$y_center_canvas_offset = $y_center_canvas_offset_relative_to_canvas_width * $canvas_pixel_unit;
$x_center_canvas = ($canvas_width / 2) - $x_center_canvas_offset;
$y_center_canvas = ($canvas_height / 2) - $y_center_canvas_offset;
$svg_element_level_1 = SVGFElement::circle($dom_doc_svg,$level_1_element_width * 2,'root',$x_center_canvas,$y_center_canvas,$level_1_background_color,$level_1_border_color,6);
$svg_svg->appendChild($svg_element_level_1);

// create image
$is_level_1_image_definied = ($level_1_image != "");
if ($is_level_1_image_definied) {
	$svg_element_level_1_image = new SVGImageElement($dom_doc_svg);
	$svg_element_level_1_image->id = 'element_level_1_image';
	$svg_element_level_1_image->href = $level_1_image;
	$svg_element_level_1_image->width = $level_1_element_width * 1.6;
	$svg_element_level_1_image->height = $svg_element_level_1_image->width;
	$image_vertical_offset = $svg_element_level_1_image->height / 2;	
	$svg_element_level_1_image = SVGFAlign::align($svg_element_level_1_image,$svg_element_level_1,SVGFObjectBox::ALIGN_CENTER);
	$svg_element_level_1_image = SVGFAlign::align($svg_element_level_1_image,$svg_element_level_1,SVGFObjectBox::POSITION_MIDDLE,0,-$image_vertical_offset);
}

// create text
$svg_element_level_1_text = SVGFElement::text($dom_doc_svg,key($data['content']),"text_root",0,0,$font_family,$level_1_font_size,'bold',$level_1_text_color);
$svg_element_level_1_text->style->setProperty('text-anchor','middle','');
$svg_element_level_1_text = SVGFAlign::align($svg_element_level_1_text,$svg_element_level_1,SVGFObjectBox::ALIGN_CENTER);
if ($is_level_1_image_definied) { // align below text
	$svg_element_level_1_text = SVGFAlign::align($svg_element_level_1_text,$svg_element_level_1_image,SVGFObjectBox::POSITION_BOTTOM,0,$canvas_pixel_unit*10);
} else { // align center level 1 element
	$svg_element_level_1_text = SVGFAlign::align($svg_element_level_1_text,$svg_element_level_1,SVGFObjectBox::POSITION_MIDDLE);
}
$svg_element_level_1_text = SVGFText::fitWithinWidth($dom_doc_svg,$svg_element_level_1_text,($level_1_element_width * 4)-$CONST_MARGIN_TEXT);

// append text and image
$svg_svg->appendChild($svg_element_level_1_text);
if ($is_level_1_image_definied) { $svg_svg->appendChild($svg_element_level_1_image); }


foreach (reset($data['content']) as $level_2_key => $level_2_value) { // first level

	// find out the position of the element
	$x = $level_2_radius * cos(deg2rad($angle_accumulated));
	$y = $level_2_radius * sin(deg2rad($angle_accumulated));
	$angle_accumulated = $angle_accumulated + $angle_offset;

	// do not create element if it is just a place holder to modify the layout
	$is_hidden_placehoder = ($level_2_value['settings']['is_hidden_placeholder'] == "true");
	if ($is_hidden_placehoder) {continue;}

	$level_2_image = $level_2_value['image'];

	// create the element and align with the center circle
	$svg_element_level_2 = SVGFElement::rect($dom_doc_svg,$level_2_element_width,$level_2_element_height,"element_$level_2_key",0,0,null,null,$level_2_background_color,$level_2_border_color,3);
	$svg_element_level_2 = SVGFAlign::align($svg_element_level_2,$svg_element_level_1,SVGFObjectBox::ALIGN_CENTER,$x,$y);

	// create image
	$is_level_2_image_definied = ($level_2_image != "");
	if ($is_level_2_image_definied) {
		$svg_element_level_2_image = new SVGImageElement($dom_doc_svg);
		$svg_element_level_2_image->id = "image_$level_2_key";
		$svg_element_level_2_image->href = $level_2_image;
		$svg_element_level_2_image->width = $level_2_element_width / 3;
		$svg_element_level_2_image->height = $svg_element_level_2_image->width;
		$image_vertical_offset = $svg_element_level_2_image->height * 0.3;
		$svg_element_level_2_image = SVGFAlign::align($svg_element_level_2_image,$svg_element_level_2,SVGFObjectBox::ALIGN_CENTER);
		$svg_element_level_2_image = SVGFAlign::align($svg_element_level_2_image,$svg_element_level_2,SVGFObjectBox::POSITION_MIDDLE,0,-$image_vertical_offset);
	}

	// create text
	$svg_element_level_2_text = SVGFElement::text($dom_doc_svg,$level_2_key,"text_$level_2_key",0,0,$font_family,$level_2_font_size,'bold',$level_2_text_color);
	$svg_element_level_2_text->style->setProperty('text-anchor','middle','');
	$svg_element_level_2_text = SVGFAlign::align($svg_element_level_2_text,$svg_element_level_2,SVGFObjectBox::POSITION_CENTER);
	if ($is_level_2_image_definied) { // align below text
		$svg_element_level_2_text = SVGFAlign::align($svg_element_level_2_text,$svg_element_level_2_image,SVGFObjectBox::POSITION_BOTTOM,0,$canvas_pixel_unit*5);
	} else { // align center level 2 element
		$svg_element_level_2_text = SVGFAlign::align($svg_element_level_2_text,$svg_element_level_2,SVGFObjectBox::POSITION_MIDDLE);
	}	
	
	$svg_element_level_2_text = SVGFText::fitWithinWidth($dom_doc_svg,$svg_element_level_2_text,$level_2_element_width-$CONST_MARGIN_TEXT);

	// create connector
	$svg_element_level_2_connector = SVGFConnector::borders($dom_doc_svg,$svg_element_level_1,$svg_element_level_2,'#861a22','3px',"connector_$level_2_key",null,'marker_arrow_end');
	// apply additional style to connector
	$svg_element_level_2_connector->style->setProperty('stroke-dasharray',$level_2_stroke_dasharray,'');
	// add elements
	$svg_svg->appendChild($svg_element_level_2);
	$svg_svg->appendChild($svg_element_level_2_text);
	if ($is_level_2_image_definied) { $svg_svg->appendChild($svg_element_level_2_image); }
	$svg_svg->appendChild($svg_element_level_2_connector);

	$level_3_elements = $level_2_value['content'];
	$level_3_num_elements = sizeof($level_3_elements);

	// find out orientation (rigth or left) of level 3 elements respect their parent in level 2
	$orientation = null;
	if ($angle_accumulated > 90 and $angle_accumulated <= 270) {
		$orientation = 'left';
	}
	else{
		$orientation = 'right';
	}

	// set vertical alignment
	$offset_vertical = getVerticalAlignment($level_3_num_elements, $level_3_element_height, $level_3_spacing_px);
	$offset_of_one_element = $level_3_element_height + $level_3_spacing_px; 
	$offset_vertical = $offset_vertical + $offset_of_one_element; // move reference one offset up to treat all the elements in the loop the same

	// create reference alignment element for row
	$row_reference_alignment = SVGFElement::rect($dom_doc_svg,$level_3_element_width,$offset_of_one_element,"aux_alignment_row"); // element to be used as reference to position the first row
	// vetica offset
	$row_reference_alignment = SVGFAlign::align($row_reference_alignment,$svg_element_level_2,SVGFObjectBox::POSITION_MIDDLE,0,-$offset_vertical); // vertical offset. Shift to fit first alignment
	// element to offset from
	$reference_element_for_offset = $svg_element_level_2;
	if ($level_3_horizontal_offset_reference == 'level_1') {$reference_element_for_offset = $svg_element_level_1;}
	// horizontal offset
	$offset_horizontal = $level_3_offset_horizontal;
	$level_3_element_alignment = SVGFObjectBox::POSITION_RIGHT;
	if ($orientation == 'left') {$offset_horizontal = -$level_3_offset_horizontal; $level_3_element_alignment = SVGFObjectBox::POSITION_LEFT; }
	$row_reference_alignment = SVGFAlign::align($row_reference_alignment,$reference_element_for_offset,$level_3_element_alignment,$offset_horizontal,0); // horizontal offset

	// to avoid element in output file
	$svg_svg->appendChild($row_reference_alignment);
	$svg_svg->removeChild($row_reference_alignment);

	if ($level_3_num_elements > 1) {
		foreach ($level_3_elements as $level_3_key => $level_3_value) {

			$level_3_background_color_override = $level_3_background_color;

			// read configuration for overrides
			if (array_key_exists('settings',$level_3_value)) {
				if (array_key_exists('level_3_background_color',$level_3_value['settings'])) { $level_3_background_color_override = '#' . $level_3_value['settings']['level_3_background_color']; }
			}

			// create the element
			$svg_element_level_3 = SVGFElement::rect($dom_doc_svg,$level_3_element_width,$level_3_element_height,"element_$level_3_key",0,0,null,null,$level_3_background_color_override,$level_3_border_color,3);

			// align row
			$svg_element_level_3 = SVGFAlign::align($svg_element_level_3,$row_reference_alignment,SVGFObjectBox::ALIGN_CENTER,0,$offset_of_one_element); // align vertically

			$row_reference_alignment = $svg_element_level_3;

			// create text
			$svg_element_level_3_text = SVGFElement::text($dom_doc_svg,$level_3_key,"text_$level_3_key",0,0,$font_family,$level_3_font_size,'bold',$level_3_text_color);
			$svg_element_level_3_text->style->setProperty('text-anchor','middle','');
			$svg_element_level_3_text = SVGFAlign::align($svg_element_level_3_text,$svg_element_level_3,SVGFObjectBox::POSITION_CENTER);
			$svg_element_level_3_text = SVGFAlign::align($svg_element_level_3_text,$svg_element_level_3,SVGFObjectBox::POSITION_MIDDLE);
			$svg_element_level_3_text = SVGFText::fitWithinWidth($dom_doc_svg,$svg_element_level_3_text,$level_3_element_width-$CONST_MARGIN_TEXT);

			// create the aux element to place connector on the side
			$element_aux_level_3_side_connector = SVGFElement::rect($dom_doc_svg,1,1,"element_aux_$level_3_key",0,0);
			$element_aux_level_3_side_connector = SVGFAlign::align($element_aux_level_3_side_connector,$svg_element_level_3,SVGFObjectBox::ALIGN_CENTER,0,0);
			$connector_alignment = SVGFObjectBox::ALIGN_LEFT;
			if ($orientation == 'left') {$connector_alignment = SVGFObjectBox::ALIGN_RIGHT;}
			$element_aux_level_3_side_connector = SVGFAlign::align($element_aux_level_3_side_connector,$svg_element_level_3,$connector_alignment,0,0);

			// to avoid element in output file
			$svg_svg->appendChild($element_aux_level_3_side_connector);
			$svg_svg->removeChild($element_aux_level_3_side_connector);

			// create connector
			$svg_element_level_3_connector = SVGFConnector::borders($dom_doc_svg,$svg_element_level_2,$element_aux_level_3_side_connector,'#861a22','2px',"connector_$level_2_key",null,'marker_arrow_end');
			// apply additional style to connector
			$svg_element_level_3_connector->style->setProperty('stroke-dasharray',$level_3_stroke_dasharray,'');
			// add elements
			$svg_svg->appendChild($svg_element_level_3);
			$svg_svg->appendChild($svg_element_level_3_text);
			$svg_svg->appendChild($svg_element_level_3_connector);

		}
	}

}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;

function getVerticalAlignment($number_of_rows, $row_height, $spacing_anchor_px) 
{
	$offset_to_place_top_of_child_element_in_center_of_partent_element = ($row_height / 2);
	$offset_anchor_vertical = getStartingCoordinateOffsetToCenter($number_of_rows,$row_height,$spacing_anchor_px) - $offset_to_place_top_of_child_element_in_center_of_partent_element;

	return $offset_anchor_vertical;
}

function getStartingCoordinateOffsetToCenter($number_of_elements, $size_element, $size_gap) 
{
	$size_elements = $number_of_elements * $size_element;
	$size_gaps = ($number_of_elements - 1) * $size_gap;
	$size_total = $size_elements + $size_gaps;
	$offset = ($size_total / 2);

	return $offset;
}