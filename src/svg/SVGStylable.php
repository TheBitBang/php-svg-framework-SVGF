<?php

namespace b1t\svg;

// use b1t\svg\SVGAnimatedString;
use b1t\css\CSSStyleDeclaration;

/**
 * This class implements the interface SVGStylable as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/types.html#InterfaceSVGStylable
 */
 
trait SVGStylable {
	
	/** @var SVGAnimatedString $className Corresponds to attribute 'class' on the given element. */
	private $className;

	/** @var CSSStyleDeclaration $style Corresponds to attribute 'style' on the given element. If the user agent does not support styling with CSS, then this attribute must always have the value of null. */
	private $style;

	// set and get methods
	
	public function setClass($className = '')
	{
		// To do: make this a SVGAnimatedString
		$this->className = $className;
		$this->setAttribute('class',$className); // set attribute in DOM		
	}
	
	public function getClass()
	{
		return $this->className;
	}

	public function setStyle(CSSStyleDeclaration $style = null)
	{
		$css = new CSSStyleDeclaration($this); // create a new instance of CSSStyleDeclaration associated to this object
		if(!is_null($style)){$css->cssText = $style->cssText;} // copy the information to the created CSSStyleDeclaration
		$this->style = $css;
		if($this->style->cssText != ''){$this->setAttribute('style',$this->style->cssText);}
	}
	
	public function getStyle()
	{
		if($this->style->cssText != ''){$this->setAttribute('style',$this->style->cssText);} // set attribute in DOM
		return $this->style;
	}

}