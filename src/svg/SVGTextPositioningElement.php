<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGTextPositioningElement as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/text.html#InterfaceSVGTextPositioningElement
 */
 
trait SVGTextPositioningElement {

	use SVGTextContentElement;

	/** @var SVGAnimatedLengthList $x Corresponds to attribute 'x' on the given element. */
	private $x;

	/** @var SVGAnimatedLengthList $y Corresponds to attribute 'y' on the given element. */
	private $y;

	/** @var SVGAnimatedLengthList $dx Corresponds to attribute 'dx' on the given element. */
	private $dx;

	/** @var SVGAnimatedLengthList $dy Corresponds to attribute 'dx' on the given element. */
	private $dy;

	/** @var SVGAnimatedLengthList $rotate Corresponds to attribute 'rotate' on the given element. */
	private $rotate;

	// set and get methods

	public function setX($x)
	{
		// to-do: SVGAnimatedLengthList
		$this->x = $x;
		$this->setAttribute('x',$x); // set attribute in DOM
	}

	public function getX()
	{
		return $this->x;
	}

	public function setY($y)
	{
		// to-do: SVGAnimatedLengthList
		$this->y = $y;
		$this->setAttribute('y',$y); // set attribute in DOM
	}

	public function getY()
	{
		return $this->y;
	}

	public function setDx($dx)
	{
		// to-do: SVGAnimatedLengthList
		$this->dx = $dx;
		$this->setAttribute('dx',$dx); // set attribute in DOM
	}

	public function getDx()
	{
		return $this->dx;
	}

	public function setDy($dy)
	{
		// to-do: SVGAnimatedLengthList
		$this->dy = $dy;
		$this->setAttribute('dy',$dy); // set attribute in DOM
	}

	public function getDy()
	{
		return $this->dy;
	}

	public function setRotate($rotate)
	{
		// to-do: SVGAnimatedLengthList
		$this->rotate = $rotate;
		$this->setAttribute('rotate',$rotate); // set attribute in DOM
	}

	public function getRotate()
	{
		return $this->rotate;
	}
}