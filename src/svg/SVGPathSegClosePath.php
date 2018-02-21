<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the Interface SVGPathSegClosePath Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathSegClosePath
 */
 
class SVGPathSegClosePath extends SVGPathSeg {

	public function __construct()
	{
		$this->pathSegType = self::PATHSEG_CLOSEPATH;
		$this->pathSegTypeAsLetter = 'z';
	}
}