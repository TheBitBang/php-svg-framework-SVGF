<?php

namespace b1t\svgf\xsvg;

use b1t\svg\SVGPathSegClosePath;
use b1t\svg\SVGPathSegMovetoAbs;
use b1t\svg\SVGPathSegMovetoRel;
use b1t\svg\SVGPathSegLinetoAbs;
use b1t\svg\SVGPathSegLinetoRel;
use b1t\svg\SVGPathSegCurvetoCubicAbs;
use b1t\svg\SVGPathSegCurvetoCubicRel;
use b1t\svg\SVGPathSegArcAbs;
use b1t\svg\SVGPathSegArcRel;
use b1t\svg\SVGPathSegLinetoHorizontalAbs;
use b1t\svg\SVGPathSegLinetoHorizontalRel;
use b1t\svg\SVGPathSegLinetoVerticalAbs;
use b1t\svg\SVGPathSegLinetoVerticalRel;
use b1t\svg\SVGPathSegCurvetoQuadraticSmoothAbs;
use b1t\svg\SVGPathSegCurvetoQuadraticSmoothRel;

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
			$segTypeAsLetter = $command->getPathSegTypeAsLetter();
			$segData = ($segTypeAsLetter == 'z') ? '' :  $command->getData();
			$path_data = $path_data . $segTypeAsLetter . ' ' . $segData . ' ' ;
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

		// split in path segments
		$array_commands = preg_split('/([M|m|L|l|H|h|V|v|C|c|S|s|Q|q|T|t|A|a][$n+, ]+|[Z|z][ ]*)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		for ($i=0;$i<count($array_commands);$i++) {
			$pathSegType = trim($array_commands[$i]);
			switch ($pathSegType){
				case 'M':
				case 'm':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegM($pathSegType,$pathSegData);
					break;
				case 'Z':
				case 'z':
					$this->array_path_data[] = new SVGPathSegClosePath();
					break;
				case 'L':
				case 'l':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegL($pathSegType,$pathSegData);
					break;
				case 'H':
				case 'h':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegH($pathSegType,$pathSegData);
					break;
				case 'V':
				case 'v':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegV($pathSegType,$pathSegData);
					break;
				case 'C':
				case 'c':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegC($pathSegType,$pathSegData);
					break;
				case 'S':
				case 's':
				case 'Q':
				case 'q':
					break;
				case 'T':
				case 't':
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegL($pathSegType,$pathSegData);
					break;
				case 'A':
				case 'a':
					$i++;
					$pathSegData = trim($array_commands[$i]);
					$this->processPathSegA($pathSegType,$pathSegData);
					break;
			}
		}
	}

	private function processPathSegM($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// the first value corresponds to an M or m
		if ($pathSegType == 'M') {
			$pathSeg = new SVGPathSegMovetoAbs();
		} else { // 'm'
			$pathSeg = new SVGPathSegMovetoRel();
		}
		$pathSeg->setData($array_values[0]);
		$this->array_path_data[] = $pathSeg;

		// the next values correspond to L or l (non-visible)
		for ($i=1;$i<count($array_values);$i++) {
			if ($pathSegType == 'M') {
				$pathSeg = new SVGPathSegLinetoAbs();
			} else { // 'm'
				$pathSeg = new SVGPathSegLinetoRel();
			}
			$pathSeg->setData($array_values[$i]);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegL($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i++) {
			if ($pathSegType == 'L') {
				$pathSeg = new SVGPathSegLinetoAbs();
			} else { // 'l'
				$pathSeg = new SVGPathSegLinetoRel();
			}
			$pathSeg->setData($array_values[$i]);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegH($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i++) {
			if ($pathSegType == 'H') {
				$pathSeg = new SVGPathSegLinetoHorizontalAbs();
			} else { // 'h'
				$pathSeg = new SVGPathSegLinetoHorizontalRel();
			}
			$pathSeg->setData($array_values[$i]);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegV($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i++) {
			if ($pathSegType == 'V') {
				$pathSeg = new SVGPathSegLinetoVerticalAbs();
			} else { // 'v'
				$pathSeg = new SVGPathSegLinetoVerticalRel();
			}
			$pathSeg->setData($array_values[$i]);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegC($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i=$i+3) {
			$data = $array_values[$i] . ' ' . $array_values[$i+1] . ' ' . $array_values[$i+2] . ' ';
			if ($pathSegType == 'C') {
				$pathSeg = new SVGPathSegCurvetoCubicAbs();
			} else { // 'c'
				$pathSeg = new SVGPathSegCurvetoCubicRel();
			}
			$pathSeg->setData($data);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegT($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i++) {
			if ($pathSegType == 'T') {
				$pathSeg = new SVGPathSegCurvetoQuadraticSmoothAbs();
			} else { // 't'
				$pathSeg = new SVGPathSegCurvetoQuadraticSmoothRel();
			}
			$pathSeg->setData($array_values[$i]);
			$this->array_path_data[] = $pathSeg;
		}
	}

	private function processPathSegA($pathSegType, $pathSegData)
	{
		// split in path segments
		$array_values = array_values(array_filter(explode(' ',$pathSegData),'self::filterNumeric'));

		// create path segments
		for ($i=0;$i<count($array_values);$i=$i+5) {
			$data = $array_values[$i] . ' ' . $array_values[$i+1] . ' ' . $array_values[$i+2] . ' ' . $array_values[$i+3] . ' ' . $array_values[$i+4] . ' ';
			if ($pathSegType == 'A') {
				$pathSeg = new SVGPathSegArcAbs();
			} else { // 'a'
				$pathSeg = new SVGPathSegArcRel();
			}
			$pathSeg->setData($data);
			$this->array_path_data[] = $pathSeg;
		}
	}

	// callback function to avoid that array_filter removes the value 0
	private function filterNumeric($value)
	{
		 return ($value !== null && $value !== false && $value !== '');
	}
}