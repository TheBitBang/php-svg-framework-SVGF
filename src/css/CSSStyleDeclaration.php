<?php

namespace b1t\css;

use b1t\dom\DOMString; // to-do: needs to be implemented

/**
 * The CSSStyleDeclaration interface represents a single CSS declaration block.
 *
 * @author	J. Xavier Atero
 * @link	https://www.w3.org/TR/2000/REC-DOM-Level-2-Style-20001113/css.html#CSS-CSSStyleDeclaration
 */
 
class CSSStyleDeclaration {

	/** @var DOMString $cssText The parsable textual representation of the declaration block (excluding the surrounding curly braces). Setting this attribute will result in the parsing of the new value and resetting of all the properties in the declaration block including the removal or addition of properties. */
	private $cssText;

	/** @var unsigned long $length The number of properties that have been explicitly set in this declaration block. The range of valid indices is 0 to length-1 inclusive. */
	private $length;

	/** @var CSSRule $parentRule The CSS rule that contains this declaration block or null if this CSSStyleDeclaration is not attached to a CSSRule. */
	private $parentRule;

	/** @var object[] $array_properties_values List of properties and their values. */
	protected $array_properties_values = array();

	/** @var object[] $array_properties_priorities List of properties and their priorities. */
	protected $array_properties_priorities = array();
	
	/** @var \DOMElement $dom_element_associated DOMElement to which this CSSStyleDeclaration is associated. */
	protected $dom_element_associated = null;

	/**
	 * This creator has an optional parameter to store the reference of the DOMElement to which this CSSStyleDeclaration is associated.
	 * This is needed to 
	 *
	 * @param DOMString $dom_element_associated DOMElement to which this CSSStyleDeclaration is associated.
	 *
	 * @throws Exception if parameter is not of type \DOMElement.
	 */	
	public function __construct(\DOMElement $dom_element_associated = null)
	{
		if (!is_null($dom_element_associated))
		{ // if there is a DOMElement associated add it 
			$dom_element_foo = new \DOMElement('foo');
			$type_dom_element = gettype($dom_element_foo);
			if (gettype($dom_element_associated) != $type_dom_element) {throw new \Exception("attribute : $dom_element_associated is not of $type_dom_element type");}
			$this->dom_element_associated = $dom_element_associated;
		}
	}

	/**
	 * Used to retrieve the value of a CSS property if it has been explicitly set within this declaration block.
	 *
	 * @param DOMString $propertyName The name of the CSS property.
	 *
	 * @return DOMString Returns the value of the property if it has been explicitly set for this declaration block. Returns the empty string if the property has not been set.
	 */
	public function getPropertyValue($propertyName)
	{
		return $this->array_properties_values[$propertyName];
	}

	/**
	 * Used to retrieve the object representation of the value of a CSS property if it has been explicitly set within this declaration block.
	 * This method returns null if the property is a shorthand property.
	 * Shorthand property values can only be accessed and modified as strings, using the getPropertyValue and setProperty methods.
	 *
	 * @param DOMString $propertyName The name of the CSS property.
	 *
	 * @return CSSValue Returns the value of the property if it has been explicitly set for this declaration block. Returns null if the property has not been set.
	 */
	public function getPropertyCSSValue($propertyName)
	{
		// to-do
	}

	/**
	 * Used to remove a CSS property if it has been explicitly set within this declaration block.
	 *
	 * @param DOMString $propertyName The name of the CSS property.
	 *
	 * @return DOMString Returns the value of the property if it has been explicitly set for this declaration block. Returns the empty string if the property has not been set or the property name does not correspond to a known CSS property.
	 */
	public function removeProperty($propertyName)
	{
		unser($this->array_properties_values[$propertyName]);
	}

	/**
	 * Used to retrieve the priority of a CSS property (e.g. the "important" qualifier) if the property has been explicitly set in this declaration block..
	 *
	 * @param DOMString $propertyName The name of the CSS property.
	 *
	 * @return DOMString A string representing the priority (e.g. "important") if one exists. The empty string if none exists.
	 */
	public function getPropertyPriority($propertyName)
	{
		return $this->array_properties_priorities[$propertyName];
	}

	/**
	 * Used to set a property value and priority within this declaration block.
	 *
	 * @param DOMString $propertyName The name of the CSS property.
	 * @param DOMString $value The new value of the property.
	 * @param DOMString $priority The new priority of the property (e.g. "important").
	 */
	public function setProperty($propertyName,$value,$priority)
	{
		$this->array_properties_values[$propertyName] = $value;
		$this->array_properties_priorities[$propertyName] = $priority;
		$this->setCssText($this->getCssText()); // refresh the css text
		if (!is_null($this->dom_element_associated))
		{ 
			$this->dom_element_associated->setAttribute('style',$this->cssText); // set attribute in DOM
		}
	}

	/**
	 * Used to retrieve the properties that have been explicitly set in this declaration block.
	 * The order of the properties retrieved using this method does not have to be the order in which they were set.
	 * This method can be used to iterate over all properties in this declaration block.
	 *
	 * @param unsigned long $index Index of the property name to retrieve.
	 *
	 * @return DOMString The name of the property at this ordinal position. The empty string if no property exists at this position.
	 */
	public function item($index)
	{
		$keys = array_keys($this->array_properties_values);
		return $keys[$index];
	}

	/**
	 * Sets the value of an attribute.
	 *
	 * @param string $attribute_name The name of the attribute.
	 * @param string $attribute_value The value of the attribute.
	 *
	 * @throws Exception if attribute does not exist.
	 * @throws Exception if wrong syntax.
	 */
	public function __set($attribute_name, $attribute_value)
	{
		$string_set_method_name = "set" . ucfirst($attribute_name);
		if(!method_exists($this,$string_set_method_name)) {throw new \Exception("attribute : $attribute_name is not a valid attribute for this class");}
		$call_to_user_func = array(get_class($this), $string_set_method_name);
		call_user_func($call_to_user_func,$attribute_value);
	}

	/**
	 * Returns the value of the specified attribute.
	 *
	 * @param string $attribute_name The name of the attribute.
	 *
	 * @return value of the attribute.
	 *
	 * @throws Exception if wrong syntax.
	 * @throws Exception if the attribute does not exist.
	 */
	public function __get($attribute_name)
	{
		$string_get_method_name = "get" . ucfirst($attribute_name);
		if(!method_exists($this,$string_get_method_name)) {throw new \Exception("attribute : $attribute_name is not a valid attribute for this class");}
		$call_to_user_func = array(get_class($this), $string_get_method_name);
		return call_user_func($call_to_user_func);
	}

	// set and get methods

	private function setCssText($cssText)
	{
		// to-do: verify format
		$array_properties = explode(";",$cssText);
		foreach($array_properties as $property)
		{ // populate property values array (to_do: and priorities)
			if(trim($property) === '') { continue; } // to avoid adding an empty property because of the last ;
			$array_property_parts = explode(":",$property);
			$property_name = trim($array_property_parts[0]);
			$property_value = trim($array_property_parts[1]);
			$this->array_properties_values[$property_name] = $property_value;
		}
		$this->cssText = $cssText;
	}

	private function getCssText()
	{
		$this->cssText = '';
		foreach($this->array_properties_values as $property_name => $property_value)
		{ // create the cssText from the property array
			$this->cssText .= $property_name . ': ' . $property_value . '; ';
		}

		return $this->cssText;
	}

 }