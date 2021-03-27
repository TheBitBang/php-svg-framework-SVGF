<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGTests as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	http://www.w3.org/TR/SVG11/types.html#InterfaceSVGTests
 */
 
trait SVGTests {
	
	/** @var SVGStringList $requiredFeatures Corresponds to attribute 'requiredFeatures' on the given element. */
	private $requiredFeatures;

	/** @var SVGStringList $requiredExtensions Corresponds to attribute 'requiredExtensions' on the given element. */
	private $requiredExtensions;

	/** @var SVGStringList $systemLanguage Corresponds to attribute 'systemLanguage' on the given element. */
	private $systemLanguage;
	
	// set and get methods

	public function setRequiredFeatures($requiredFeatures)
	{
		// To do: SVGStringList
		$this->requiredFeatures = $requiredFeatures;
		$this->setAttribute('requiredFeatures',$requiredFeatures); // set attribute in DOM
	}
	
	public function getRequiredFeatures()
	{
		return $this->requiredFeatures;
	}

	public function setRequiredExtensions($requiredExtensions)
	{
		// To do: SVGStringList
		$this->requiredExtensions = $requiredExtensions;
		$this->setAttribute('requiredExtensions',$requiredExtensions); // set attribute in DOM
	}
	
	public function getRequiredExtensions()
	{
		return $this->requiredExtensions;
	}

	public function setSystemLanguage($systemLanguage)
	{
		// To do: SVGStringList
		$this->systemLanguage = $systemLanguage;
		$this->setAttribute('systemLanguage',$systemLanguage); // set attribute in DOM
	}
	
	public function getSystemLanguage()
	{
		return $this->systemLanguage;
	}

}