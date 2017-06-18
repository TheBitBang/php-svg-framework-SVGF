<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGRectElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/shapes.html#InterfaceSVGRectElement
 */
 
class SVGRectElement extends SVGObject {
	
	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;
	
	/** @var SVGLength $x The x-axis coordinate of one corner of the rectangular region into which an embedded 'svg' element is placed. */
	private $x;
	
	/** @var SVGLength $y The y-axis coordinate of one corner of the rectangular region into which an embedded 'svg' element is placed. */
	private $y;

	/** @var SVGLength $width For outermost svg elements, the intrinsic width of the SVG document fragment. For embedded 'svg' elements, the width of the rectangular region into which the 'svg' element is placed. */
	private $width;
	
	/** @var SVGLength $height For outermost svg elements, the intrinsic height of the SVG document fragment. For embedded 'svg' elements, the height of the rectangular region into which the 'svg' element is placed. */	
	private $height;
	
	/** @var SVGLength $rx For rounded rectangles, the x-axis radius of the ellipse used to round off the corners of the rectangle. */
	private $rx;
	
	/** @var SVGLength $ry For rounded rectangles, the y-axis radius of the ellipse used to round off the corners of the rectangle. */
	private $ry;	
	
	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'rect');
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

	public function setRx($rx)
	{
		// To do: verify format
		$this->rx = $rx;
		$this->setAttribute('rx',$rx); // set attribute in DOM
	}
	
	public function getRx()
	{
		return $this->rx;
	}
	
	public function setRy($ry)
	{
		// To do: verify format
		$this->ry = $ry;
		$this->setAttribute('ry',$ry); // set attribute in DOM
	}
	
	public function getRy()
	{
		return $this->ry;
	}
}