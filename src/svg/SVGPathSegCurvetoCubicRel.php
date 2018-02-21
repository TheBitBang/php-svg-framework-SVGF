<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegCurvetoCubicRel Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathSegCurvetoCubicRel
 */
 
class SVGPathSegCurvetoCubicRel extends SVGPathSeg {

	/** @var float $x The relative X coordinate for the end point of this path segment. */
	protected $x;

	/** @var float $y The relative Y coordinate for the end point of this path segment. */
	protected $y;

	/** @var float $x1 The relative X coordinate for the first control point. */
	protected $x1;

	/** @var float $y1 The relative Y coordinate for the first control point. */
	protected $y1;

	/** @var float $x2 The relative X coordinate for the second control point. */
	protected $x2;

	/** @var float $y2 The relative Y coordinate for the second control point. */
	protected $y2;

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_CURVETO_CUBIC_REL;
		$this->pathSegTypeAsLetter = 'c';
	}

	// set and get methods

	public function setData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<x1>$n),(?<y1>$n) (?<x2>$n),(?<y2>$n) (?<x>$n),(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for Path Seg type '$this->pathSegTypeAsLetter':  $this->pathSegTypeAsLetter $data");}
		$this->setX1($matches['x1']);
		$this->setY1($matches['y1']);
		$this->setX2($matches['x2']);
		$this->setY2($matches['y2']);
		$this->setX($matches['x']);
		$this->setY($matches['y']);
	}

	public function getData()
	{
		$data = $this->x1 . "," . $this->y1 . " " . $this->x2 . "," . $this->y2 . " " . $this->x . "," . $this->y;
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

	public function setX1($x1)
	{
		if(!is_numeric($x1)) {throw new \Exception("Not numeric value: $x1");}
		$this->x1 = $x1;
	}

	public function getX1()
	{
		return $this->x1;
	}

	public function setY1($y1)
	{
		if(!is_numeric($y1)) {throw new \Exception("Not numeric value: $y1");}
		$this->y1 = $y1;
	}

	public function getY1()
	{
		return $this->y1;
	}

	public function setX2($x2)
	{
		if(!is_numeric($x2)) {throw new \Exception("Not numeric value: $x2");}
		$this->x2 = $x2;
	}

	public function getX2()
	{
		return $this->x2;
	}

	public function setY2($y2)
	{
		if(!is_numeric($y2)) {throw new \Exception("Not numeric value: $y2");}
		$this->y2 = $y2;
	}

	public function getY2()
	{
		return $this->y2;
	}

}