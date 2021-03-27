<?php

namespace b1t\svg;

/**
 * This class contains the implementation for the SVGMarkerElement Interface.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/SVG11/painting.html#InterfaceSVGMarkerElement
 */
 
class SVGMarkerElement extends SVGObject {

	use SVGElement;
	use SVGLangSpace;
	use SVGExternalResourcesRequired;
	use SVGStylable;
	use SVGFitToViewBox;

	// Marker Unit Types
	const SVG_MARKERUNITS_UNKNOWN = 0;
	const SVG_MARKERUNITS_USERSPACEONUSE = 1;
	const SVG_MARKERUNITS_STROKEWIDTH = 2;

	// Marker Orientation Types
	const SVG_MARKER_ORIENT_UNKNOWN = 0;
	const SVG_MARKER_ORIENT_AUTO = 1;
	const SVG_MARKER_ORIENT_ANGLE = 2;

	/** @var SVGAnimatedLength $refX Corresponds to attribute 'refX' on the given 'marker' element. */
	private $refX;

	/** @var SVGAnimatedLength $refY Corresponds to attribute 'refY' on the given 'marker' element. */
	private $refY;

	/** @var SVGAnimatedEnumeration $markerUnits Corresponds to attribute 'markerUnits' on the given 'marker' element. One of the Marker Unit Types defined on this interface. */
	private $markerUnits;

	/** @var SVGAnimatedLength $markerWidth Corresponds to attribute 'markerWidth' on the given 'marker' element. */
	private $markerWidth;

	/** @var SVGAnimatedLength $markerHeight Corresponds to attribute 'markerHeight' on the given 'marker' element. */
	private $markerHeight;

	/** @var SVGAnimatedEnumeration $orientType Corresponds to attribute 'orient' on the given 'marker' element. One of the Marker Unit Types defined on this interface. */
	private $orientType;

	/** @var SVGAnimatedAngle $orientAngle Corresponds to attribute 'orient' on the given 'marker' element. If markerUnits is SVG_MARKER_ORIENT_ANGLE, the angle value for attribute 'orient'; otherwise, it will be set to zero. */
	private $orientAngle;

	public function __construct($dom_doc_svg)
	{
		// create the objects
		$this->markerUnits = new SVGAnimatedEnumeration(); 
		$this->orientType = new SVGAnimatedEnumeration();
		
		// set the default values
		$this->markerUnits->setBaseVal(self::SVG_MARKERUNITS_UNKNOWN);
		$this->orientType->setBaseVal(self::SVG_MARKER_ORIENT_UNKNOWN);
		
		parent::__construct($dom_doc_svg,'marker');
	}

	// set and get methods

	public function setRefX($refX)
	{
		// allow the input parameter to have different types
		if (gettype($refX) == 'object' )
		{
			if (get_class($refX) != 'b1t\svg\SVGAnimatedLength')
			{
				throw new Exception('Wrong object class. Expected class: b1t\svg\SVGAnimatedLength');
			}
		} 
		else // convert input parameter to proper type
		{
			$ref_x = new SVGAnimatedLength();
			$ref_x->setBaseVal($refX);
			$refX = $ref_x;
		}
		
		$this->refX = $refX;
		$this->setAttribute('refX',$refX->getBaseVal()); // set attribute in DOM
	}

	public function getRefX()
	{
		return $this->refX->getBaseVal();
	}

	public function setRefY($refY)
	{
		// allow the input parameter to have different types
		if (gettype($refY) == 'object' )
		{
			if (get_class($refY) != 'b1t\svg\SVGAnimatedLength')
			{
				throw new Exception('Wrong object class. Expected class: b1t\svg\SVGAnimatedLength');
			}
		} 
		else // convert input parameter to proper type
		{
			$ref_y = new SVGAnimatedLength();
			$ref_y->setBaseVal($refY);
			$refY = $ref_y;
		}
		
		$this->refY = $refY;
		$this->setAttribute('refY',$refY->getBaseVal()); // set attribute in DOM
	}

	public function getRefY()
	{
		return $this->refY->getBaseVal();
	}

