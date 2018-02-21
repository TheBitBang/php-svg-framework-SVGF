<?php

namespace b1t\svgf\utils;

use b1t\svg\SVGGElement;
use b1t\svg\SVGPathElement;
use b1t\svg\SVGPathSeg;
use b1t\svg\SVGPathSegMovetoAbs;
use b1t\svgf\xsvg\SVGPathData;


/**
 * This class provides functionality to manipulate the d attribute of the SVGPathElement.
 *
 * @author	J. Xavier Atero
 */
 
class SVGPathDataUtils {


	public static function splitPathInPaths($dom_doc_svg, SVGPathElement $svg_path)
	{

		// initializations
		$i_d = '';
		$x_abs = '0';
		$y_abs = '0';

		// get path data
		$svg_g = new SVGGElement($dom_doc_svg); // create a group
		$d = $svg_path->getD(); // get path data from path element
		$path_data = new SVGPathData($d); // create path data object
		$array_commands = $path_data->getPathdataArray(); // get array with path data commands

		// process path data
		foreach($array_commands as $command) {
			$segTypeAsLetter = $command->getPathSegTypeAsLetter();
			$segData = ($segTypeAsLetter == 'z') ? '' :  $command->getData();
			if ($segTypeAsLetter == 'M' || $segTypeAsLetter == 'm') {
				if ($i_d != '') {
					$svg_path_new = clone $svg_path; // create new path data
					$svg_path_new->setD($i_d);
					$svg_g->appendChild($svg_path_new);
					if ($segTypeAsLetter == 'm') {
						$pathSeg = new SVGPathSegMovetoAbs();
						$x = $command->getX();
						$y = $command->getY();
						$pathSeg->setX($x + $x_abs);
						$pathSeg->setY($y + $y_abs);
						$segTypeAsLetter = $pathSeg->getPathSegTypeAsLetter();
						$segData = $pathSeg->getData();
					}
				}
				$i_d = $segTypeAsLetter . ' ' . $segData;
			} else {
				$i_d = $i_d . ' ' . $segTypeAsLetter . ' ' . $segData; // add to path
			}

			// trace absolute coordinates
			if ($command->getPathSegTypeAsLetter() != 'z') {
				if ($command->getPathSegType() % 2 == 0) { // is absolute 
					if ($command->getPathSegTypeAsLetter() != 'V') {
						$x_abs = $command->getX();
					}
					if ($command->getPathSegTypeAsLetter() != 'H') {
						$y_abs = $command->getY();
					}
				} else {
					if ($command->getPathSegTypeAsLetter() != 'v') {
						$x_abs = $x_abs + $command->getX();
					}
					if ($command->getPathSegTypeAsLetter() != 'h') {
						$y_abs = $y_abs + $command->getY();
					}
				}
			}
		}

		// last iteration
		$svg_path_new = clone $svg_path; // create new path data
		$svg_path_new->setD($i_d);
		$svg_g->appendChild($svg_path_new);

		return $svg_g;
	}

}