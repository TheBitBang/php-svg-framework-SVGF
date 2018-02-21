<?php

namespace b1t\svg;

use b1t\dom\DOMString;

/**
 * This class implements the interface SVGPathSeg as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathSeg
 */
 
class SVGPathSeg {

	// Path Segment Types
	const PATHSEG_UNKNOWN = 0;
	const PATHSEG_CLOSEPATH = 1;
	const PATHSEG_MOVETO_ABS = 2;
	const PATHSEG_MOVETO_REL = 3;
	const PATHSEG_LINETO_ABS = 4;
	const PATHSEG_LINETO_REL = 5;
	const PATHSEG_CURVETO_CUBIC_ABS = 6;
	const PATHSEG_CURVETO_CUBIC_REL = 7;
	const PATHSEG_CURVETO_QUADRATIC_ABS = 8;
	const PATHSEG_CURVETO_QUADRATIC_REL = 9;
	const PATHSEG_ARC_ABS = 10;
	const PATHSEG_ARC_REL = 11;
	const PATHSEG_LINETO_HORIZONTAL_ABS = 12;
	const PATHSEG_LINETO_HORIZONTAL_REL = 13;
	const PATHSEG_LINETO_VERTICAL_ABS = 14;
	const PATHSEG_LINETO_VERTICAL_REL = 15;
	const PATHSEG_CURVETO_CUBIC_SMOOTH_ABS = 16;
	const PATHSEG_CURVETO_CUBIC_SMOOTH_REL = 17;
	const PATHSEG_CURVETO_QUADRATIC_SMOOTH_ABS = 18;
	const PATHSEG_CURVETO_QUADRATIC_SMOOTH_REL = 19;

	/** @var readonly unsigned short $pathSegType The type of the path segment as specified by one of the constants defined on this interface. */
	protected $pathSegType;

	/** @var readonly DOMString $pathSegTypeAsLetter The type of the path segment, specified by the corresponding one character command name. */
	protected $pathSegTypeAsLetter;

	// get methods

	public function getPathSegType()
	{
		return $this->pathSegType;
	}

	public function getPathSegTypeAsLetter()
	{
		return $this->pathSegTypeAsLetter;
	}

}