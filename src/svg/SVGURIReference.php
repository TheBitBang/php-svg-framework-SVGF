<?php

namespace b1t\svg;

// use b1t\svg\SVGAnimatedString;

/**
 * This class implements the interface SVGURIReference as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/types.html#InterfaceSVGURIReference
 */
 
trait SVGURIReference {

	/** @var SVGAnimatedString $href Corresponds to attribute ‘xlink:href’ on the given element. */
	private $href ;

	// set and get methods

	public function setHref($href = '')
	{
		$this->href = $href;
		$this->setAttribute('href',$href); // set attribute in DOM
	}

	public function getHref()
	{
		return $this->href;
	}

}