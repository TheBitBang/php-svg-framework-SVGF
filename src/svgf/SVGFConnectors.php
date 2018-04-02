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
use b1t\svgf\SVGFNew;
use b1t\svgf\geometry\SVGFObjectBoxRectElement;
use b1t\svgf\geometry\SVGFObjectBoxCircleElement;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;
use b1t\svgf\geometry\SVGFObjectBoxTSpanElement;

/**
 * This is a helper class to create connectors.
 *
 * @author J. Xavier Atero
 */
 
class SVGFConnectors {

	public static function connectPoints($dom_doc, $svg_point_start, $svg_point_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
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

		public static function connectElements($dom_doc, $element_start, $element_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
	{

		$bbox_element_start;
		$bbox_element_end;

		// create bounding box of start element
		switch($element_start->tagName){
			case 'rect':
				$bbox_element_start = new SVGFObjectBoxRectElement($element_start);
				break;
			case 'circle':
				$bbox_element_start = new SVGFObjectBoxCircleElement($element_start);
				break;
			case 'text':
				$bbox_element_start = new SVGFObjectBoxTextElement($element_start);
				break;
			case 'tspan':
				$bbox_element_start = new SVGFObjectBoxTSpanElement($element_start);
				break;
		}

		// create bounding box of end element
		switch($element_end->tagName){
			case 'rect':
				$bbox_element_end = new SVGFObjectBoxRectElement($element_end);
				break;
			case 'circle':
				$bbox_element_end = new SVGFObjectBoxCircleElement($element_end);
				break;
			case 'text':
				$bbox_element_end = new SVGFObjectBoxTextElement($element_end);
				break;
			case 'tspan':
				$bbox_element_end = new SVGFObjectBoxTSpanElement($element_end);
				break;
		}

		$x_start = $bbox_element_start->x_center;
		$y_start = $bbox_element_start->y_center;
		$x_end = $bbox_element_end->x_center;
		$y_end = $bbox_element_end->y_center;

		$point_start = SVGFNew::point($x_start,$y_start); // origin coordinates
		$point_end = SVGFNew::point($x_end,$y_end); // destination coordinates

		$svg_path = self::connectPoints($dom_doc,$point_start,$point_end,$style_stroke,$style_stroke_width,$id,$marker_start_url,$marker_end_url);

		return $svg_path;
	}
}