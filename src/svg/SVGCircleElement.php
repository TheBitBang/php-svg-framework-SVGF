<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGCircleElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	http://www.w3.org/TR/SVG/shapes.html#InterfaceSVGCircleElement
 */
 
class SVGCircleElement extends SVGObject {

	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;
	
	/** @var SVGAnimatedLength $cx Corresponds to attribute 'cx' on the given 'circle' element. */
	private $cx;

	/** @var SVGAnimatedLength $cy Corresponds to attribute 'cy' on the given 'circle' element. */
	private $cy;

	/** @var SVGAnimatedLength $r Corresponds to attribute 'r' on the given 'circle' element. */
	private $r;
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'circle');
	}

	// set and get methods

	public function setCx($cx)
	{
		// To do: verify format
		$this->cx = $cx;
		$this->setAttribute('cx',$cx); // set attribute in DOM
	}
	
	public function getCx()
	{
		return $this->cx;
	}

	public function setCy($cy)
	{
		// To do: verify format
		$this->cy = $cy;
		$this->setAttribute('cy',$cy); // set attribute in DOM
	}
	
	public function getCy()
	{
		return $this->cy;
	}

	public function setR($r)
	{
		// To do: verify format
		$this->r = $r;
		$this->setAttribute('r',$r); // set attribute in DOM
	}
	
	public function getR()
	{
		return $this->r;
	}
}