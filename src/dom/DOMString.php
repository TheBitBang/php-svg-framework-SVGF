<?php

namespace b1t\dom;

/**
 * This class implements the type DOMString as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * It ensures UTF-16 encoding for strings.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/DOM-Level-3-Core/core.html#DOMString 
 */
 
class DOMString {
	 
	/** @var string $dom_string Representation of a string according to DOM specification */
	private $dom_string;
	
	/**
     * @param string|null $input_string Input string
     */
	public function __construct($input_string)
	{
		$this->setDOMString($input_string);
	}

	// set and get methods
	
	public function setDOMString($input_string)
	{
		$this->dom_string = mb_convert_encoding($input_string, "UTF-16", "auto");
	}

	public function getDOMString()
	{
		return $this->dom_string;
	}

 }