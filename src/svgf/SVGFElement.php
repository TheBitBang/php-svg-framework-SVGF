<?php

namespace b1t\svgf;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGDefsElement;
use b1t\svg\SVGMarkerElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svg\SVGAnimatedLength;
use b1t\svg\SVGPoint;

/**
 * This class returns SVGElements with the specified properties.
 *
 * @author J. Xavier Atero
 */
 
class SVGFElement {

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

		// add properties if the strings are not empty
		if (isset($id)) {$svg_svg->id = $id;}

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
		if (isset($id)) {$svg_rect->id = $id;}
		if (isset($rx)) {$svg_rect->rx = $rx;}
		if (isset($ry)) {$svg_rect->ry = $ry;}
		if (isset($style_fill)) {$svg_rect->style->setProperty('fill',$style_fill,'');}
		if (isset($style_stroke)) {$svg_rect->style->setProperty('stroke',$style_stroke,'');}
		if (isset($style_stroke_width)) {$svg_rect->style->setProperty('stroke-width',$style_stroke_width,'');}

		return $svg_rect;
	}

	public static function circle($dom_doc_svg, $r, $id = null , $cx = '0', $cy = '0', $style_fill = null, $style_stroke = null, $style_stroke_width = null)
	{

		$svg_circle = new SVGCircleElement($dom_doc_svg);
		$svg_circle->r = $r;

		// add properties if the strings are not empty
		if (isset($id)) {$svg_circle->id = $id;}
		if (isset($cx)) {$svg_circle->cx = $cx;}
		if (isset($cy)) {$svg_circle->cy = $cy;}
		if (isset($style_fill)) {$svg_circle->style->setProperty('fill',$style_fill,'');}
		if (isset($style_stroke)) {$svg_circle->style->setProperty('stroke',$style_stroke,'');}
		if (isset($style_stroke_width)) {$svg_circle->style->setProperty('stroke-width',$style_stroke_width,'');}

		return $svg_circle;
	}

	public static function text($dom_doc_svg, $value, $id = null , $x = '0', $y = '0', $style_font_family = null, $style_font_size = null, $style_weight = null, $style_fill = null)
	{

		$svg_text = new SVGTextElement($dom_doc_svg);
		$svg_text->nodeValue = $value;

		// add properties if the strings are not empty
		if (isset($id)) {$svg_text->id = $id;}
		if (isset($x)) {$svg_text->x = $x;}
		if (isset($y)) {$svg_text->y = $y;}
		if (isset($style_font_family)) {$svg_text->style->setProperty('font-family',$style_font_family,'');}
		if (isset($style_font_size)) {$svg_text->style->setProperty('font-size',$style_font_size,'');}
		if (isset($style_weight)) {$svg_text->style->setProperty('font-weight',$style_weight,'');}
		if (isset($style_fill)) {$svg_text->style->setProperty('fill',$style_fill,'');}

		return $svg_text;
	}

	public static function tspan($dom_doc_svg, $value, $id = null , $x = '0', $y = '0', $style_font_family = null, $style_font_size = null, $style_weight = null, $style_fill = null)
	{

		$svg_tspan = new SVGTSpanElement($dom_doc_svg);
		$svg_tspan->nodeValue = $value;

		// add properties if the strings are not empty
		if (isset($id)) {$svg_tspan->id = $id;}
		if (isset($x)) {$svg_tspan->x = $x;}
		if (isset($y)) {$svg_tspan->y = $y;}
		if (isset($style_font_family)) {$svg_tspan->style->setProperty('font-family',$style_font_family,'');}
		if (isset($style_font_size)) {$svg_tspan->style->setProperty('font-size',$style_font_size,'');}
		if (isset($style_weight)) {$svg_tspan->style->setProperty('font-weight',$style_weight,'');}
		if (isset($style_fill)) {$svg_tspan->style->setProperty('fill',$style_fill,'');}

		return $svg_tspan;
	}

	public static function defs($dom_doc_svg, $id = null)
	{

		$svg_defs = new SVGDefsElement($dom_doc_svg);

		// add properties if the strings are not empty
		if (isset($id)) {$svg_defs->id = $id;}

		return $svg_defs;
	}

	public static function marker($dom_doc_svg, $id = null, $markerWidth = null, $markerHeight = null, $refX = null, $refY = null, $orient = null)
	{

		$svg_marker = new SVGMarkerElement($dom_doc_svg);

		// add properties if the strings are not empty
		if (isset($id)) {$svg_marker->id = $id;}
		if (isset($markerWidth)) {
			$marker_width = new SVGAnimatedLength();
			$marker_width->setBaseVal($markerWidth);
			$svg_marker->markerWidth = $marker_width;
		}
		if (isset($markerHeight)) {
			$marker_height = new SVGAnimatedLength();
			$marker_height->setBaseVal($markerHeight);
			$svg_marker->markerHeight = $marker_height;
		}
		if (isset($refX)) {
			$ref_x = new SVGAnimatedLength();
			$ref_x->setBaseVal($refX);
			$svg_marker->refX = $ref_x;
		}
		if (isset($refY)) {
			$ref_y = new SVGAnimatedLength();
			$ref_y->setBaseVal($refY);
			$svg_marker->refY = $ref_y;
		}
		if (isset($orient)) {$svg_marker->setOrient($orient);}

		return $svg_marker;
	}

	public static function point($x, $y)
	{
		$svg_point = new SVGPoint();
		$svg_point->setX($x);
		$svg_point->setY($y);
		return $svg_point;
	}
}