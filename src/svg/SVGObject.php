<?php

namespace b1t\svg;

use b1t\css\CSSStyleDeclaration;

/**
 * This class contains the common properties and methods for SVG Interfaces
 *
 * @author	J. Xavier Atero
 */
 
class SVGObject extends \DOMElement {
	
	/** @var string['namespace_name']['attribute_name'=>'attribute_value'] $attributes_in_namespaces Values of attributes in namespaces. */
	protected $array_attributes_in_namespaces = array();

	public function __construct($dom_doc_svg,$element_name)
	{
		parent::__construct($element_name);
		$dom_doc_svg->appendChild($this);
		if(method_exists($this,'setStyle'))	{$this->setStyle();} // initialize style if exists		
	}
	
	/**
	 * Adds a new attribute to specified namespace.
	 *
	 * @param string $attribute_name The name of the attribute.
	 * @param string $attribute_value The value of the attribute.
	 *
	 * @throws Exception if attribute does not belong to a namespace and there is not a set method for it.
	 * @throws Exception if wrong syntax.
	 */
	public function __set($attribute_name, $attribute_value)
	{
		$array_attribute_names = explode(":",$attribute_name);
	
		if (count($array_attribute_names)==1)
		{	// the attribute does not belong to a namespace
			$string_set_method_name = "set" . ucfirst($attribute_name);
			if(!method_exists($this,$string_set_method_name))// {throw new \Exception("attribute : $attribute_name is not a valid SVG attribute for the element : $this->element_name");}
{}else{
			$call_to_user_func = array(get_class($this), $string_set_method_name);
			switch ($attribute_name) 
			{
				case 'style': // convert attribute_value to CSSStyleDeclaration
					$type_string = gettype('string');
					if (gettype($attribute_value) == $type_string)
					{ // if string convert to CSSStyleDeclaration
						$css = new CSSStyleDeclaration();
						$css->cssText = $attribute_value;
						$attribute_value = $css;
					}
					break;		
			}
			
			call_user_func($call_to_user_func,$attribute_value);
//			$this->setAttribute($attribute_name,$attribute_value); // set attribute in DOM (to_do: should not be needed here)
}			
		}
		else
		{
			// the attribute belongs to a namespace
			if (count($array_attribute_names)!=2) {throw new \Exception("attribute : $attribute_name should have the following syntax 'namespace:attribute' where 'namespace' and 'attribute' do not contain the sequence ':'");}
			$namespace_name = $array_attribute_names[0];
			$attribute_name = $array_attribute_names[1];
			
			if (!array_key_exists($namespace_name, $this->array_attributes_in_namespaces)) 
			{ // create namespace if it does not exists
				$this->array_attributes_in_namespaces[$namespace_name] = array();
			}
			// add values			
			$this->array_attributes_in_namespaces[$namespace_name][$attribute_name] = $attribute_value;
		}
	}
	
	/**
	 * Returns the value of the attribute in the specified namespace.
	 *
	 * @param string $attribute_name The name of the attribute.
	 *
	 * @return value of the attributre.
	 *
	 * @throws Exception if wrong syntax.
	 * @throws Exception if the attribute does not exists in the namespace.
	 */	
	public function __get($attribute_name)
	{
		$array_attribute_names = explode(":",$attribute_name);
	
		if (count($array_attribute_names)==1)
		{	// the attribute does not belong to a namespace
			$string_get_method_name = "get" . ucfirst($attribute_name);
			if(!method_exists($this,$string_get_method_name)) {throw new \Exception("attribute : $attribute_name is not a valid SVG attribute for the element : $this->nodeName");}
			$call_to_user_func = array(get_class($this), $string_get_method_name);
			return call_user_func($call_to_user_func,$attribute_value);
		}
		else
		{
			if (count($array_attribute_names)!=2) {throw new \Exception("attribute : $attribute_name should have the following syntax 'namespace:attribute' where 'namespace' and 'attribute' do not contain the sequence ':'" );}
			$namespace_name = $array_attribute_names[0];
			$attribute_name = $array_attribute_names[1];
			
			if (!array_key_exists($namespace_name, $this->array_attributes_in_namespaces)) {throw new \Exception("attribute : '$this->namespace_name:$attribute_name' is not defined");}
		
			return $this->array_attributes_in_namespaces[$namespace_name];
		}
	}

	/**
	 * Populates the attributes based on an XML element
	 *
	 * @param \SimpleXMLElement $xml_element The XML element to add.
	 */
	public function populateFromXML (\SimpleXMLElement $xml_element)
	{
		foreach ($xml_element->attributes as $attribute)
		{	// process all the attributes of the element
			$attribute_name = $attribute->nodeName;
			$attribute_value = $attribute->element_value;
			$this->$attribute_name = $attribute_value;
		}
	}	
}