<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an SVGTextElement
 *
 * @author	J. Xavier Atero
 */
 
class SVGObjectBoxTextElement extends SVGObjectBox {

	/** @var string $fontFile The path to the TrueType font you wish to use. */
	private $fontFile = array();
	
	/**
	 * This function calculates the bounding box in pixels for a TrueType text.
	 *
	 * @param string $obj_svg The svg object used to calculate its bounding box.
	 * @param string $fontFile The path to the TrueType font you wish to use.
	 *
	 * @throws Exception if GD version is different of 1 or 2.
	 */	
	public function __construct(SVGObject $obj_svg, $fontFile)
	{
		// to-do: consider unit conversion
		// to-do: test more fonts
		// to-do: fix hunging characters jpgq
		
		$this->fontFile = $fontFile;
		
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

		$font_size_pixels = floatval($obj_svg->style->getPropertyValue('font-size'));
		$bounding = imagettfbbox($font_size_pixels, 0, $this->fontFile, $obj_svg->nodeValue);
		$xMin = min($bounding[0],$bounding[2],$bounding[4],$bounding[6]) * $float_conversion_rate; 
		$xMax = max($bounding[0],$bounding[2],$bounding[4],$bounding[6]) * $float_conversion_rate;
		$yMin = min($bounding[1],$bounding[3],$bounding[5],$bounding[7]) * $float_conversion_rate;
		$yMax = max($bounding[1],$bounding[3],$bounding[5],$bounding[7]) * $float_conversion_rate;
		$this->xMin = $xMin;
		$this->xMax = $xMax;
		$this->yMin = $yMin;
		$this->yMax = $yMax;
		$this->xCenter = ($xMin + $xMax) / 2;
		$this->yCenter = ($yMin + $yMax) / 2;
	}
}