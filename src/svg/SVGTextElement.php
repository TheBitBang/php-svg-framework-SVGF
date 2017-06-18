<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGTextElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	http://www.w3.org/TR/SVG/text.html#InterfaceSVGTextElement
 */
 
class SVGTextElement extends SVGObject {
	
	use SVGTextPositioningElement;
	use SVGTransformable;
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'text');
	}

}