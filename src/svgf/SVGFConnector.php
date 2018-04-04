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

	public static function borders($dom_doc, $element_start, $element_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null, $offset = 0)
	{

		// get bboxes
		$bbox_element_start = self::getBBox($element_start);
		$bbox_element_end = self::getBBox($element_end);

		// get center points
		$x_start_center = $bbox_element_start->x_center;
		$y_start_center = $bbox_element_start->y_center;
		$x_end_center = $bbox_element_end->x_center;
		$y_end_center = $bbox_element_end->y_center;

		// get max and min points
		$x_start_min = $bbox_element_start->x_min - $offset;
		$y_start_min = $bbox_element_start->y_min - $offset;
		$x_start_max = $bbox_element_start->x_max + $offset;
		$y_start_max = $bbox_element_start->y_max + $offset;
		$x_end_min = $bbox_element_end->x_min - $offset;
		$y_end_min = $bbox_element_end->y_min - $offset;
		$x_end_max = $bbox_element_end->x_max + $offset;
		$y_end_max = $bbox_element_end->y_max + $offset;

		// get deltas
		$delta_y_connector = $y_end_center - $y_start_center;
		$delta_x_connector = $x_end_center - $x_start_center;

		while (true) {

			if ($delta_x_connector == 0) {// vertically aligned
				$x_start = $x_start_center;
				$y_start = ($y_end_center > $y_start_center) ? $y_start_max : $y_start_min;
				$x_end = $x_end_center;
				$y_end = ($y_end_center < $y_start_center) ? $y_end_max : $y_end_min;
				break;
			}

			$m_connector = $delta_y_connector / $delta_x_connector; // slope

			if ($m_connector == 0) {// horizontally aligned
				$x_start = ($x_end_center > $x_start_center) ? $x_start_max : $x_start_min ;
				$y_start = $y_start_center;
				$x_end = ($x_end_center < $x_start_center) ? $x_end_max : $x_end_min ;
				$y_end = $y_end_center;
				break;
			 }

			 // calculate start point 
			 switch($element_start->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_start); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_start = ($x_end_center > $x_start_center) ? $x_start_max : $x_start_min ;
						$y_start = $y_end_center - ($m_connector * ($x_end_center - $x_start));
					} else { // connector arriving to top or bottom sides
						$y_start = ($y_end_center > $y_start_center) ? $y_start_max : $y_start_min ;
						$x_start = $x_end_center - (($y_end_center - $y_start) / $m_connector);
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_start = $x_start_center + ($element_start->r + $offset) * cos($phi);
					$y_start = $y_start_center + ($element_start->r + $offset) * sin($phi);
					break;
			}

			 // calculate end point 
			switch($element_end->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_end); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_end = ($x_end_center < $x_start_center) ? $x_end_max : $x_end_min;
						$y_end = ($m_connector * ($x_end - $x_start_center)) + $y_start_center;
					} else { // connector arriving to top or bottom sides
						$y_end = ($y_end_center < $y_start_center) ? $y_end_max : $y_end_min;
						$x_end = (($y_end - $y_start_center) / $m_connector) + $x_start_center;
					}
					break;
				case 'circle':
					$phi = atan2($delta_y_connector,$delta_x_connector);
					$x_end = $x_end_center - ($element_end->r + $offset) * cos($phi);
					$y_end = $y_end_center - ($element_end->r + $offset) * sin($phi);
					break;
			}
			break;
		}

		$point_start = SVGFElement::point($x_start,$y_start); // origin coordinates
		$point_end = SVGFElement::point($x_end,$y_end); // destination coordinates

		$svg_path = self::points($dom_doc,$point_start,$point_end,$style_stroke,$style_stroke_width,$id,$marker_start_url,$marker_end_url);

		return $svg_path;
	}

	public static function sides($dom_doc, $element_start, $element_end, $id = null, $style_fill = null, $offset = 0)
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
		$x_start_min = $bbox_element_start->x_min;
		$y_start_min = $bbox_element_start->y_min;
		$x_start_max = $bbox_element_start->x_max;
		$y_start_max = $bbox_element_start->y_max;
		$x_end_min = $bbox_element_end->x_min;
		$y_end_min = $bbox_element_end->y_min;
		$x_end_max = $bbox_element_end->x_max;
		$y_end_max = $bbox_element_end->y_max;

		while (true) {

			if ($delta_x_connector == 0) {// vertically aligned
				$y_start_min = ($y_end_center > $y_start_center) ? $y_start_max + $offset : $y_start_min - $offset;
				$y_start_max = $y_start_min;
				$y_end_min = ($y_end_center < $y_start_center) ? $y_end_max + $offset : $y_end_min - $offset;
				$y_end_max = $y_end_min;
				break;
			}

			$m_connector = $delta_y_connector / $delta_x_connector; // slope

			if ($m_connector == 0) {// horizontally aligned
				$x_start_min = ($x_end_center > $x_start_center) ? $x_start_max + $offset : $x_start_min - $offset;
				$x_start_max = $x_start_min;
				$x_end_min = ($x_end_center < $x_start_center) ? $x_end_max + $offset : $x_end_min - $offset;
				$x_end_max = $x_end_min;
				break;
			 }

			 // calculate start point 
			 switch($element_start->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_start); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_start_min = ($x_end_center > $x_start_center) ? $x_start_max + $offset : $x_start_min - $offset;
						$x_start_max = $x_start_min;
					} else { // connector arriving to top or bottom sides
						$y_start_min = ($y_end_center > $y_start_center) ? $y_start_max + $offset : $y_start_min - $offset;
						$y_start_max = $y_start_min;
					}
					break;
				case 'circle':
					// to-do: tangent to circle
					break;
			}

			 // calculate end point 
			switch($element_end->tagName){
				case 'rect':
				case 'text':
				case 'tspan':
					$element_m = self::getBBoxSlope($bbox_element_end); //slope
					if (abs($m_connector) < abs($element_m)){ // connector arriving to left or right sides
						$x_end_min = ($x_end_center < $x_start_center) ? $x_end_max + $offset : $x_end_min - $offset;
						$x_end_max = $x_end_min;
					} else { // connector arriving to top or bottom sides
						$y_end_min = ($y_end_center < $y_start_center) ? $y_end_max + $offset : $y_end_min - $offset;
						$y_end_max = $y_end_min;
					}
					break;
				case 'circle':
					// to-do: tangent to circle
					break;
			}
			break;
		}

		// create path
		$svg_path = new SVGPathElement($dom_doc);
		$m = "M $x_start_min,$y_start_min $x_start_max,$y_start_max $x_end_max,$y_end_max $x_end_min,$y_end_min Z";
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