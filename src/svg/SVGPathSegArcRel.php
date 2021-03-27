<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegArcRel Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/paths.html#InterfaceSVGPathSegArcRel
 */
 
class SVGPathSegArcRel extends SVGPathSeg {

	/** @var float $x The relative X coordinate for the end point of this path segment. */
	protected $x;

	/** @var float $y The relative Y coordinate for the end point of this path segment. */
	protected $y;

	/** @var float $r1 The x-axis radius for the ellipse (i.e., r1). */
	protected $r1;

	/** @var float $r2 The y-axis radius for the ellipse (i.e., r2). */
	protected $r2;

	/** @var float $angle The rotation angle in degrees for the ellipse's x-axis relative to the x-axis of the user coordinate system. */
	protected $angle;

	/** @var boolean $largeArcFlag The value of the large-arc-flag parameter. */
	protected $largeArcFlag;

	/** @var boolean $sweepFlag The value of the sweep-flag parameter. */
	protected $sweepFlag;

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_ARC_REL;
		$this->pathSegTypeAsLetter = 'a';
	}

	// set and get methods

	public function setData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<r1>$n),(?<r2>$n) (?<angle>$n) (?<laf>$n) (?<sf>$n) (?<x>$n),(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for Path Seg type '$this->pathSegTypeAsLetter':  $this->pathSegTypeAsLetter $data");}
		$this->setR1($matches['r1']);
		$this->setR2($matches['r2']);
		$this->setAngle($matches['angle']);
		$this->setLargeArcFlag($matches['laf']);
		$this->setSweepFlag($matches['sf']);
		$this->setX($matches['x']);
		$this->setY($matches['y']);
	}

	public function getData()
	{
		$data = $this->r1 . "," . $this->r2 . " " . $this->angle . " " . $this->largeArcFlag . " " . $this->sweepFlag . " " . $this->x . "," . $this->y;
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

	public function setR1($r1)
	{
		if(!is_numeric($r1)) {throw new \Exception("Not numeric value: $r1");}
		$this->r1 = $r1;
	}

	public function getR1()
	{
		return $this->r1;
	}

	public function setR2($r2)
	{
		if(!is_numeric($r2)) {throw new \Exception("Not numeric value: $r2");}
		$this->r2 = $r2;
	}

	public function getR2()
	{
		return $this->r2;
	}

	public function setAngle($angle)
	{
		if(!is_numeric($angle)) {throw new \Exception("Not numeric value: $angle");}
		$this->angle = $angle;
	}

	public function getAngle()
	{
		return $this->angle;
	}

	public function setLargeArcFlag($large_arc_flag)
	{
		if(!is_numeric($large_arc_flag)) {throw new \Exception("Not numeric value: $large_arc_flag");}
		$this->largeArcFlag = $large_arc_flag;
	}

	public function getLargeArcFlag()
	{
		return $this->largeArcFlag;
	}

	public function setSweepFlag($sweep_flag)
	{
		if(!is_numeric($sweep_flag)) {throw new \Exception("Not numeric value: $sweep_flag");}
		$this->sweepFlag = $sweep_flag;
	}

	public function getSweepFlag()
	{
		return $this->sweepFlag;
	}

}