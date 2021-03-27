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

	public function setXMLBase($xml_base = '')
	{
		if (!array_key_exists('xml', $this->array_attributes_in_namespaces))
		{	// create namespace if it does not exists
			$this->array_attributes_in_namespaces['xml']= array();
		}
		$this->array_attributes_in_namespaces['xml'] = new DOMString($xml_base);
		$this->setAttribute('xml:base',$xml_base); // set attribute in DOM
	}

	public function getXMLBase()
	{
		return $this->array_attributes_in_namespaces['xml']->getDOMString(); // no need to check if it exists since it should always be set
	}
}