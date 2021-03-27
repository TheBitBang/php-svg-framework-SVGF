<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGFitToViewBox as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/types.html#InterfaceSVGFitToViewBox
 */
 
trait SVGFitToViewBox {
	
	/** @var SVGAnimatedRect $viewBox Corresponds to attribute 'viewBox' on the given element. */
	private $viewBox;
	
	/** @var SVGAnimatedPreserveAspectRatio $preserveAspectRatio Corresponds to attribute 'preserveAspectRatio' on the given element. */
	private $preserveAspectRatio;

	// set and get methods

	public function setViewBox($viewBox)
	{
		// To do: SVGAnimatedRect
		$this->viewBox = $viewBox;
		$this->setAttribute('viewBox',$viewBox); // set attribute in DOM
	}
	
	public function getViewBox()
	{
		return $this->viewBox;
	}
	
	public function setPreserveAspectRatio($preserveAspectRatio)
	{
		// To do: SVGAnimatedPreserveAspectRatio
		$this->preserveAspectRatio = $preserveAspectRatio;
		$this->setAttribute('preserveAspectRatio',$preserveAspectRatio); // set attribute in DOM
	}
	
	public function getPreserveAspectRatio()
	{
		return $this->preserveAspectRatio;
	}

}