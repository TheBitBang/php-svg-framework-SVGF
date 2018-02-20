<?php

namespace b1t\svgf\xsvg;

/**
 * This class represents the C command in a path data.
 *
 * @link	https://www.w3.org/TR/SVG/paths.html#PathDataCurveCommands
 * @author J. Xavier Atero
 */
class SVGPathDataCommandC {

	/** @var int $x x coordinate. */
	protected $x;

	/** @var int $y y coordinate. */
	protected $y;

	/** @var int $x1 x1 coordinate. */
	protected $x1;

	/** @var int $y1 y1 coordinate. */
	protected $y1;

	/** @var int $x2 x2 coordinate. */
	protected $x2;

	/** @var int $y2 y2 coordinate. */
	protected $y2;

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
			$this->x1 = $this->x1 + $x_abs;
			$this->y1 = $this->y1 + $y_abs;
			$this->x2 = $this->x2 + $x_abs;
			$this->y2 = $this->y2 + $y_abs;
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
		$is_match = preg_match("/(?<x1>$n),(?<y1>$n) (?<x2>$n),(?<y2>$n) (?<x>$n),(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for command type '$this->command':  $this->command $data");}
		$this->setX1($matches['x1']);
		$this->setY1($matches['y1']);
		$this->setX2($matches['x2']);
		$this->setY2($matches['y2']);
		$this->setX($matches['x']);
		$this->setY($matches['y']);
	}

	private function setCommandType()
	{
		$this->command_type = ($this->is_absolute) ? 'C' : 'c';
	}

	public function getCommandType()
	{
		return $this->command_type;
	}

	public function getCommand()
	{
		$str_command = ($this->is_visible) ? $this->command_type . ' ' : '';
		$str_command = "$str_command$this->x1,$this->y1 $this->x2,$this->y2 $this->x,$this->y";
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