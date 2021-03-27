<?php

namespace b1t\svg;

use b1t\svg\SVGPointList;

/**
 * This class implements the interface SVGAnimatedPoints as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/shapes.html#InterfaceSVGAnimatedPoints
 */
 
trait SVGAnimatedPoints {
	
	/** @var SVGPointList $points Provides access to the base (i.e., static) contents of the 'points' attribute. */
	private $points;

	/** @var SVGPointList $animatedPoints Provides access to the current animated contents of the 'points' attribute. If the given attribute or property is being animated, contains the current animated value of the attribute or property. If the given attribute or property is not currently being animated, contains the same value as points. */
	private $animatedPoints;

	// set and get methods
	
	public function setPoints($points = '')
	{
		// To do: make this a point list
		$this->points = $points;
		$this->setAttribute('points',$points); // set attribute in DOM
	}
	
	public function getPoints()
	{
		return $this->points;
	}

	public function setAnimatedPoints($animatedPoints = '')
	{
		// To do: make this a point list
		$this->animatedPoints = $animatedPoints;
		$this->setAttribute('animatedPoints',$animatedPoints); // set attribute in DOM
	}
	
	public function getAnimatedPoints()
	{
		return $this->animatedPoints;
	}

}