<?php

namespace b1t\svgf\doc;

use b1t\svg\SVGSVGElement;

/**
 * This class returns SVGSVGElements with the specified properties.
 *
 * @author J. Xavier Atero
 */
 
class CreateSVGPage {
	
	const SIZE_A0 = array('mm', '841', '1189');
	const SIZE_A1 = array('mm', '594', '841');
	const SIZE_A2 = array('mm', '420', '594');
	const SIZE_A3 = array('mm', '297', '420');
	const SIZE_A4 = array('mm', '210', '297');
	const SIZE_A5 = array('mm', '148', '210');
	const SIZE_ARCH_A = array('in', '9', '12');
	const SIZE_ARCH_B = array('in', '12', '18');
	const SIZE_ARCH_C = array('in', '18', '24');
	const SIZE_ARCH_D = array('in', '24', '36');
	const SIZE_ARCH_E = array('in', '36', '48');
	const SIZE_ICON_16X16 = array('px', '16', '16');
	const SIZE_ICON_32X32 = array('px', '32', '32');
	const SIZE_ICON_48X48 = array('px', '48', '48');
	const SIZE_VGA = array('px', '480', '640');
	const SIZE_SVGA = array('px', '600', '800');
	const SIZE_XGA = array('px', '768', '1024');
	const SIZE_HD = array('px', '720', '1280');
	const SIZE_FHD = array('px', '1080', '1920');
	const SIZE_QHD = array('px', '1440', '2560');
	const SIZE_UHD = array('px', '2160', '3840');
	const SIZE_8K = array('px', '4320', '7680');
	
	public static function svgPage($dom_doc, $id ='', $const_size = self::SIZE_A4, $orientation = 'landscape')
	{

		$svg_svg = new SVGSVGElement($dom_doc);
		
		$units = $const_size[0];
		
		if ($orientation == 'portrait')
		{	// portrait orientation
			$width = $const_size[1];
			$height = $const_size[2];
		}
		else
		{	// landscape orientation
			$width = $const_size[2];
			$height = $const_size[1];
		}
		
		$svg_svg->setWidth($width . $units);
		$svg_svg->setHeight($height . $units);
		$svg_svg->setViewBox('0 0 ' . $width . ' ' . $height);
		$svg_svg->setVersion('1.1');
		$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');	
		if (!empty($id)) 
		{	// add id if the string if not empty
			$svg_svg->setId($id);
		}

		return $svg_svg;	
	}
	
 }