<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an SVGCircleElement
 *
 * @author	J. Xavier Atero
 */
 
class SVGObjectBoxCircleElement extends SVGObjectBox {


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
		$this->xMin = $obj_svg->cx - $obj_svg->r - $stroke_width_div_2;
		$this->xMax = $obj_svg->cx + $obj_svg->r + $stroke_width_div_2;
		$this->yMin = $obj_svg->cy - $obj_svg->r - $stroke_width_div_2;
		$this->yMax = $obj_svg->cy + $obj_svg->r + $stroke_width_div_2;
		$this->xCenter = $obj_svg->cx;
		$this->yCenter = $obj_svg->cy;
	}

}