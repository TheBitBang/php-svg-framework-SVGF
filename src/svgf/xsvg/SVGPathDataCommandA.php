<?php

namespace b1t\svgf\xsvg;

/**
 * This class represents the C command in a path data.
 *
 * @link	https://www.w3.org/TR/SVG/paths.html#PathDataEllipticalArcCommands
 * @author J. Xavier Atero
 */
class SVGPathDataCommandA {

	/** @var int $x x coordinate. */
	protected $x;

	/** @var int $y y coordinate. */
	protected $y;

	/** @var int $x_axis_rotation x-axis-rotation radius. */
	protected $x_axis_rotation;

	/** @var int $large_arc_flag constrain. */
	protected $large_arc_flag;

	/** @var int $sweep_flag constrain. */
	protected $sweep_flag;

	/** @var int $rx x radius. */
	protected $rx;

	/** @var int $ry y radius. */
	protected $ry;

	/** @var string $command_type character identifying the command type. */
	protected $command_type;

	/** @var bool $is_visible indicates if the command is absolute or relative. */
	protected $is_absolute;

	/** @var bool $is_visible indicates if the command type is displayed in the path data. */
	protected $is_visible;

	public function __construct($is_absolute, $data, $is_visible = true)
	{
		$this->is_absolute = $is_absolute;
		$this->is_visible = $is_visible;
		$this->setCommandData($data);
		$this->setCommandType();
	}

	public function makeAbsoulte($x_abs, $y_abs)
	{

		if(!is_numeric($x_abs)) {throw new \Exception("Not numeric value: $x_abs");}
		if(!is_numeric($y_abs)) {throw new \Exception("Not numeric value: $y_abs");}

		if (!$this->is_absolute) {
			$this->x = $this->x + $x_abs;
			$this->y = $this->y + $y_abs;
			$this->is_absolute = true;
			$this->setCommandType();
		}
	}

	public function makeVisible()
	{
		$this->is_visible = true;
	}

	public function isAbsolute()
	{
		return $this->is_absolute;
	}

	// set and get methods

	public function setCommandData($data)
	{
		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$is_match = preg_match("/(?<rx>$n),(?<ry>$n) (?<xar>$n) (?<laf>$n) (?<sf>$n) (?<x>$n),(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for command type '$this->command':  $this->command $data");}
		$this->setRx($matches['rx']);
		$this->setRy($matches['ry']);
		$this->setXAxisRotation($matches['xar']);
		$this->setLargeArcFlag($matches['laf']);
		$this->setSweepFlag($matches['sf']);
		$this->setX($matches['x']);
		$this->setY($matches['y']);
	}

	private function setCommandType()
	{
		$this->command_type = ($this->is_absolute) ? 'A' : 'a';
	}

	public function getCommandType()
	{
		return $this->command_type;
	}

	public function getCommand()
	{
		$str_command = ($this->is_visible) ? $this->command_type . ' ' : '';
		$str_command = "$str_command$this->rx,$this->ry $this->x_axis_rotation $this->large_arc_flag $this->sweep_flag $this->x,$this->y";
		return $str_command;
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

	public function setXAxisRotation($x_axis_rotation)
	{
		if(!is_numeric($x_axis_rotation)) {throw new \Exception("Not numeric value: $x_axis_rotation");}
		$this->x_axis_rotation = $x_axis_rotation;
	}

	public function getXAxisRotation()
	{
		return $this->x_axis_rotation;
	}

	public function setLargeArcFlag($large_arc_flag)
	{
		if(!is_numeric($large_arc_flag)) {throw new \Exception("Not numeric value: $large_arc_flag");}
		$this->large_arc_flag = $large_arc_flag;
	}

	public function getLargeArcFlag()
	{
		return $this->large_arc_flag;
	}

	public function setSweepFlag($sweep_flag)
	{
		if(!is_numeric($sweep_flag)) {throw new \Exception("Not numeric value: $sweep_flag");}
		$this->sweep_flag = $sweep_flag;
	}

	public function getSweepFlag()
	{
		return $this->sweep_flag;
	}

	public function setRx($rx)
	{
		if(!is_numeric($rx)) {throw new \Exception("Not numeric value: $rx");}
		$this->rx = $rx;
	}

	public function getRx()
	{
		return $this->rx;
	}

	public function setRy($ry)
	{
		if(!is_numeric($ry)) {throw new \Exception("Not numeric value: $ry");}
		$this->ry = $ry;
	}

	public function getRy()
	{
		return $this->ry;
	}

}