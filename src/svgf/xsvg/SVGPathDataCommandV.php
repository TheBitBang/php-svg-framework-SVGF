<?php

namespace b1t\svgf\xsvg;

/**
 * This class represents the V command in a path data.
 *
 * @link	https://www.w3.org/TR/SVG/paths.html#PathDataLinetoCommands
 * @author J. Xavier Atero
 */
class SVGPathDataCommandV {

	/** @var int $y y coordinate. */
	protected $y;

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

	public function makeAbsoulte($y_abs)
	{
		if(!is_numeric($y_abs)) {throw new \Exception("Not numeric value: $y_abs");}

		if (!$this->is_absolute) {
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
		$is_match = preg_match("/(?<y>$n)/", $data, $matches);
		if(!is_match) {throw new \Exception("Wrong syntax for command type '$this->commandType':  $this->command $data");}
		$this->setY($matches['y']);
	}

	private function setCommandType()
	{
		$this->command_type = ($this->is_absolute) ? 'V' : 'v';
	}

	public function getCommandType()
	{
		return $this->command_type;
	}

	public function getCommand()
	{
		$str_command = ($this->is_visible) ? $this->command_type . ' ' : '';
		$str_command = "$str_command$this->y";
		return $str_command;
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