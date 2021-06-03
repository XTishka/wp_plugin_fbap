<?php

namespace fbap\admin\includes;

use PHPHtmlParser\Dom;

class AffiliateAds {

	public $tabs
		= [
			'ads'      => 'Affiliate ads',
			'partners' => 'Affiliate partners',
			'groups'   => 'Facebook groups',
			'settings' => 'Settings',
		];

	private $previewLink = '';

	/**
	 * Get ads list
	 */
	public function index( $type ) {
		echo $type;
	}

	/**
	 * Add new link
	 */
	public function create( $type ) {
		if ( $type == 'ads' ) {
			$post                  = $_POST;
			$data['parser']['url'] = '';
			$data['show_form']     = false;
			if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] ) {
				$url               = $post['fbap_affiliate_url'];
				$data['show_form'] = true;
				$data['parser']    = $this->parse( $url );
			}
			affiliate_ads_create( $data );
		}
	}

	/**
	 * Update ads link
	 */
	public function update() {

	}

	/**
	 * Delete ads link
	 */
	public function delete() {

	}

	/**
	 * Get parse data
	 */
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

	public function getHeader( $tab ) {
		switch ( $tab ) {
			case 'partners':
				$pageTitle  = 'Affiliate partners';
				$addNewLink = '?page=fbap-affiliate-ads&tab=new-partner';
				break;
			case 'groups':
				$pageTitle  = 'Facebook groups';
				$addNewLink = '?page=fbap-affiliate-ads&tab=new-group';
				break;
			case 'settings':
				$pageTitle  = 'Settings';
				$addNewLink = false;
				break;
			default:
				$pageTitle  = 'Affiliate ads';
				$addNewLink = '?page=fbap-affiliate-ads&tab=new-ad';
		}
		$html = '<h1 class="wp-heading-inline">';
		$html .= $pageTitle;
		$html .= '</h1>';

		if ( $addNewLink != false ) {
			$html .= '<a href="' . $addNewLink . '" class="page-title-action">Add New</a>';
		}

		return $html;
	}

	public function getContent( $tab ) {
		switch ( $tab ) {
			case 'partners':
				$this->index( 'partner' );
				break;
			case 'groups':
				$this->index( 'groups' );
				break;
			case 'settings':
				$this->index( 'settings' );
				break;
			case 'new-ad':
				$this->create( 'ads' );
				break;
			case 'new-partner':
				$this->create( 'partner' );
				break;
			case 'new-group':
				$this->create( 'group' );
				break;
			default:
				$this->index( 'ads' );
		}
	}
}