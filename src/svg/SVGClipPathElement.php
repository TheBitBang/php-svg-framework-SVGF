<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGPathElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	http://www.w3.org/TR/SVG/paths.html#InterfaceSVGPathElement
 */
 
class SVGPathElement extends SVGObject {
	
	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;
	use SVGUnitTypes;
	
	/** @var PathData $d The definition of the outline of a shape. */
	private $d;

	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'path');
	}

	// set and get methods
	
	public function setD($d = '')
	{
		// To do: make this a PathData
		$this->d = $d;
		$this->setAttribute('d',$d); // set attribute in DOM
	}
	
	public function getD()
	{
		return $this->d;
	}
	
}