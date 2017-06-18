<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGPolylineElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/shapes.html#InterfaceSVGPolylineElement
 */
 
class SVGPolylineElement extends SVGObject {
	
	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;	
	use SVGAnimatedPoints;
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'polyline');
	}	

}