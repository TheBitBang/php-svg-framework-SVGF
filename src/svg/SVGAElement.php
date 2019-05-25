<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGAElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/linking.html#InterfaceSVGAElement
 */
 
class SVGAElement extends SVGObject {

	use SVGElement;
	use SVGURIReference;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;

	/** @var SVGAnimatedLength $target  Corresponds to attribute 'target' on the given 'a' element. */
	private $target;

	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'a');
	}

	// set and get methods

	public function setTarget($target)
	{
		// To do: verify format
		$this->target = $target;
		$this->setAttribute('target',$target); // set attribute in DOM
	}

	public function getTarget()
	{
		return $this->target;
	}

}