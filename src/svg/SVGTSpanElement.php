<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGTSpanElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/text.html#InterfaceSVGTSpanElement
 */
 
class SVGTSpanElement extends SVGObject {
	
	use SVGTextPositioningElement;
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'tspan');
	}
	
}