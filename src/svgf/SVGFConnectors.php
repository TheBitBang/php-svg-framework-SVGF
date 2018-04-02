<?php

namespace b1t\svgf;

use b1t\svg\SVGSVGElement;
use b1t\svg\SVGCircleElement;
use b1t\svg\SVGRectElement;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGPathSegMovetoAbs;
use b1t\svg\SVGPathSegLinetoAbs;
use b1t\svgf\geometry\SVGFObjectBox;
use b1t\svgf\geometry\SVGFObjectBoxRectElement;
use b1t\svgf\geometry\SVGFObjectBoxCircleElement;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;
use b1t\svgf\geometry\SVGFObjectBoxTSpanElement;

/**
 * This is a helper class to create connectors.
 *
 * @author J. Xavier Atero
 */
 
class SVGFConnectors {

	public static function connectPoints($dom_doc, $svg_point_start, $svg_point_end, $style_stroke, $style_stroke_width, $id = null, $marker_start_url = null, $marker_end_url = null)
	{
		// origin coordinates
		$svg_path_m_abs = new SVGPathSegMovetoAbs();
		$svg_path_m_abs->setX($svg_point_start->getX());
		$svg_path_m_abs->setY($svg_point_start->getY());

		// destination coordinates
		$svg_path_l_abs = new SVGPathSegLinetoAbs();
		$svg_path_l_abs->setX($svg_point_end->getX());
		$svg_path_l_abs->setY($svg_point_end->getY());

		// create path
		$svg_path = new SVGPathElement($dom_doc);
		$m = $svg_path_m_abs->getPathSegTypeAsLetter() . ' ' .  $svg_path_m_abs->getData();
		$l = $svg_path_l_abs->getPathSegTypeAsLetter() . ' ' .  $svg_path_l_abs->getData();
		$svg_path->setD("$m $l");

		// add properties if the strings are not empty
		if (isset($id)) {$svg_path->id = $id;}
		$svg_path->style->setProperty('stroke',$style_stroke,'');
		$svg_path->style->setProperty('stroke-width',$style_stroke_width,'');
		if (isset($marker_start_url)) {$svg_path->style->setProperty('marker-start','url(#' . $marker_start_url . ')','');}
		if (isset($marker_end_url)) {$svg_path->style->setProperty('marker-end','url(#' . $marker_end_url . ')','');}
		return $svg_path;
	}

}