<?php

use PHPHtmlParser\Dom;

class LuksushuseParser extends Parser {

	public $dom;

	public function __construct( $url ) {
		parent::__construct( $url );

		$dom               = new Dom;
		$this->dom         = $dom->loadFromUrl( $this->url );
		$this->title       = $this->getTitle();
		$this->price       = $this->getPrice();
		$this->description = $this->getDescription();
		$this->excerpt     = mb_strimwidth( $this->description, 0, 200 );
		$this->image       = $this->getImage();
	}

	private function getTitle(): string {
		$postTitle    = 'div.item-description h1';
		$titleElement = $this->dom->find( $postTitle )[0];

		return ( $titleElement ) ? $titleElement->text : 'Title not found';
	}

	private function getPrice(): string {
		$priceElement = $this->dom->find( 'span.price' )[0];

		return ( $priceElement ) ? 'kr. ' . $priceElement->text : 'Price not found';
	}

	private function getDescription(): string {
		$descriptionElement = $this->dom->find( 'div.item-description div' )[0];

		return ( $descriptionElement ) ? $descriptionElement->text : 'Description not found';
	}

	private function getImage(): string {
		$imageElements = $this->dom->find( 'a.fresco' )[0];
		return ( $imageElements ) ? $imageElements->getAttribute( 'href' ) : 'Image not found';
	}
}