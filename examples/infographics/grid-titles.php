<?php

/**
 * BasicShapesExample.php
 *
 * This file contains the following infographic template: vertical list.
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../..' . '/vendor/autoload.php');

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGImageElement;
use b1t\svgf\SVGFElement;
use b1t\svgf\SVGFConnector;
use b1t\svgf\SVGFAlign;
use b1t\svgf\SVGFText;
use b1t\svgf\geometry\SVGFObjectBox;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;

// read json data
$str_data = file_get_contents("./grid-titles.json"); // read the json data file
$data = json_decode($str_data, true); // decode the data

// canvas definition + document creation
$canvas_resizing_ratio = 0.96;
$canvas_width = 1920 * $canvas_resizing_ratio;
$canvas_height = 1080 * $canvas_resizing_ratio;
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth($canvas_width.'px');
$svg_svg->setHeight($canvas_height.'px');
$svg_svg->setViewBox('0 0' . $canvas_width . ' ' . $canvas_height);
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');

//$svg_svg->style->setProperty('background',"#000000",''); // uncomment to visualize canvas

// read settings from configuration
$fhd_magin_top = $data['settings']['fhd-magin-top'];
$fhd_magin_bottom = $data['settings']['fhd-magin-bottom'];
$fhd_magin_left = $data['settings']['fhd-magin-left'];
$fhd_magin_right = $data['settings']['fhd-magin-right'];
$array_rows = $data['content']['list'];
$number_of_rows = count($data['content']['list']);

// variable definition
$adjustment_height = $canvas_height / SVGFElement::SIZE_FHD[1];
$adjustment_width = $canvas_width / SVGFElement::SIZE_FHD[2];
$magin_top_adjusted = $fhd_magin_top * $adjustment_height;
$magin_bottom_adjusted  = $fhd_magin_bottom * $adjustment_height;
$magin_left_adjusted = $fhd_magin_left * $adjustment_width;
$magin_right_adjusted = $fhd_magin_right * $adjustment_width;
$canvas_height_with_margins = $canvas_height - $magin_top_adjusted - $magin_bottom_adjusted;
$canvas_width_with_margins = $canvas_width - $magin_left_adjusted - $magin_right_adjusted;
$row_height = ($canvas_height_with_margins / $number_of_rows);
$row_width = $canvas_width_with_margins;

$current_row = 0;

foreach ($array_rows as $row)
{
	$number_of_cols = count($row);
	$cell_width = $row_width/$number_of_cols;
	$current_cell = 0;
	foreach ($row as $cell)
	{
		// read settings from configuration
		$title = $cell['title'];
		$title_height = $cell['fhd-title-height'];
		$pecentage_title_width = $cell['pecentage-title-width'] / 100;
		$pecentage_gap = $cell['pecentage-gap'] / 100;
		$fhd_padding = $cell['fhd-padding'];
		$color_ribbon = '#' . $cell['color-ribbon'];
		$color_text = '#' . $cell['color-text'];
		$font_family = $cell['font-family'];
		$font_size = $cell['font-size'];
		$image_href = $cell['image-href'];
		$percentage_to_shift_ribbon_center = $cell['percentage-to-shift-ribbon-center'] / 100;

		// variable definition
		$title_height_adjusted = $title_height * $adjustment_height;
		$padding_adjusted = $fhd_padding * $adjustment_width;
		$width_title = $cell_width * $pecentage_title_width;
		$gap = $width_title * $pecentage_gap;
		$width_title_sides = (($cell_width - $width_title) / 2) - $gap - $padding_adjusted;
		$shift_ribbon_center = $title_height_adjusted * $percentage_to_shift_ribbon_center;

		// get position of the cell
		$y = $magin_top_adjusted + ($row_height * $current_row);
		$x = $magin_right_adjusted + $padding_adjusted + ($cell_width * $current_cell);

		// draw content
		$svg_element__cell_title_left = SVGFElement::rect($dom_doc_svg,$width_title_sides,$title_height_adjusted,"cell_" . $current_row . "_". $current_cell . "_left",$x,$y,0,0,$color_ribbon);
		$svg_element__cell_title = SVGFElement::rect($dom_doc_svg,$width_title,$title_height_adjusted,"cell_" . $current_row . "_". $current_cell . "_title",$x,$y,0,0,$color_ribbon);
		$svg_element__cell_title_right = SVGFElement::rect($dom_doc_svg,$width_title_sides,$title_height_adjusted,"cell_" . $current_row . "_". $current_cell . "_right",$x,$y,0,0,$color_ribbon);
		// align
		$svg_element__cell_title = SVGFAlign::align($svg_element__cell_title,$svg_element__cell_title_left,SVGFObjectBox::POSITION_RIGHT,$gap,$shift_ribbon_center);
		$svg_element__cell_title_right = SVGFAlign::align($svg_element__cell_title_right,$svg_element__cell_title,SVGFObjectBox::POSITION_RIGHT,$gap);

		// draw text
		$svg_element__text = SVGFElement::text($dom_doc_svg,$title,"text_title_" . $current_row . "_". $current_cell,0,0,$font_family,$font_size,'normal',$color_text);
		// align text
		$svg_element__text = SVGFAlign::align($svg_element__text,$svg_element__cell_title,SVGFObjectBox::ALIGN_CENTER);

		// create connector left
		$svg_element__connector_left = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_left,$svg_element__cell_title,"connector_left_" . $current_row . "_". $current_cell . "_left",$color_ribbon,0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
		$svg_element__connector_left_shadow = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_left,$svg_element__cell_title,"connector_left_shadow_" . $current_row . "_". $current_cell . "_left","ffffff",0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
		$svg_element__connector_left_shadow->style->setProperty('opacity','0.2','');
		// create connector right
		$svg_element__connector_right = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_right,$svg_element__cell_title,"connector_right_" . $current_row . "_". $current_cell . "_left",$color_ribbon,0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
		$svg_element__connector_right_shadow = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_right,$svg_element__cell_title,"connector_right_shadow_" . $current_row . "_". $current_cell . "_left","ffffff",0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
		$svg_element__connector_right_shadow->style->setProperty('opacity','0.4','');
		// create connector middle
//		$svg_element__connector_middle = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_left,$svg_element__cell_title_right,"connector_" . $current_row . "_". $current_cell . "_left",$color_ribbon,0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
//		$svg_element__connector_middle_shadow = SVGFConnector::sides($dom_doc_svg,$svg_element__cell_title_left,$svg_element__cell_title_right,"connector_shadow_" . $current_row . "_". $current_cell . "_left","ffffff",0,SVGFConnector::FORCE_CONNECTION_HORIZONTAL);
//		$svg_element__connector_middle_shadow->style->setProperty('opacity','0.3','');

		// add image
		$is_image_defined = ($image_href != "");
		if ($is_image_defined)
		{
			$svg_image = new SVGImageElement($dom_doc_svg);
			$svg_image->setHref($image_href);
			$svg_image = SVGFAlign::align($svg_image,$svg_element__cell_title,SVGFObjectBox::ALIGN_CENTER);
//			$svg_image = SVGFAlign::align($svg_image,$svg_element__cell_title,SVGFObjectBox::POSITION_BOTTOM);
			$svg_svg->appendChild($svg_image);
		}

		// append sides of title
		$svg_svg->appendChild($svg_element__cell_title_left);
		$svg_svg->appendChild($svg_element__cell_title_right);

		// append row connectors
//		$svg_svg->appendChild($svg_element__connector_middle);
//		$svg_svg->appendChild($svg_element__connector_middle_shadow);
		$svg_svg->appendChild($svg_element__connector_left);
		$svg_svg->appendChild($svg_element__connector_left_shadow);
		$svg_svg->appendChild($svg_element__connector_right);
		$svg_svg->appendChild($svg_element__connector_right_shadow);

		$current_cell++;

		// append title
		$svg_svg->appendChild($svg_element__cell_title);
		$svg_svg->appendChild($svg_element__text);

	}
	$current_row++;


}

$txt_svg = $dom_doc_svg->saveXML();

echo $txt_svg;