<?php

namespace b1t\svgf\geometry;

use b1t\svg\SVGObject;

/**
 * This class represents the box containing an svg graphic object
 *
 * @author	J. Xavier Atero
 */
 
class SVGFObjectBox {

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

	/** @var int $x_min Leftmost point of the shape. */
	protected $x_min;

	/** @var int $x_max Rightmost point of the shape. */
	protected $x_max;

	/** @var int $y_min Lowest point of the shape. */
	protected $y_min;

	/** @var int $y_max Highest point of the shape. */
	protected $y_max;

	/** @var int $x_center Horizontal center of the shape. */
	protected $x_center;

	/** @var int $y_center Vertical center of the shape. */
	protected $y_center;

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
	 * @param SVGFObjectBox $ref_objectbox The objectBox that will be used as a reference.
	 * @param int $type Type of alignment or positioning.
	 * @param float $h_offset Horizontal offset.
	 * @param float $v_offset Vertical offset.
	 */
	 public function moveTo ($ref_objectbox, $type,  $h_offset = 0, $v_offset = 0) { 

		$x_min_ref = $ref_objectbox->x_min;
		$x_max_ref = $ref_objectbox->x_max;
		$y_min_ref = $ref_objectbox->y_min;
		$y_max_ref = $ref_objectbox->y_max;
		$x_center_ref = $ref_objectbox->x_center;
		$y_center_ref = $ref_objectbox->y_center;
		$x_offset = 0;
		$y_offset = 0;
		
		switch ($type) {
			case self::ALIGN_CENTER:
				$x_offset = $x_center_ref - $this->x_center;
				$y_offset = $y_center_ref - $this->y_center;
				break;
			case self::ALIGN_TOP:
				$y_offset = $y_min_ref - $this->y_min;
				break;
			case self::ALIGN_BOTTOM:
				$y_offset = $y_max_ref - $this->y_max;
				break;
			case self::ALIGN_LEFT:
				$x_offset = $x_min_ref - $this->x_min;
				break;
			case self::ALIGN_RIGHT:
				$x_offset = $x_max_ref - $this->x_max;
				break;
			case self::POSITION_TOP:
				$y_offset = $y_min_ref - $this->y_max;
				break;
			case self::POSITION_BOTTOM:
				$y_offset = $y_max_ref - $this->y_min;
				break;
			case self::POSITION_LEFT:
				$x_offset = $x_min_ref - $this->x_max;
				break;
			case self::POSITION_RIGHT:
				$x_offset = $x_max_ref - $this->x_min;
				break;
		}

		$this->x_min = $this->x_min + $x_offset + $h_offset;
		$this->x_max = $this->x_max + $x_offset + $h_offset;
		$this->x_center = $this->x_center + $x_offset + $h_offset;
		$this->y_min = $this->y_min + $y_offset + $v_offset;
		$this->y_max = $this->y_max + $y_offset + $v_offset;
		$this->y_center = $this->y_center + $y_offset + $v_offset;
	 }
}