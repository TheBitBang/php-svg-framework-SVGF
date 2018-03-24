<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an svg graphic object
 *
 * @author	J. Xavier Atero
 */
 
class SVGObjectBox {

	const ALIGN_CENTER = 0;
	const ALIGN_TOP = 1;
	const ALIGN_BOTTOM = 2;	
	const ALIGN_LEFT = 3;	
	const ALIGN_RIGHT = 4;
	const POSITION_TOP = 5;	
	const POSITION_BOTTOM = 6;	
	const POSITION_LEFT = 7;	
	const POSITION_RIGHT = 8;

	/** @var int $element_name Returns the name of the SVGObject node. */
	protected $element_name;

	/** @var int $xMin Leftmost point of the shape. */
	protected $xMin;

	/** @var int $xMax Rightmost point of the shape. */
	protected $xMax;

	/** @var int $yMin Lowest point of the shape. */
	protected $yMin;

	/** @var int $yMax Highest point of the shape. */
	protected $yMax;

	/** @var int $xCenter Horizontal center of the shape. */
	protected $xCenter;

	/** @var int $yCenter Vertical center of the shape. */
	protected $yCenter;

	/**
	 * Returns the value of the property.
	 *
	 * @param string $property_name The name of the attribute.
	 *
	 * @return value of the property.
	 *
	 * @throws Exception if the property does not exists in this class.
	 */	
	public function __get($property_name)
	{
		// to-do: verify that the property exists
		return $this->$property_name;
	}
	
	/**
	 * Recalculates all the coordinates to move the object to a new center
	 * 
	 * @param SVGObjectBox $refObjectBox The objectBox that will be used as a reference.
	 * @param int $type Type of alignment or positioning.
	 * @param float $hOffset Horizontal offset.
	 * @param float $vOffset Vertical offset.
	 */
	 public function moveTo ($refObjectBox, $type,  $hOffset = 0, $vOffset = 0) { 

		$xMinRef = $refObjectBox->xMin;
		$xMaxRef = $refObjectBox->xMax;
		$yMinRef = $refObjectBox->yMin;
		$yMaxRef = $refObjectBox->yMax;
		$xCenterRef = $refObjectBox->xCenter;
		$yCenterRef = $refObjectBox->yCenter;
				
		$xOffset = 0;
		$yOffset = 0;
		
		switch ($type) {
			case self::ALIGN_CENTER:
				$xOffset = $xCenterRef - $this->xCenter;
				$yOffset = $yCenterRef - $this->yCenter;
				break;
			case self::ALIGN_TOP:
				$yOffset = $xMinRef - $this->xMin;
				break;
			case self::ALIGN_BOTTOM:
				$yOffset = $yMaxRef - $this->yMax;			
				break;
			case self::ALIGN_LEFT:
				$xOffset = $xMinRef - $this->xMin;
				break;
			case self::ALIGN_RIGHT:
				$xOffset = $xMaxRef - $this->xMax;
				break;
			case self::POSITION_TOP:
				$yOffset = $yMinRef - $this->yMax;
				break;
			case self::POSITION_BOTTOM:
				$yOffset = $yMaxRef - $this->yMin;
				break;
			case self::POSITION_LEFT:
				$xOffset = $xMinRef - $this->xMax;
				break;
			case self::POSITION_RIGHT:
				$xOffset = $xMaxRef - $this->xMin;
				break;				
		}
		
		$this->xMin = $this->xMin + $xOffset + $hOffset;
		$this->xMax = $this->xMax + $xOffset + $hOffset;
		$this->xCenter = $this->xCenter + $xOffset + $hOffset;
		$this->yMin = $this->yMin + $yOffset + $vOffset;
		$this->yMax = $this->yMax + $yOffset + $vOffset;
		$this->yCenter = $this->yCenter + $yOffset + $vOffset;	
	 }
}