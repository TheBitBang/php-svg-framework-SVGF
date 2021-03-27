<?php

namespace b1t\svg;

use b1t\svgf\font\SVGFFont;

/**
 * SVGTextContentElement.php
 *
 * This class implements the interface SVGTextContentElement as described in Document Object Model (DOM) Level 3 Core Specification.
 * 
 * Note: it is assumed that the class using this trait extends SVGObject which in turn extends \DOMElement
 * 
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/text.html#InterfaceSVGTextContentElement
 */
 
trait SVGTextContentElement {

	use SVGElement;
	use SVGTests;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;

	// lengthAdjust Types (Traits cannot have constants)
	static $const_LENGTHADJUST_UNKNOWN = 0;
	static $const_LENGTHADJUST_SPACING = 1;
	static $const_LENGTHADJUST_SPACINGANDGLYPHS = 2;

	/** @var SVGAnimatedLengthList $textLength Corresponds to attribute 'textLength' on the given element. */
	private $textLength;
	
	/** @var SVGAnimatedEnumeration $lengthAdjust corresponds to attribute 'lengthAdjust' on the given element. The value must be one of the length adjust constants defined on this interface. */
	private $lengthAdjust;

	/**
	 * Returns the total number of characters available for rendering within the current element, which includes referenced characters from ‘tref’ reference, regardless of whether they will be rendered.
	 * Effectively, this is equivalent to the length of the Node::textContent attribute from DOM Level 3 Core ([DOM3], section 1.4), if that attribute also expanded ‘tref’ elements.
	 *
	 * @return long Total number of characters.
	 */	
	public function getNumberOfChars()
	{
		$this->textLength = strlen($this->textContent); // the value is updated only when this function is called
		return $this->textLength;
	}

	/**
	 * The total sum of all of the advance values from rendering all of the characters within this element, including the advance value on the glyphs (horizontal or vertical),
	 * the effect of properties ‘kerning’, ‘letter-spacing’ and ‘word-spacing’ and adjustments due to attributes ‘dx’ and ‘dy’ on ‘tspan’ elements.
	 * For non-rendering environments, the user agent shall make reasonable assumptions about glyph metrics.
	 *
	 * @return float The text advance distance.
	 */	
	public function getComputedTextLength()
	{
		// to-do: Untested function.
		// to-do: the effect of properties ‘kerning’, ‘letter-spacing’ and ‘word-spacing’ and adjustments due to attributes ‘dx’ and ‘dy’ on ‘tspan’ elements.
		$style_font_family = $this->style->getProperty('font-family'); // defined in SVGStylable
		$style_font_size =  $this->style->getProperty('font-size'); // defined in SVGStylable
		$bbox = imagettfbbox($style_font_size, 0, $style_font_family, $svg_text->nodeValue);
		
		$this->textLength = strlen($this->textContent); // the value is updated only when this function is called
		return $this->textLength;
	}

}