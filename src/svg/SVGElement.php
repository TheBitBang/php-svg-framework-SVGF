<?php

namespace b1t\svg;

use b1t\dom\DOMString;

/**
 * This class implements the interface SVGElement as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/types.html#InterfaceSVGElement
 */
 
trait SVGElement {

	/** @var DOMString $id The value of the 'id' attribute on the given element, or the empty string if 'id' is not present. */
	private $id;

	// set and get methods

	public function setId($id = '')
	{
		$this->id = new DOMString($id);
		$this->setAttribute('id',$id); // set attribute in DOM
	}

	public function getId()
	{
		return $this->id->getDOMString();
	}

}