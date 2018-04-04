<?php

/**
 * SVGTextElementTest.php
 *
 * @author	J. Xavier Atero
 */

require realpath(__DIR__ . '/../../..' . '/vendor/autoload.php');

use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svgf\SVGFElement;

class SVGTextElementTest extends \PHPUnit_Framework_TestCase {

	private $dom_doc_svg;
	private $svg_svg;

	protected function setUp()
	{
		$this->dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
		$this->svg_svg = SVGFElement::svg($this->dom_doc_svg,'a4',SVGFElement::SIZE_A4);
	}

	public function testGetNumberOfChars()
	{
		$svg_text = new SVGTextElement($this->dom_doc_svg);
		$svg_text->nodeValue = '0123456789';
		$result = $svg_text->getNumberOfChars();
		$this->assertEquals(10, $result);
	}

	public function testGetNumberOfCharsTspan()
	{
		$svg_text = new SVGTextElement($this->dom_doc_svg);
		$svg_text->nodeValue = '0123456789';
		$svg_tspan = new SVGTSpanElement($this->dom_doc_svg);
		$svg_tspan->nodeValue = '0 2 4 6 8';
		$svg_text->appendChild($svg_tspan);
		$result = $svg_text->getNumberOfChars();
		$this->assertEquals(19, $result);
	}

}