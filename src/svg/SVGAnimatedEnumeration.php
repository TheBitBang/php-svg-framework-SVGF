<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGAnimatedEnumeration Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/types.html#InterfaceSVGAnimatedEnumeration
 */
 
class SVGAnimatedEnumeration {

	/** @var unsigned short $baseVal The base value of the given attribute before applying any animations. */
	private $baseVal;

	/** @var readonly unsigned short $animVal If the given attribute or property is being animated, contains the current animated value of the attribute or property. If the given attribute or property is not currently being animated, contains the same value as baseVal. */
	private $animVal = null;

	// set and get methods	
	
	public function setBaseVal($baseVal)
	{
		$this->baseVal = $baseVal;
		if ($this->animVal == null)
		{ //  If the given attribute or property is not currently being animated, contains the same value as baseVal.
			$this->animVal = $this->baseVal;
		}
	}
	
	public function getBaseVal()
	{
		return $this->baseVal;
	}
	
	public function setAnimVal($animVal)
	{
		$this->animVal = $animVal;
		if ($animVal == null)
		{ //  If the given attribute or property is not currently being animated, contains the same value as baseVal.
			$this->animVal = $this->baseVal;
		}		
	}
	
	public function getAnimVal()
	{
		return $this->animVal;
	}	
}