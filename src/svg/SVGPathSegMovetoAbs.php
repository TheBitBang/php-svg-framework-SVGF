<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegMovetoAbs Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/paths.html#InterfaceSVGPathSegMovetoAbs
 */
 
class SVGPathSegMovetoAbs extends SVGPathSeg {

	/** @var float $x The relative X coordinate for the end point of this path segment. */
	protected $x;

	/** @var float $y The relative Y coordinate for the end point of this path segment. */
	protected $y;

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_MOVETO_ABS;
		$this->pathSegTypeAsLetter = 'M';
	}

	// set and get methods

	public function setData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<x>$n),(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for Path Seg type '$this->pathSegTypeAsLetter':  $this->pathSegTypeAsLetter $data");}
		$this->setX($matches['x']);
		$this->setY($matches['y']);
	}

	public function getData()
	{
		$data = $this->x . "," . $this->y;
		return $data;
	}

	public function setX($x)
	{
		if(!is_numeric($x)) {throw new \Exception("Not numeric value: $x");}
		$this->x = $x;
	}

	public function getX()
	{
		return $this->x;
	}

	public function setY($y)
	{
		if(!is_numeric($y)) {throw new \Exception("Not numeric value: $y");}
		$this->y = $y;
	}

	public function getY()
	{
		return $this->y;
	}
}