<?php

namespace b1t\svgf\xsvg;

/**
 * This class contains an extended implementation for the SVGPathData.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#PathData
 */
 
class SVGPathData {

	/** @var array $array_path_data TO_DO. */
	protected $array_path_data;

	public function __construct($data)
	{
		$this->setArrayPathData($data);
	}

	public function getPathData()
	{
		$path_data = '';
		foreach ($this->array_path_data as $command) 
		{
			$path_data = $path_data . $command->getCommand() . ' ';
		}

		return trim($path_data);
	}

	public function getPathdataArray()
	{
		return $this->array_path_data;
	}

	public function setArrayPathData($data)
	{

		$n = '[-]?[\d]+(.[\d]+)?'; // regular expression to match a number
		$regex_command_first = "[M|m]( )*($n,$n( )*)+";
		$regex_command_last = "([Z|z]( )*)?";
		$regex_command_one_dimension = "[H|h|V|v]( )*$n( )*";
		$regex_command_one_coordenate = "[M|m|L|l|T|t]( )*$n,$n( )*";
		$regex_command_two_coordenates = "[S|s|Q|q]( )*$n,$n( )+$n,$n( )*";
		$regex_command_three_coordenates = "[C|c]( )*$n,$n( )+$n,$n( )+$n,$n( )*";
		$regex_command_a = "[A|a]( )*($n,$n( )+$n( )+$n,$n( )+$n,$n( )+)+( )*";
		$regex_command_mixed = '((' . $regex_command_one_dimension . ')|(' . $regex_command_one_coordenate . ')|(' . $regex_command_two_coordenates . ')|(' . $regex_command_three_coordenates . ')|(' . $regex_command_a . '))*';

		// verify syntax
		$is_match = preg_match('/(' . $regex_command_first . $regex_command_mixed . $regex_command_last .')+/', $data, $matches);
		if(!$is_match) {throw new \Exception("Wrong syntax for path_data '$data");}

		// split in commands
		$array_commands = preg_split('/([M|m|L|l|H|h|V|v|C|c|S|s|Q|q|T|t|A|a][$n+, ]+|[Z|z][ ]*)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		for ($i=0;$i<count($array_commands);$i++) {
			$commandType = trim($array_commands[$i]);
			switch ($commandType){
				case 'm':
				case 'M':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandM($commandType,$commandValue);
					break;
				case 'Z':
					$this->array_path_data[] = new SVGPathDataCommandZ(true);
					break;
				case 'z':
					$this->array_path_data[] = new SVGPathDataCommandZ(false);
					break;
				case 'L':
				case 'l':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandL($commandType,$commandValue);
					break;
				case 'H':
				case 'h':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandH($commandType,$commandValue);
					break;
				case 'V':
				case 'v':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandV($commandType,$commandValue);
					break;
				case 'C':
				case 'c':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandC($commandType,$commandValue);
					break;
				case 'S':
				case 's':
				case 'Q':
				case 'q':
					break;
				case 'T':
				case 't':
					$commandValue = trim($array_commands[$i]);
					$this->processCommandL($commandType,$commandValue);
					break;
				case 'A':
				case 'a':
					$i++;
					$commandValue = trim($array_commands[$i]);
					$this->processCommandA($commandType,$commandValue);
					break;
			}
		}
	}

	private function processCommandM($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an M or m
		if ($commandType == 'M') {
			$this->array_path_data[] = new SVGPathDataCommandM(true,$array_values[0]);
		} else { // 'm'
			$this->array_path_data[] = new SVGPathDataCommandM(false,$array_values[0]);
		}

		// the next values correspond to L or l (non-visible)
		for ($i=1;$i<count($array_values);$i++) {
			if ($commandType == 'M') {
				$this->array_path_data[] = new SVGPathDataCommandL(true,$array_values[$i],false);
			} else { // 'm'
				$this->array_path_data[] = new SVGPathDataCommandL(false,$array_values[$i],false);
			}
		}
	}

