<?php

namespace fbap\admin\controllers;

use PHPHtmlParser\Dom;

class AdController {

	public function index() {
		show_index_ads();
	}

	public function create() {
		$post = $_POST;

		$data['parser']['url'] = '';
		$data['show_form']     = false;
		if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] ) {
			$url               = $post['fbap_affiliate_url'];
			$data['show_form'] = true;
			$data['parser']    = $this->parse( $url );
		}
		show_create_ad( $data );
	}

	public function parse( $url ) {
		$dom = new Dom;
		$dom->loadFromUrl( $url );

		$images = [];

		$titleElement = $dom->find( 'div.item-description h1' )[0];
		if ( $titleElement ) {
			$data['title'] = $titleElement->text;
		}

		$priceElemenent = $dom->find( 'span.price' )[0];
		if ( $priceElemenent ) {
			$data['price'] = $priceElemenent->text;
		}

		$descriptionElement = $dom->find( 'div.item-description div' )[0];
		if ( $descriptionElement ) {
			$data['description'] = $descriptionElement->text;
			$data['excerpt']     = mb_strimwidth( $data['description'], 0, 200 );
		}

		$imageElements = $dom->find( 'a.fresco' );
		foreach ( $imageElements as $image ) {
			$images[] = $image->getAttribute( 'href' );
		}
		$data['images'] = $images;

		$data['url'] = $url;

		return $data;
	}
}