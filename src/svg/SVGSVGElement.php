<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGSVGElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/struct.html#InterfaceSVGSVGElement
 */
 
class SVGSVGElement extends SVGObject {

	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGLocatable;
	use SVGFitToViewBox;
	use SVGZoomAndPan;
//	use DocumentEvent;
//	use ViewCSS;
//	use DocumentCSS;

	/** @var SVGLength $x The x-axis coordinate of one corner of the rectangular region into which an embedded 'svg' element is placed. */
	private $x;
	
	/** @var SVGLength $y The y-axis coordinate of one corner of the rectangular region into which an embedded 'svg' element is placed. */
	private $y;

	/** @var SVGLength $width For outermost svg elements, the intrinsic width of the SVG document fragment. For embedded 'svg' elements, the width of the rectangular region into which the 'svg' element is placed. */
	private $width;
	
	/** @var SVGLength $height For outermost svg elements, the intrinsic height of the SVG document fragment. For embedded 'svg' elements, the height of the rectangular region into which the 'svg' element is placed. */	
	private $height;
	
	/** @var int $version (not in the specification of the class) Indicates the SVG language version to which this document fragment conforms. */	
	private $version;
	
	/** @var sting $viewBox The value of the 'viewBox' attribute is a list of four numbers <min-x>, <min-y>, <width> and <height>, separated by whitespace and/or a comma, which specify a rectangle in user space which should be mapped to the bounds of the viewport established by the given element, taking into account attribute 'preserveAspectRatio'.. */
	private $viewBox;

	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'svg');
	}
	
	// set and get methods

	public function setX($x)
	{
		// To do: verify format
		$this->x = $x;
		$this->setAttribute('x',$x); // set attribute in DOM
	}
	
	public function getX()
	{
		return $this->x;
	}
	
	public function setY($y)
	{
		// To do: verify format
		$this->y = $y;
		$this->setAttribute('y',$y); // set attribute in DOM		
	}
	
	public function getY()
	{
		return $this->y;
	}
	
	public function setWidth($width)
	{
		// To do: verify format
		$this->width = $width;
		$this->setAttribute('width',$width); // set attribute in DOM
	}
	
	public function getWidth()
	{
		return $this->width;

	}

	public function setHeight($height)
	{
		// To do: verify format
		$this->height = $height;
		$this->setAttribute('height',$height); // set attribute in DOM
	}
	
	public function getHeight()
	{
		return $this->height;
	}

	public function setVersion($version)
	{
		$this->version = $version;
		$this->setAttribute('version',$version); // set attribute in DOM
	}
	
	public function getVersion()
	{
		return $this->version;
	}
	
	public function setViewBox($viewBox)
	{
		// To do: verify format
		$this->viewBox = $viewBox;
		$this->setAttribute('viewBox',$viewBox); // set attribute in DOM
	}
	
	public function getViewBox()
	{
		return $this->viewBox;
	}	
}