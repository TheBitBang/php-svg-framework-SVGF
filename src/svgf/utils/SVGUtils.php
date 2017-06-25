<?php

namespace b1t\svgf\utils;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGRectElement;

/**
 * This class returns SVGElements with the specified properties.
 *
 * @author J. Xavier Atero
 */
 
class SVGUtils {
	
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
	
	public static function svg($dom_doc, $id = null, $const_size = self::SIZE_A4, $orientation = 'landscape')
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
		$variable = $item ?: NULL;
		
		// add properties if the strings are not empty
		if (isset($id))	{$svg_svg->id = $id;}

		return $svg_svg;	
	}
	
	public static function rect($dom_doc_svg, $width, $height, $id = null , $x = '0', $y = '0', $rx = null, $ry = null, $style_fill = null, $style_stroke = null, $style_stroke_width = null)
	{

		$svg_rect = new SVGRectElement($dom_doc_svg);
		$svg_rect->width = $width;
		$svg_rect->height = $height;
		$svg_rect->x = $x;
		$svg_rect->y = $y;

		// add properties if the strings are not empty
		if (isset($id))	{$svg_rect->id = $id;}
		if (isset($rx))	{$svg_rect->rx = $rx;}
		if (isset($ry))	{$svg_rect->ry = $ry;}
		if (isset($style_fill))	{$svg_rect->style->setProperty('fill',$style_fill,'');}
		if (isset($style_stroke))	{$svg_rect->style->setProperty('stroke',$style_stroke,'');}
		if (isset($style_stroke_width))	{$svg_rect->style->setProperty('stroke-width',$style_stroke_width,'');}
		
		return $svg_rect;	
	}	
	
	public static function circle($dom_doc_svg, $r, $id = null , $cx = '0', $cy = '0', $style_fill = null, $style_stroke = null, $style_stroke_width = null)
	{

		$svg_circle = new SVGCircleElement($dom_doc_svg);
		$svg_circle->r = $r;

		// add properties if the strings are not empty
		if (isset($id))	{$svg_circle->id = $id;}
		if (isset($cx))	{$svg_circle->cx = $cx;}
		if (isset($cy))	{$svg_circle->cy = $cy;}
		if (isset($style_fill))	{$svg_circle->style->setProperty('fill',$style_fill,'');}
		if (isset($style_stroke))	{$svg_circle->style->setProperty('stroke',$style_stroke,'');}
		if (isset($style_stroke_width))	{$svg_circle->style->setProperty('stroke-width',$style_stroke_width,'');}
		
		return $svg_circle;	
	}		
	
 }