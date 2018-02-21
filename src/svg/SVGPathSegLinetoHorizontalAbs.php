<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegLinetoHorizontalAbs Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathSegLinetoHorizontalAbs
 */
 
class SVGPathSegLinetoHorizontalAbs extends SVGPathSeg {

	/** @var float $x The relative X coordinate for the end point of this path segment. */
	protected $x;

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_LINETO_HORIZONTAL_ABS;
		$this->pathSegTypeAsLetter = 'H';
	}

	// set and get methods

	public function setData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<x>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for Path Seg type '$this->pathSegTypeAsLetter':  $this->pathSegTypeAsLetter $data");}
		$this->setX($matches['x']);
	}

	public function getData()
	{
		$data = $this->x; 
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

}