<?php

/**
 * SVGTextElementTest.php
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../../../..' . '/vendor/autoload.php');

use b1t\svgf\xsvg\SVGPathData;

class SVGPathDataTest extends \PHPUnit_Framework_TestCase {


	public function testMovetoClosepath()
	{
		$str_path_data = "M 0,0 z";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data, $result);
	}

	public function testRelativeMovetoClosepath()
	{
		$str_path_data = "m 0,0 z";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data, $result);
	}

	public function testMovetoWithLineto()
	{
		$str_path_data = "M 0,0 1,1 2,2";
		$str_path_data_result = "M 0,0 L 1,1 L 2,2";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data_result, $result);
	}

	public function testMovetoDifferentNumericValues()
	{
		$str_path_data = "M -3.45,66.98 L 0,0.0";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data, $result);
	}

	public function testAdditionalSpaces()
	{
		$str_path_data = " M -3.45,66.98   0,0.0  z  ";
		$str_path_data_result = "M -3.45,66.98 L 0,0.0 z";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data_result, $result);
	}

	public function testExample001()
	{
		$str_path_data = "m 317.83322,290.31493 c -3.09261,0.28115 11.35121,11.88244 49.86328,42.81836 l 123.23828,98.9961 -195.9707,-56.57032 C 529.31947,488.69615 531.33984,609.91604 529.31954,488.69774 527.29923,367.47944 678.82249,401.82417 523.259,367.47899 416.3091,343.86668 324.63695,289.69641 317.83322,290.31493 Z M 208.09103,446.27001 193.94845,613.95556 363.65548,557.3872 c 169.70563,-56.56854 54.5478,-10.10123 -121.21875,-26.26367 l -34.3457,-84.85352 z m 317.1875,177.78711 -292.94336,8.08203 292.94336,-8.08203 z M 476.7922,696.78759 608.11251,981.65087 476.7922,696.78759 Z";
		$str_path_data_result = "m 317.83322,290.31493 c -3.09261,0.28115 11.35121,11.88244 49.86328,42.81836 l 123.23828,98.9961 l -195.9707,-56.57032 C 529.31947,488.69615 531.33984,609.91604 529.31954,488.69774 C 527.29923,367.47944 678.82249,401.82417 523.259,367.47899 C 416.3091,343.86668 324.63695,289.69641 317.83322,290.31493 z  M 208.09103,446.27001 L 193.94845,613.95556 L 363.65548,557.3872 c 169.70563,-56.56854 54.5478,-10.10123 -121.21875,-26.26367 l -34.3457,-84.85352 z  m 317.1875,177.78711 l -292.94336,8.08203 l 292.94336,-8.08203 z  M 476.7922,696.78759 L 608.11251,981.65087 L 476.7922,696.78759 z";
		$path_data = new SVGPathData($str_path_data);
		$result = $path_data->getPathData();
		$this->assertEquals($str_path_data_result, $result);
	}

	public function testExceptionMovetoWrongSyntax()
	{
		$this->expectException(\Exception::class);
		$str_path_data = "m 317.83322,290.31493 4 Z";
		$path_data = new SVGPathData($str_path_data);
	}

	public function testExceptionMovetoNotNumeric()
	{
		$this->expectException(\Exception::class);
		$str_path_data = "m 317.83a22,290 Z";
		$path_data = new SVGPathData($str_path_data);
	}
}