<?php

namespace b1t\svgf\file;

use b1t\svg\SVGSVGElement;

/**
 * This class reads the content of an SVG file and creates the equivalent structure.
 *
 * @author	J. Xavier Atero
 */
 
class SVGFImportFromSVG {

    /** @var SVGObjects[] Array containing all the SVGObjects as a multidimensional indexed array. This is a workarround because a direct appendChild() does cast all objects to DOMElement. */
    private static $array_svg_objects = array();

    /** @var \DOMDocument $dom_doc_svg Owner \DOMDocument for all the SVGObjects created. */
	private static $dom_doc_svg; // create DOMDocument for SVG

    /** @var string[] $map_svg_element_classes Map of tag names to fully-qualified class names. */
    private static $map_svg_element_classes = array(
		'circle'	=> 'b1t\svg\SVGCircleElement',
		'defs'		=> 'b1t\svg\SVGDefsElement',
        'g'			=> 'b1t\svg\SVGGElement',
		'marker'	=> 'b1t\svg\SVGMarkerElement',
		'path'		=> 'b1t\svg\SVGPathElement',
		'polygon'	=> 'b1t\svg\SVGPolygonElement',
		'polyline'	=> 'b1t\svg\SVGPolylineElement',
        'rect'		=> 'b1t\svg\SVGRectElement',
        'svg'		=> 'b1t\svg\SVGSVGElement',
        'text'		=> 'b1t\svg\SVGTextElement',
		'tspan'		=> 'b1t\svg\SVGTSpanElement',
    );

	/**
	 * Porcess the file passed as a parameter and returns the SVGObject generated.
	 *
	 * @param string $path_file The path to the file containg the svg to be imported.
	 *
	 * @return \DOMDocument The \DOMDocument containing the SVGObject generated.
	 *
	 * @throws Exception if incorrect file format.
	 */	
	public static function getSVGFromFile($path_file)
	{
		$string_svg = file_get_contents($path_file); //read file
		self::getSVGFromString($string_svg);
		
		return self::$dom_doc_svg;
	}
	
	/**
	 * Porcess the string passed as a parameter and returns the SVGObject generated.
	 *
	 * @param string $string_svg The content of an svg.
	 *
	 * @return \DOMDocument The \DOMDocument containing the SVGObject generated.
	 *
	 * @throws Exception if incorrect file format.
	 */		
	public static function getSVGFromString($string_svg)
	{
		$dom_doc = new \DOMDocument();
		$dom_doc->loadXML($string_svg);
		self::getSVGFromXML($dom_doc);

		return self::$dom_doc_svg;				
	}

	/**
	 * Porcess the DOMDocument passed as a parameter and returns the SVGObject generated.
	 *
	 * @param \DOMDocument $dom_doc The DOMDocument containing the svg.
	 *
	 * @return \DOMDocument The \DOMDocument containing the SVGObject generated.
	 *
	 * @throws Exception if incorrect file format.
	 */		
	public static function getSVGFromXML(\DOMDocument $dom_doc)
	{
		self::$dom_doc_svg = new \DOMDocument('1.0', 'utf-8'); // create DOMDocument for SVG
		$root_svg=$dom_doc->documentElement; // get root element
		self::constructMultidimensionalAssociativeArrayFromXml($root_svg,self::$array_svg_objects); // to avoid problems with appendChild() casting
		$svg_object = self::$array_svg_objects['svg_object'];
		$children = self::$array_svg_objects['children'];
		self::processMultidimensionalAssociativeArrayElement($svg_object,$children);
	
		return self::$dom_doc_svg;
	}	
	
	/**
	 * Parses the XML constructing an array that contains the references to all the SVGObject created.
	 * This array is craeated because if the SVGObject is directly appended with appendChild() after exiting this function it will be of type base DOMElement.
	 *
	 * @param \DOMElement $dom_element The XML element to add.
	 * @param &object[] & $array_svg_objects Reference to the specific part of the array that will store the SVGObjects created inside this function.
	 */
	private static function constructMultidimensionalAssociativeArrayFromXml(\DOMElement $dom_element, & $array_svg_objects)
	{
		$element_name = $dom_element->tagName;
		if (!isset(self::$map_svg_element_classes[$element_name])) // {throw new \Exception("element : $element_name is not a valid SVG element");}
{
	// do nothing
	
} else {
		$name_class = self::$map_svg_element_classes[$element_name]; // get class name
		$svg_object = new $name_class(self::$dom_doc_svg); // create element
		$array_svg_objects['svg_object'] = $svg_object;
		$array_svg_objects['children'] = array(); // if there are no children the array will be empty
		
		foreach ($dom_element->attributes as $attribute)
		{	// populate attributes
			$attribute_name = $attribute->nodeName;
			$attribute_value = $attribute->nodeValue;
			$svg_object->$attribute_name = $attribute_value;
		}

		foreach ($dom_element->childNodes as $key=>$dom_child_elemement)
		{	// add content and children
			$element_type = $dom_child_elemement->nodeType;
			switch ($element_type) 
			{
				case XML_TEXT_NODE: // add content to the node
					$element_value = $dom_child_elemement->nodeValue;
					if(!empty(trim($element_value)))
					{ // to avoid spaces and line breaks
						$svg_object->textContent = $element_value;
					}
					break;
				case XML_ELEMENT_NODE: // process as a child
					self::constructMultidimensionalAssociativeArrayFromXml($dom_child_elemement,$array_svg_objects['children'][$key]); // recursion
					break;		
			}
		}
}
		
	}

	/**
	 * Recursively appends the children to the SVGObjects being processed.
	 *
	 * @param SVGObject $svg_object Object being processed.
	 * @param object[]  $array_children Contains the children of the object being processed.
	 */
	private static function processMultidimensionalAssociativeArrayElement($svg_object,$array_children)
	{	
		foreach ($array_children as $child)
		{	// append children if any and perform recursion on them
			$svg_object->appendChild($child['svg_object']);
			self::processMultidimensionalAssociativeArrayElement($child['svg_object'],$child['children']); // recursion
		}
	}    
}