	private function processCommandL($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an L or l (visible)
		if ($commandType == 'L') {
			$this->array_path_data[] = new SVGPathDataCommandL(true,$array_values[0]);
		} else { // 'l'
			$this->array_path_data[] = new SVGPathDataCommandL(false,$array_values[0]);
		}

		// the next values correspond to L or l (non-visible)
		for ($i=1;$i<count($array_values);$i++) {
			if ($commandType == 'L') {
				$this->array_path_data[] = new SVGPathDataCommandL(true,$array_values[$i],false);
			} else { // 'l'
				$this->array_path_data[] = new SVGPathDataCommandL(false,$array_values[$i],false);
			}
		}
	}

	private function processCommandH($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an H or h
		if ($commandType == 'H') {
			$this->array_path_data[] = new SVGPathDataCommandH(true,$array_values[0]);
		} else { // 'h'
			$this->array_path_data[] = new SVGPathDataCommandH(false,$array_values[0]);
		}
	}

	private function processCommandV($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an V or v
		if ($commandType == 'V') {
			$this->array_path_data[] = new SVGPathDataCommandV(true,$array_values[0]);
		} else { // 'v'
			$this->array_path_data[] = new SVGPathDataCommandV(false,$array_values[0]);
		}
	}

	private function processCommandC($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an C or c (visible)
		$data = $array_values[0] . ' ' . $array_values[1] . ' ' . $array_values[2] . ' ';
		if ($commandType == 'C') {
			$this->array_path_data[] = new SVGPathDataCommandC(true,$data);
		} else { // 'c'
			$this->array_path_data[] = new SVGPathDataCommandC(false,$data);
		}

		// the next values correspond to C or c (non-visible)
		for ($i=3;$i<count($array_values);$i=$i+3) {
			$data = $array_values[$i] . ' ' . $array_values[$i+1] . ' ' . $array_values[$i+2] . ' ';
			if ($commandType == 'C') {
				$this->array_path_data[] = new SVGPathDataCommandC(true,$data,false);
			} else { // 'c'
				$this->array_path_data[] = new SVGPathDataCommandC(false,$data,false);
			}
		}
	}

	private function processCommandT($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));

		// the first value corresponds to an T or t
		if ($commandType == 'T') {
			$this->array_path_data[] = new SVGPathDataCommandT(true,$array_values[0]);
		} else { // 't'
			$this->array_path_data[] = new SVGPathDataCommandT(false,$array_values[0]);
		}
	}

	private function processCommandA($commandType, $commandValue)
	{
		// split in commands
		$array_values = array_values(array_filter(explode(' ',$commandValue),'self::filterNumeric'));
 
		// the first value corresponds to an A or a (visible)
		$data = $array_values[0] . ' ' . $array_values[1] . ' ' . $array_values[2] . ' ' . $array_values[3] . ' ' . $array_values[4] . ' ';
		if ($commandType == 'A') {
			$this->array_path_data[] = new SVGPathDataCommandA(true,$data);
		} else {
			$this->array_path_data[] = new SVGPathDataCommandA(false,$data);
		}

		// the next values correspond to A or a (non-visible)
		for ($i=5;$i<count($array_values);$i=$i+5) {
			$data = $array_values[$i] . ' ' . $array_values[$i+1] . ' ' . $array_values[$i+2] . ' ' . $array_values[$i+3] . ' ' . $array_values[$i+4] . ' ';
			if ($commandType == 'A') {
				$this->array_path_data[] = new SVGPathDataCommandA(true,$data,false);
			} else { // 'a'
				$this->array_path_data[] = new SVGPathDataCommandA(false,$data,false);
			}
		}
	}

	// callback function to avoid that array_filter removes the value 0
	private function filterNumeric($value)
	{
		 return ($value !== null && $value !== false && $value !== '');
	}
}