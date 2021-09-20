<?php

namespace b1t\svgf;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svgf\geometry\SVGFObjectBox;
use b1t\svgf\geometry\SVGFObjectBoxRectElement;
use b1t\svgf\geometry\SVGFObjectBoxCircleElement;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;
use b1t\svgf\geometry\SVGFObjectBoxTSpanElement;
use b1t\svgf\geometry\SVGFObjectBoxImageElement;

/**
 * This is a helper class to align elements.
 *
 * @author J. Xavier Atero
 */
 
class SVGFAlign {

	public static function align($svg_element_moving, $svg_element_static, $type, $h_offset = 0, $v_offset = 0)
	{

		$bbox_element_static;
		$bbox_element_moving;

		// create bounding box of static element
		switch($svg_element_static->tagName){
			case 'rect':
				$bbox_element_static = new SVGFObjectBoxRectElement($svg_element_static);
				break;
			case 'circle':
				$bbox_element_static = new SVGFObjectBoxCircleElement($svg_element_static);
				break;
			case 'text':
				$bbox_element_static = new SVGFObjectBoxTextElement($svg_element_static);
				break;
			case 'tspan':
				$bbox_element_static = new SVGFObjectBoxTSpanElement($svg_element_static);
				break;
			case 'image':
				$bbox_element_static = new SVGFObjectBoxImageElement($svg_element_static);
				break;
		}

		// create bounding box of moving element
		switch($svg_element_moving->tagName){
			case 'rect':
				$bbox_element_moving = new SVGFObjectBoxRectElement($svg_element_moving);
				break;
			case 'circle':
				$bbox_element_moving = new SVGFObjectBoxCircleElement($svg_element_moving);
				break;
			case 'text':
				$bbox_element_moving = new SVGFObjectBoxTextElement($svg_element_moving);
				break;
			case 'tspan':
				$bbox_element_moving = new SVGFObjectBoxTSpanElement($svg_element_moving);
				break;
			case 'image':
				$bbox_element_moving = new SVGFObjectBoxImageElement($svg_element_moving);
				break;
		}

		// move the bounding box
		$bbox_element_moving->moveTo($bbox_element_static,$type,$h_offset,$v_offset);

		// change location of the moving element
		switch($svg_element_moving->tagName){
			case 'rect':
				$stroke_width = floatval($svg_element_moving->style->getPropertyValue('stroke-width'));
				$stroke_width_div_2 = $stroke_width / 2;
				$svg_element_moving->x = $bbox_element_moving->x_min + $stroke_width_div_2;
				$svg_element_moving->y = $bbox_element_moving->y_min + $stroke_width_div_2;
				break;
			case 'text':
			case 'tspan':
				$svg_element_moving->x = $bbox_element_moving->x_min;
				$svg_element_moving->y = $bbox_element_moving->y_max;
				break;
			case 'circle':
				$svg_element_moving->cx = $bbox_element_moving->x_center;
				$svg_element_moving->cy = $bbox_element_moving->y_center;
				break;
			case 'image':
				$svg_element_moving->x = $bbox_element_moving->x_min;
				$svg_element_moving->y = $bbox_element_moving->y_min;
				break;
		}

		return $svg_element_moving;
	}

 }