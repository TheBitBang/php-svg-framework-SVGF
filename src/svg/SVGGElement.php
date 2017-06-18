<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGGElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/struct.html#InterfaceSVGGElement
 */
 
class SVGGElement extends SVGObject {
	
	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'g');
	}
}