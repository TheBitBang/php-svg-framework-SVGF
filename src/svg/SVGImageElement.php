<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGImageElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/struct.html#InterfaceSVGImageElement
 */
 
class SVGImageElement extends SVGObject {

	use SVGElement;
	use SVGURIReference;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGTransformable;

	/** @var readonly SVGAnimatedLength $x Corresponds to attribute ‘x’ on the given ‘image’ element. */
	private $x;

	/** @var readonly SVGAnimatedLength $y Corresponds to attribute ‘y’ on the given ‘image’ element. */
	private $y;

	/** @var readonly SVGAnimatedLength $width Corresponds to attribute ‘width’ on the given ‘image’ element. */
	private $width;

	/** @var readonly SVGAnimatedLength $height Corresponds to attribute ‘height’ on the given ‘image’ element. */
	private $height;

	/** @var readonly SVGAnimatedLength $preserveAspectRatio Corresponds to attribute ‘preserveAspectRatio’ on the given ‘image’ element. */
	private $preserveAspectRatio;

	public function __construct($dom_doc_svg)
	{
		parent::__construct($dom_doc_svg,'image');
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

	public function setPreserveAspectRatio($preserveAspectRatio)
	{
		// To do: verify format
		$this->preserveAspectRatio = $preserveAspectRatio;
		$this->setAttribute('preserveAspectRatio',$preserveAspectRatio); // set attribute in DOM
	}

	public function getPreserveAspectRatio()
	{
		return $this->preserveAspectRatio;
	}

}