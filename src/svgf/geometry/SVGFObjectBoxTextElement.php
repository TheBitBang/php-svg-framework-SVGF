<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an SVGTextElement
 *
 * @author	J. Xavier Atero
 */
 
class SVGFObjectBoxTextElement extends SVGFObjectBox {

	/**
	 * This function calculates the bounding box in pixels for a TrueType text.
	 *
	 * It assumes that the file containing the TrueType font is located in the same folder.
	 *
	 * @param string $obj_svg The svg object used to calculate its bounding box.
	 *
	 * @throws Exception if GD version is different of 1 or 2.
	 */	
	public function __construct(SVGObject $obj_svg)
	{
		// to-do: consider unit conversion
		// to-do: test more fonts
		// to-do: fix hunging characters jpgq
			
		// get gd version
		$array_gd_info = gd_info();
		$str_gd_version = $array_gd_info['GD Version'];
		preg_match('/\d+/', $str_gd_version, $matches); // find first integer
		$gd_version = $matches[0]; // In GD 1, this is measured in pixels. In GD 2, this is measured in points.
		
		//set the conversion rate
		$float_conversion_rate;
		switch ($gd_version) {
			case 1:
				$float_conversion_rate = 1; // In GD 1, this is measured in pixels. 
				break;
			case 2:
				$float_conversion_rate = 3/4; // In GD 2, this is measured in points.
				break;
			default: 
				throw new \Exception("Conversion rate not defined for GD Version: $str_gd_version");
		}

		// get font style information
		$font_file = $obj_svg->style->getPropertyValue('font-family');
		$path_to_font_file = './' . $font_file;
		$font_size_pixels = floatval($obj_svg->style->getPropertyValue('font-size'));
		
		// calculate bounding box
		$bounding = imagettfbbox($font_size_pixels, 0, $path_to_font_file, $obj_svg->nodeValue);
		$x_min = min($bounding[0],$bounding[2],$bounding[4],$bounding[6]) * $float_conversion_rate; 
		$x_max = max($bounding[0],$bounding[2],$bounding[4],$bounding[6]) * $float_conversion_rate;
		$y_min = min($bounding[1],$bounding[3],$bounding[5],$bounding[7]) * $float_conversion_rate;
		$y_max = max($bounding[1],$bounding[3],$bounding[5],$bounding[7]) * $float_conversion_rate;
		$this->x_min = $obj_svg->x + $x_min;
		$this->x_max = $obj_svg->x + $x_max;
		$this->y_min = $obj_svg->y + $y_min;
		$this->y_max = $obj_svg->y + $y_max;
		$this->x_center = $obj_svg->x + ($x_min + $x_max) / 2;
		$this->y_center = $obj_svg->y + ($y_min + $y_max) / 2;
	}
}