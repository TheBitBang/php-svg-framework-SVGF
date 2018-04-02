<?php

namespace b1t\svgf\lib;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGAnimatedEnumeration;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGMarkerElement;
use b1t\svgf\SVGFNew;

/**
 * This is a helper class to create connectors.
 *
 * @author J. Xavier Atero
 */
 
class SVGFMarkers {

	public static function markerArrowStart($dom_doc, $id_marker = null, $id_path = null, $style_fill = null, $offset = 0)
	{
		$svg_marker = SVGFNew::marker($dom_doc,$id_marker,8,8,8+$offset,4,'auto');
		$svg_marker->style->setProperty('overflow','visible','');
		$svg_animated_enum = new SVGAnimatedEnumeration();
		$svg_animated_enum->setBaseVal(SVGMarkerElement::SVG_MARKERUNITS_STROKEWIDTH);
		$svg_marker->markerUnits = $svg_animated_enum; // The value of attribute ‘markerUnits’ is 'strokeWidth' 
		$svg_path = new SVGPathElement($dom_doc);
		$svg_path->d = 'M 8,0 8,8 0,4 8,0';

		// add properties if the strings are not empty
		if (isset($id_path)) {$svg_path->id = $id_path;}
		if (isset($style_fill)) {$svg_path->style->setProperty('fill',$style_fill,'');}

		$svg_marker->appendChild($svg_path);
		return $svg_marker;
	}

	public static function markerArrowEnd($dom_doc, $id_marker = null, $id_path = null, $style_fill = null, $offset = 0)
	{
		$svg_marker = SVGFNew::marker($dom_doc,$id_marker,8,8,0+$offset,4,'auto');
		$svg_marker->style->setProperty('overflow','visible','');
		$svg_animated_enum = new SVGAnimatedEnumeration();
		$svg_animated_enum->setBaseVal(SVGMarkerElement::SVG_MARKERUNITS_STROKEWIDTH);
		$svg_marker->markerUnits = $svg_animated_enum; // The value of attribute ‘markerUnits’ is 'strokeWidth' 
		$svg_path = new SVGPathElement($dom_doc);
		$svg_path->style->setProperty('fill',$style_fill,'');
		$svg_path->d = 'M 0,0 0,8 8,4 0,0';

		// add properties if the strings are not empty
		if (isset($id_path)) {$svg_path->id = $id_path;}
		if (isset($style_fill)) {$svg_path->style->setProperty('fill',$style_fill,'');}

		$svg_marker->appendChild($svg_path);
		return $svg_marker;
	}

	public static function markerCircle($dom_doc, $id_marker = null, $id_circle = null, $style_fill = null)
	{
		$svg_marker = SVGFNew::marker($dom_doc,$id_marker,8,4,5,5,'auto');
		$svg_marker->style->setProperty('overflow','visible','');
		$svg_animated_enum = new SVGAnimatedEnumeration();
		$svg_animated_enum->setBaseVal(SVGMarkerElement::SVG_MARKERUNITS_STROKEWIDTH);
		$svg_marker->markerUnits = $svg_animated_enum; // The value of attribute ‘markerUnits’ is 'strokeWidth' 
		$svg_cicrle = SVGFNew::circle($dom_doc,3,$id_circle,5,5,$style_fill);

		$svg_marker->appendChild($svg_cicrle);
		return $svg_marker;
	}

}