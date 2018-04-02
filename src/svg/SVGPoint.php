<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGPoint as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/coords.html#InterfaceSVGPoint
 */
 
class SVGPoint {

	/** @var float $x The x coordinate. */
	private $x;

	/** @var float $y The y coordinate. */
	private $y;

	// set and get methods

	public function setX($x)
	{
		$this->x = $x;
	}
	
	public function getX()
	{
		return $this->x;
	}

	public function setY($y)
	{
		$this->y = $y;
	}

	public function getY()
	{
		return $this->y;
	}
}