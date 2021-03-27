<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGExternalResourcesRequired Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/types.html#InterfaceSVGExternalResourcesRequired
 */
 
trait SVGExternalResourcesRequired {

	/** @var readonly SVGAnimatedBoolean $externalResourcesRequired Corresponds to attribute ‘externalResourcesRequired’ on the given element. Note that the SVG DOM defines the attribute ‘externalResourcesRequired’ as being of type SVGAnimatedBoolean, whereas the SVG language definition says that ‘externalResourcesRequired’ is not animated. Because the SVG language definition states that ‘externalResourcesRequired’ cannot be animated, the animVal will always be the same as the baseVal. */
	private $externalResourcesRequired;
	
	// set and get methods

	public function setExternalResourcesRequired($externalResourcesRequired)
	{
		// To do: verify format
		$this->externalResourcesRequired = $externalResourcesRequired;
	}
	
	public function getExternalResourcesRequired()
	{
		return $this->externalResourcesRequired;
	}	

}