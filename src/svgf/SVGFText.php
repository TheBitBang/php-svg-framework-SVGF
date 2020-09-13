<?php

namespace b1t\svgf;

use b1t\svg\SVGObject;
use b1t\svg\SVGTextElement;
use b1t\svg\SVGTSpanElement;
use b1t\svgf\geometry\SVGFObjectBoxTextElement;

/**
 * This class provides functionalities for SVGTextElement.
 *
 * @author J. Xavier Atero
 */
 
class SVGFText {

	public static function fitWithinWidth($dom_doc_svg, $svg_text, $max_width, $style_baseline_shift_percentage = 0.6)
	{

		// initializations
		$text = "";
		$text_id = $svg_text->id;
		$text_x = $svg_text->x;
		$text_y = $svg_text->y;

		// get style information
		$style_text = $svg_text->style;

		// get the bounding box
		$bbox_element_text = new SVGFObjectBoxTextElement($svg_text);
		$text_width = $bbox_element_text->x_max - $bbox_element_text->x_min;
		$text_height = $bbox_element_text->y_max - $bbox_element_text->y_min;

		$style_baseline_shift = $text_height * $style_baseline_shift_percentage;

		// verify that text fits within the specified width
		if ($text_width > $max_width)
		{

			// fit text in maximum width
			$words = explode(" ", $svg_text->nodeValue);

			// create new text element
			$dom_doc_svg->removeChild($svg_text); // delete previous reference
			$svg_text = SVGFElement::text($dom_doc_svg,$text,$text_id);
			$svg_text->style = $style_text;

			$i = 0; // initialzation to use it outside the loop (not required, but to indicate variable scope)
			foreach ($words as $i=>$word) // to-do: better algorithm
			{
				$text_with_new_word = ($text == "") ? $word : $text . " " . $word;
				$svg_text_aux = SVGFElement::text($dom_doc_svg,$text_with_new_word,"text_aux");
				$svg_text_aux->style = $style_text; // apply original style
				$dom_doc_svg->appendChild($svg_text_aux);
				$dom_doc_svg->removeChild($svg_text_aux);

				// get the bounding box
				$bbox_element_text_aux = new SVGFObjectBoxTextElement($svg_text_aux);
				$text_aux_width = $bbox_element_text_aux->x_max - $bbox_element_text_aux->x_min;

				// fit text in maximum width
				if ($text_aux_width > $max_width)
				{

					$tspan_id = "tspan_" . $i . "_of_" . $text_id; // construct id for tspan

					if ($text != "") // at least one word
					{
						$svg_tspan = SVGFElement::tspan($dom_doc_svg,$text,$tspan_id,$text_x,$text_y); // write the text without the new word
						$svg_tspan->style->setProperty('baseline-shift',$style_baseline_shift,'');
						$text_with_new_word = $word;
					}
					else // the current word is wider than the restriction
					{
						$svg_tspan = SVGFElement::tspan($dom_doc_svg,$text_with_new_word,$tspan_id,$text_x,$text_y); // write the text without the new word
						$text_with_new_word = "";
					}

					$svg_text->appendChild($svg_tspan);
					$text_y = $text_y + $text_height;

				}

				$text = $text_with_new_word;

			}

			if ($text != "") // write remaining
			{
				$i++;
				$tspan_id = "tspan_" . $i . "_of_" . $text_id; // construct id for tspan
				$svg_tspan = SVGFElement::tspan($dom_doc_svg,$text,$tspan_id,$text_x,$text_y);  // write the remaining of the text
				$svg_text->appendChild($svg_tspan);
			}
		}

		return $svg_text;

	}

}