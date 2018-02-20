<?php

namespace b1t\svgf\xsvg;

/**
 * This class represents the Z command in a path data.
 *
 * @link	https://www.w3.org/TR/SVG/paths.html#PathDataClosePathCommand
 * @author J. Xavier Atero
 */
class SVGPathDataCommandZ {

	/** @var string $command_type character identifying the command type. */
	protected $command_type;

	/** @var bool $is_visible indicates if the command is absolute or relative. */
	protected $is_absolute;

	/** @var bool $is_visible indicates if the command type is displayed in the path data. */
	protected $is_visible;

	public function __construct($is_absolute, $is_visible = true)
	{
		$this->is_absolute = $is_absolute;
		$this->is_visible = $is_visible;
		$this->setCommandType();
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

	private function setCommandType()
	{
		$this->command_type = ($this->is_absolute) ? 'Z' : 'z';
	}

	public function getCommandType()
	{
		return $this->command_type;
	}

	public function getCommand()
	{
		$str_command = ($this->is_visible) ? $this->command_type : '';
		$str_command = "$str_command";
		return $str_command;
	}
}