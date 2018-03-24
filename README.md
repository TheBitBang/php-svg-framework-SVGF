# SVGF: SVG Framework for PHP

**SVGF** (Scalable Vector Graphics Framework) is a PHP library for creating and modifying SVG files.

It is composed of: 
* A PHP implementation of the [Scalable Vector Graphics (SVG) 1.1](https://www.w3.org/TR/SVG/Overview.html) specification.
* A PHP implementation of the [Document Object Model (DOM) Level 2 Style Specification](https://www.w3.org/TR/DOM-Level-2-Style/).
* Additional functionality for the SVG element manipulation.

## Extended functionality

These are the main functionalities provided by **SVGF**:

* Read and write SVG files.
* Programatically modify the attributes of the elements in compliance with the (SVG) 1.1 specification.
* Programatically modify the style attribute in compliance with the (DOM) Level 2 Style Specification.
* Access SVG elements using XPath.
* Programatically align SVG elements

## Usage

### Create and read SVG files

#### Create SVG with size A4 (portrait orientation)

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('210mm');
$svg_svg->setHeight('297mm');
$svg_svg->setViewBox('0 0 210 270');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');	
```

#### Create SVG with size A4 using SVGUtils (portrait orientation)

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = SVGUtils::svg($dom_doc_svg,'a4',SVGUtils::SIZE_A4,'portrait');
```

#### Create SVG with size A4 using SVGUtils (landscape orientation)

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = SVGUtils::svg($dom_doc_svg,'a4');
```

or

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = SVGUtils::svg($dom_doc_svg,'a4',SVGUtils::SIZE_A4,'landscape');
```

#### Create SVG with size Full HD

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = new SVGSVGElement($dom_doc_svg);
$svg_svg->setWidth('1920px');
$svg_svg->setHeight('1080px');
$svg_svg->setViewBox('0 0 1920 1080');
$svg_svg->setVersion('1.1');
$svg_svg->setAttribute('xmlns','http://www.w3.org/2000/svg');	
```

#### Create SVG with size Full HD using SVGUtils 

```php
$dom_doc_svg = new \DOMDocument('1.0', 'utf-8');
$svg_svg = SVGUtils::svg($dom_doc_svg,'a4',SVGUtils::SIZE_FHD);
```

#### SVGUtils predefined sizes

* A0, A1, A2, A3, A4, A5
* ARCH_A, ARCH_B, ARCH_C, ARCH_D, ARCH_E
* ICON_16X16, ICON_32X32, ICON_48X48
* VGA, SVGA, XGA, HD, FHD, QHD, UHD, 8K

### Create basic shapes

#### Create rectangle calling methods

```php
$svg_rect = new SVGRectElement($dom_doc_svg);
$svg_rect->setId('rect_50x50_1');
$svg_rect->setX('0');
$svg_rect->setY('0');
$svg_rect->setWidth('50');
$svg_rect->setHeight('50');
$svg_rect->setRx('5');
$svg_rect->setRy('5');
$svg_svg->appendChild($svg_rect);
```

<img src="./examples/readme/rect_50x50_1.svg">

#### Create rectangle setting values

```php
$svg_rect = new SVGRectElement($dom_doc_svg);
$svg_rect->id = 'rect_50x50_2';
$svg_rect->x = '0';
$svg_rect->y = '0';
$svg_rect->width = '50';
$svg_rect->height = '50';
$svg_rect->rx = '10';
$svg_rect->ry = '10';
$svg_svg->appendChild($svg_rect);
```

<img src="./examples/readme/rect_50x50_2.svg">

#### Create rectangle using functions SVGUtils

```php
$svg_rect = SVGUtils::rect($dom_doc_svg,'50','50','rect_50x50_3');
$svg_svg->appendChild($svg_rect);
```

<img src="./examples/readme/rect_50x50_3.svg">

### Apply style

### Align SVG elements

### Split paths