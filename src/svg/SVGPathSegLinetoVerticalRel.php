<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegLinetoVerticalRel Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathSegLinetoVerticalRel
 */
 
class SVGPathSegLinetoVerticalRel extends SVGPathSeg {

	/** @var float $y The relative Y coordinate for the end point of this path segment. */
	protected $y;

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_LINETO_VERTICAL_REL;
		$this->pathSegTypeAsLetter = 'v';
	}

	// set and get methods

	public function setData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for Path Seg type '$this->pathSegTypeAsLetter':  $this->pathSegTypeAsLetter $data");}
		$this->setX($matches['y']);
	}

	public function getData()
	{
		$data = $this->y; 
		return $data;
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