<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an SVGRectElement
 *
 * @author	J. Xavier Atero
 */
 
class SVGFObjectBoxRectElement extends SVGFObjectBox {

	/**
	 * This function calculates the bounding box in pixels for a SVGRectElement.
	 *
	 * @param string $obj_svg The svg object used to calculate its bounding box.
	 */	
	public function __construct(SVGObject $obj_svg)
	{
		// to-do: consider unit conversion

		$this->element_name = $obj_svg->nodeName;
		$stroke_width = floatval($obj_svg->style->getPropertyValue('stroke-width'));
		$stroke_width_div_2 = $stroke_width / 2;
		
		$this->x_min = $obj_svg->x - $stroke_width_div_2;
		$this->x_max = $obj_svg->x + $obj_svg->width + $stroke_width_div_2;
		$this->y_min = $obj_svg->y - $stroke_width_div_2;
		$this->y_max = $obj_svg->y + $obj_svg->height + $stroke_width_div_2;
		$this->x_center = $obj_svg->x + ($obj_svg->width/2);
		$this->y_center = $obj_svg->y + ($obj_svg->height/2);
	}

}