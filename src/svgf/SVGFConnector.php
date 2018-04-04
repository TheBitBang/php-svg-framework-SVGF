<?php

namespace b1t\svgf;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGPathSegMovetoAbs;
use b1t\svg\SVGPathSegLinetoAbs;
use b1t\svgf\SVGFElement;
use b1t\svgf\geometry\SVGFObjectBoxRectElement;
use b1t\svgf\geometry\SVGFObjectBoxCircleElement;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;
use b1t\svgf\geometry\SVGFObjectBoxTSpanElement;

/**
 * This is a helper class to create connectors.
 *
 * @author J. Xavier Atero
 */
 
class SVGFConnector {

	public static function points($dom_doc, $svg_point_start, $svg_point_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
	{
		// origin coordinates
		$svg_path_m_abs = new SVGPathSegMovetoAbs();
		$svg_path_m_abs->setX($svg_point_start->getX());
		$svg_path_m_abs->setY($svg_point_start->getY());

		// destination coordinates
		$svg_path_l_abs = new SVGPathSegLinetoAbs();
		$svg_path_l_abs->setX($svg_point_end->getX());
		$svg_path_l_abs->setY($svg_point_end->getY());

		// create path
		$svg_path = new SVGPathElement($dom_doc);
		$m = $svg_path_m_abs->getPathSegTypeAsLetter() . ' ' .  $svg_path_m_abs->getData();
		$l = $svg_path_l_abs->getPathSegTypeAsLetter() . ' ' .  $svg_path_l_abs->getData();
		$svg_path->setD("$m $l");

		// add properties if the strings are not empty
		if (isset($id)) {$svg_path->id = $id;}
		$svg_path->style->setProperty('stroke',$style_stroke,'');
		$svg_path->style->setProperty('stroke-width',$style_stroke_width,'');
		if (isset($marker_start_url)) {$svg_path->style->setProperty('marker-start','url(#' . $marker_start_url . ')','');}
		if (isset($marker_end_url)) {$svg_path->style->setProperty('marker-end','url(#' . $marker_end_url . ')','');}
		return $svg_path;
	}

	public static function centers($dom_doc, $element_start, $element_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
	{

		// get bboxes
		$bbox_element_start = self::getBBox($element_start);
		$bbox_element_end = self::getBBox($element_end);

		// get center points
		$x_start = $bbox_element_start->x_center;
		$y_start = $bbox_element_start->y_center;
		$x_end = $bbox_element_end->x_center;
		$y_end = $bbox_element_end->y_center;

		// create points
		$point_start = SVGFElement::point($x_start,$y_start); // origin coordinates
		$point_end = SVGFElement::point($x_end,$y_end); // destination coordinates

		$svg_path = self::points($dom_doc,$point_start,$point_end,$style_stroke,$style_stroke_width,$id,$marker_start_url,$marker_end_url);

		return $svg_path;
	}

	public static function borders($dom_doc, $element_start, $element_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
	{

		// get bboxes
		$bbox_element_start = self::getBBox($element_start);
		$bbox_element_end = self::getBBox($element_end);

		// get center points
		$x_start_center = $bbox_element_start->x_center;
		$y_start_center = $bbox_element_start->y_center;
		$x_end_center = $bbox_element_end->x_center;
		$y_end_center = $bbox_element_end->y_center;

		// get deltas
		$delta_y_connector = $y_end_center - $y_start_center;
		$delta_x_connector = $x_end_center - $x_start_center;

		// calculate end point if connector starting and ending in the edges
		while (true) {

			if ($delta_x_connector == 0) {// vertically aligned
				$x_start = $bbox_element_start->x_center;
				$y_start = ($y_end_center > $y_start_center) ? $bbox_element_start->y_max : $bbox_element_start->y_min ;
				$x_end = $bbox_element_end->x_center;
				$y_end = ($y_end_center < $y_start_center) ? $bbox_element_end->y_max : $bbox_element_end->y_min ;
				break;
			}

			$m_connector = $delta_y_connector / $delta_x_connector; // slope

			if ($m_connector == 0) {// horizontally aligned
				$x_start = ($x_end_center > $x_start_center) ? $bbox_element_start->x_max : $bbox_element_start->x_min ;
				$y_start = $bbox_element_start->y_center;
				$x_end = ($x_end_center < $x_start_center) ? $bbox_element_end->x_max : $bbox_element_end->x_min ;
				$y_end = $bbox_element_end->y_center;
				break;
			 }

			 // calculate start point 
			 switch($element_start->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_start); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_start = ($x_end_center > $x_start_center) ? $bbox_element_start->x_max : $bbox_element_start->x_min ;
						$y_start = $y_end_center - ($m_connector * ($x_end_center - $x_start));
					} else { // connector arriving to top or bottom sides
						$y_start = ($y_end_center > $y_start_center) ? $bbox_element_start->y_max : $bbox_element_start->y_min ;
						$x_start = $x_end_center - (($y_end_center - $y_start) / $m_connector);
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_start = $x_start_center + $element_start->r * cos($phi);
					$y_start = $y_start_center + $element_start->r * sin($phi);
					break;
			}

			 // calculate end point 
			switch($element_end->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_end); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_end = ($x_end_center < $x_start_center) ? $bbox_element_end->x_max : $bbox_element_end->x_min ;
						$y_end = ($m_connector * ($x_end - $x_start_center)) + $y_start_center;
					} else { // connector arriving to top or bottom sides
						$y_end = ($y_end_center < $y_start_center) ? $bbox_element_end->y_max : $bbox_element_end->y_min ;
						$x_end = (($y_end - $y_start_center) / $m_connector) + $x_start_center;
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_end = $x_end_center - $element_end->r * cos($phi);
					$y_end = $y_end_center - $element_end->r * sin($phi);
					break;
			}
			break;
		}

		$point_start = SVGFElement::point($x_start,$y_start); // origin coordinates
		$point_end = SVGFElement::point($x_end,$y_end); // destination coordinates

		$svg_path = self::points($dom_doc,$point_start,$point_end,$style_stroke,$style_stroke_width,$id,$marker_start_url,$marker_end_url);

		return $svg_path;
	}

	public static function sides($dom_doc, $element_start, $element_end, $id = null, $style_fill = null)
	{
		// get bboxes
		$bbox_element_start = self::getBBox($element_start);
		$bbox_element_end = self::getBBox($element_end);

		// get center points
		$x_start_center = $bbox_element_start->x_center;
		$y_start_center = $bbox_element_start->y_center;
		$x_end_center = $bbox_element_end->x_center;
		$y_end_center = $bbox_element_end->y_center;

		// get deltas
		$delta_y_connector = $y_end_center - $y_start_center;
		$delta_x_connector = $x_end_center - $x_start_center;

		// defalut values
		$x_start_1 = $bbox_element_start->x_min;
		$x_start_2 = $bbox_element_start->x_max;
		$y_start_1 = $bbox_element_start->y_min;
		$y_start_2 = $bbox_element_start->y_max;
		$x_end_1 = $bbox_element_end->x_min;
		$x_end_2 = $bbox_element_end->x_max;
		$y_end_1 = $bbox_element_end->y_min;
		$y_end_2 = $bbox_element_end->y_max;


		// calculate end point if connector starting and ending in the edges
		while (true) {

			if ($delta_x_connector == 0) {// vertically aligned
				$y_start_1 = ($y_end_center > $y_start_center) ? $bbox_element_start->y_max : $bbox_element_start->y_min ;
				$y_start_2 = $y_start_1;
				$y_end_1 = ($y_end_center < $y_start_center) ? $bbox_element_end->y_max : $bbox_element_end->y_min ;
				$y_end_2 = $y_end_1;
				break;
			}

			$m_connector = $delta_y_connector / $delta_x_connector; // slope

			if ($m_connector == 0) {// horizontally aligned
				$x_start_1 = ($x_end_center > $x_start_center) ? $bbox_element_start->x_max : $bbox_element_start->x_min ;
				$x_start_2 = $x_start_1;
				$x_end_1 = ($x_end_center < $x_start_center) ? $bbox_element_end->x_max : $bbox_element_end->x_min ;
				$x_end_2 = $x_end_1;
				break;
			 }

			 // calculate start point 
			 switch($element_start->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_start); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_start_1 = ($x_end_center > $x_start_center) ? $bbox_element_start->x_max : $bbox_element_start->x_min ;
						$x_start_2 = $x_start_1;
					} else { // connector arriving to top or bottom sides
						$y_start_1 = ($y_end_center > $y_start_center) ? $bbox_element_start->y_max : $bbox_element_start->y_min ;
						$y_start_2 = $y_start_1;
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_start = $x_start_center + $element_start->r * cos($phi);
					$y_start = $y_start_center + $element_start->r * sin($phi);
					break;
			}

			 // calculate end point 
			switch($element_end->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_end); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_end_1 = ($x_end_center < $x_start_center) ? $bbox_element_end->x_max : $bbox_element_end->x_min ;
						$x_end_2 = $x_end_1;
					} else { // connector arriving to top or bottom sides
						$y_end_1 = ($y_end_center < $y_start_center) ? $bbox_element_end->y_max : $bbox_element_end->y_min ;
						$y_end_2 = $y_end_1;
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_end = $x_end_center - $element_end->r * cos($phi);
					$y_end = $y_end_center - $element_end->r * sin($phi);
					break;
			}
			break;
		}

