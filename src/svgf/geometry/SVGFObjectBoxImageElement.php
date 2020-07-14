<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an SVGImageElement
 *
 * @author	J. Xavier Atero
 */
 
class SVGFObjectBoxImageElement extends SVGFObjectBox {

	/**
	 * This function calculates the bounding box in pixels for a SVGImageElement.
	 *
	 * @param string $obj_svg The svg object used to calculate its bounding box.
	 */
	public function __construct(SVGObject $obj_svg)
	{
		// to-do: consider unit conversion

		$this->element_name = $obj_svg->nodeName;

		// get the dimensions of the image
		$width = getimagesize ($obj_svg->getHref())[0]; // read image width;
		$height = getimagesize ($obj_svg->getHref())[1]; // read image height;
		$aspect_ratio = $width / $height;

		$is_width_definied = $obj_svg->getWidth() != "";
		$is_height_definied = $obj_svg->getHeight() != "";
		if ($is_width_definied & !$is_height_definied)
		{
			$width = $obj_svg->getWidth();
			$height = $width / $aspect_ratio;
		}
		else if (!$is_width_definied & $is_height_definied)
		{
			$height = $obj_svg->getHeight();
			$width = $height * $aspect_ratio;
		}
		else if ($is_width_definied & $is_height_definied)
		{
			$width = $obj_svg->getWidth();
			$height = $obj_svg->getHeight();
			$expected_width = $height * $aspect_ratio;
			$is_the_width_more_restricting = $width < $expected_width;
			if ($is_the_width_more_restricting)
			{
				$height = $width / $aspect_ratio;
			}
			else
			{
				$width = $height * $aspect_ratio;
			}
		}

		$this->x_min = $obj_svg->x ;
		$this->x_max = $obj_svg->x + $width;
		$this->y_min = $obj_svg->y;
		$this->y_max = $obj_svg->y + $height;
		$this->x_center = $obj_svg->x + ($width/2);
		$this->y_center = $obj_svg->y + ($height/2);
	}

}