	public function setMarkerUnits(SVGAnimatedEnumeration $markerUnits)
	{
		$this->markerUnits = $markerUnits;

		$markerUnitsAttributeValue = null;
		switch ($this->markerUnits->getBaseVal()) 
		{
			case self::SVG_MARKERUNITS_STROKEWIDTH:
				$markerUnitsAttributeValue = 'strokeWidth';
				break;
			case self::SVG_MARKERUNITS_USERSPACEONUSE:
				$markerUnitsAttributeValue = 'userSpaceOnUse';
				break;
		}
		$this->setAttribute('markerUnits',$markerUnitsAttributeValue); // set attribute in DOM
	}

	public function getMarkerUnits()
	{
		$markerUnits = null;

		switch ($this->markerUnits->getBaseVal()) 
		{
			case self::SVG_MARKERUNITS_STROKEWIDTH:
				$markerUnits = 'strokeWidth';
				break;
			case self::SVG_MARKERUNITS_USERSPACEONUSE:
				$markerUnits = 'userSpaceOnUse';
				break;
		}

		return $markerUnits;
	}

	public function setMarkerWidth($markerWidth)
	{
		// allow the input parameter to have different types
		if (gettype($markerWidth) == 'object' )
		{
			if (get_class($markerWidth) != 'b1t\svg\SVGAnimatedLength')
			{
				throw new Exception('Wrong object class. Expected class: b1t\svg\SVGAnimatedLength');
			}
		} 
		else // convert input parameter to proper type
		{
			$marker_width = new SVGAnimatedLength();
			$marker_width->setBaseVal($markerWidth);
			$markerWidth = $marker_width;
		}
		
		$this->markerWidth = $markerWidth;
		$this->setAttribute('markerWidth',$markerWidth->getBaseVal()); // set attribute in DOM
	}

	public function getMarkerWidth()
	{
		return $this->markerWidth->getBaseVal();
	}

	public function setMarkerHeight($markerHeight)
	{
		// allow the input parameter to have different types
		if (gettype($markerHeight) == 'object' )
		{
			if (get_class($markerHeight) != 'b1t\svg\SVGAnimatedLength')
			{
				throw new Exception('Wrong object class. Expected class: b1t\svg\SVGAnimatedLength');
			}
		} 
		else // convert input parameter to proper type
		{
			$marker_height = new SVGAnimatedLength();
			$marker_height->setBaseVal($markerHeight);
			$markerHeight = $marker_height;
		}
		
		$this->markerHeight = $markerHeight;
		$this->setAttribute('markerHeight',$markerHeight->getBaseVal()); // set attribute in DOM
	}

	public function getMarkerHeight()
	{
		return $this->markerHeight->getBaseVal();
	}

	public function getOrientType()
	{
		return $this->orientType;
	}

	public function getOrientAngle()
	{
		return $this->orientAngle;
	}

	public function setOrientToAuto()
	{
		$this->setAttribute('orient','auto'); // set attribute in DOM
		$this->orientType->setBaseVal(self::SVG_MARKER_ORIENT_AUTO);
	}

	public function setOrientToAngle($angle)
	{
		$this->orientAngle = $angle;
		$this->setAttribute('orient',$angle); // set attribute in DOM
		$this->orientType->setBaseVal(self::SVG_MARKER_ORIENT_ANGLE);
	}

	/**
	 * Sets the correspondent parameter for the attribute orient based on 'markerUnits' value
	 *
	 * @param SVGAnimatedEnumeration|SVGAnimatedAngle $orient Corresponds to attribute 'orient' on the given 'marker' element.
	 */
	public function setOrient($orient)
	{
		if ($orient == 'auto')
		{	// set orient angle
			$this->setOrientToAuto();
		}
		else
		{	// set orient type
			$this->setOrientToAngle($orient);
		}
	}

	/**
	 * Retruns the correspondent value for the attribute orient based on 'markerUnits' value
	 *
	 * @retrun SVGAnimatedEnumeration|SVGAnimatedAngle The value of the attribute orient.
	 */
	public function getOrient()
	{
		$orient = '';
		
		switch ($this->orientType->getBaseVal()) 
		{
			case self::SVG_MARKER_ORIENT_AUTO:
				$orient = 'auto';
				break;
			case self::SVG_MARKER_ORIENT_ANGLE:
				$orient = $this->orientAngle;
				break;
		}

		return $orient;
	}
}