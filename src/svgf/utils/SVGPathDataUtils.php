<?php

namespace b1t\svgf\utils;

use b1t\svg\SVGGElement;
use b1t\svg\SVGPathElement;
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
			$command->makeVisible(); // to simplify the calculations. This way only Moveto command needs to be changed to absolute coordinates
			$commandType = $command->getCommandType();
			if ($commandType == 'M' || $commandType == 'm') {
				if ($i_d != '') {
					$svg_path_new = clone $svg_path; // create new path data
					$svg_path_new->setD($i_d);
					$svg_g->appendChild($svg_path_new);
				}
				$command->makeAbsoulte($x_abs,$y_abs); // make the start of the new path absolute
				$i_d = $command->getCommand();
			} else {
				$i_d = $i_d . ' ' . $command->getCommand(); // add to path
			}

			// trace absolute coordinates
			if ($command->getCommandType() != 'Z' && $command->getCommandType() != 'z') {
				if ($command->isAbsolute()) {
					if ($command->getCommandType() != 'V' && $command->getCommandType() != 'v') {
						$x_abs = $command->getX();
					}
					if ($command->getCommandType() != 'H' && $command->getCommandType() != 'h') {
						$y_abs = $command->getY();
					}
				} else {
					if ($command->getCommandType() != 'V' && $command->getCommandType() != 'v') {
						$x_abs = $x_abs + $command->getX();
					}
					if ($command->getCommandType() != 'H' && $command->getCommandType() != 'h') {
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