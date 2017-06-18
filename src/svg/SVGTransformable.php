<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGTransformable as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/types.html#InterfaceSVGTransformable
 */
 
trait SVGTransformable {
	
	use SVGLocatable;
	
	/** @var SVGAnimatedTransformList $transform Corresponds to attribute 'transform' on the given element. */
	private $transform;

	// set and get methods
	
	public function setTransform($transform = '')
	{
		// To do: make this a SVGAnimatedTransformList
		$this->transform = $transform;
		$this->setAttribute('transform',$transform); // set attribute in DOM
	}
	
	public function getTransform()
	{
		return $this->transform;
	}

}