<?php

namespace b1t\svg;

/**
 * This class implements the interface SVGPointList as described in Document Object Model (DOM) Level 3 Core Specification.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG/coords.html#InterfaceSVGPointList
 */
 
trait SVGPointList {
	
	/** @var unsigned long $numberOfItems The number of items in the list. */
	private int $numberOfItems;
	
	// set and get methods
	
	public function setNumberOfItems(int $numberOfItems)
	{
		$this->numberOfItems = $numberOfItems;
	}
	
	public function getNumberOfItems()
	{
		return $this->numberOfItems;
	}

}