		// create path
		$svg_path = new SVGPathElement($dom_doc);
		$m = "M $x_start_1,$y_start_1 $x_start_2,$y_start_2 $x_end_2,$y_end_2 $x_end_1,$y_end_1 Z";
		$svg_path->setD("$m");

		// add properties if the strings are not empty
		if (isset($id)) {$svg_path->id = $id;}
		if (isset($style_fill)) {$svg_path->style->setProperty('fill', $style_fill,'');}
		return $svg_path;
	}

	private static function getBBox($element)
	{
		$bbox_element = null;

		// create bounding box of start element
		switch($element->tagName){
			case 'rect':
				$bbox_element = new SVGFObjectBoxRectElement($element);
				break;
			case 'circle':
				$bbox_element = new SVGFObjectBoxCircleElement($element);
				break;
			case 'text':
				$bbox_element = new SVGFObjectBoxTextElement($element);
				break;
			case 'tspan':
				$bbox_element = new SVGFObjectBoxTSpanElement($element);
				break;
		}

		return $bbox_element;
	}

	private static function getBBoxSlope($bbox_element)
	{
		$element_m; // slope
		$x1_element = $bbox_element->x_min;
		$x2_element = $bbox_element->x_max;
		$y1_element = $bbox_element->y_min;
		$y2_element = $bbox_element->y_max;
		$delta_y_element = $y2_element - $y1_element;
		$delta_x_element = $x2_element - $x1_element;
		$element_m = $delta_y_element / $delta_x_element; // not considered the case: slope = infinity

		return $element_m;
	}
}