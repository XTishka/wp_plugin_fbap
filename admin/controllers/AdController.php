<?php

namespace fbap\admin\controllers;

use fbap\admin\repositories\GroupRepository;
use fbap\admin\repositories\PartnerRepository;
use PHPHtmlParser\Dom;

class AdController {

	public function index() {
		show_index_ads();
	}

	public function create() {
		$post     = $_POST;
		$partners = new PartnerRepository();
		$groups   = new GroupRepository();

		$data['parser']['url'] = '';
		$data['show_form']     = false;
		if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] ) {
			$url               = $post['fbap_affiliate_url'];
			$data['show_form'] = true;
			$data['parser']    = $this->parse( $url );
			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		if ( ! $post ) {
			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		// Create post and image upload
		if ( $post and $post['action'] == 'create_post' ) {
			$this->store( $post );
		}
	}

	private function store( $post ) {
		$post_data = array(
			'post_title'   => sanitize_text_field( $post['fbap_post_title'] ),
			'post_content' => $post['fbap_post_description'],
			'post_type'    => 'affiliate-ads',
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
		);

		$post_id = wp_insert_post( $post_data );
		$this->fileUpload( $post['image_1'], $post_id . '_image_1', $post['fbap_post_title'], $post_id );
		$this->fileUpload( $post['image_2'], $post_id . '_image_2', $post['fbap_post_title'], $post_id );
		$this->fileUpload( $post['image_3'], $post_id . '_image_3', $post['fbap_post_title'], $post_id );

		add_post_meta( $post_id, 'affiliate_url', $post['fbap_affiliate_url']);
		add_post_meta( $post_id, 'price', $post['fbap_post_price']);

		$partners = new PartnerRepository();
		$partner = $partners->getPartnerByID($post['fbap_affiliate_partner']);
		add_post_meta( $post_id, 'affiliate_partner', $partner[0]->display_name);

		show_update_ads( get_post( $post_id ) );
	}

	private function parse( $url ) {
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

	private function fileUpload( $url, $filename, $post_title, $post_id ) {

		if ( strpos( $url, '.jpg' ) ) {
			$filename = $filename . '.jpg';
		}
		if ( strpos( $url, '.jpeg' ) ) {
			$filename = $filename . '.jpeg';
		}
		if ( strpos( $url, '.png' ) ) {
			$filename = $filename . '.png';
		}

		$uploaddir  = wp_upload_dir();
		$uploadfile = $uploaddir['path'] . '/' . $filename;

		$contents = file_get_contents( $url );
		$savefile = fopen( $uploadfile, 'w' );
		fwrite( $savefile, $contents );
		fclose( $savefile );

		$filetype = wp_check_filetype( basename( $filename ), null );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $uploaddir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$wp_filetype = wp_check_filetype( basename( $filename ), null );

		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => $post_title,
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $uploadfile );
		$imgUrl = wp_get_attachment_image_src($attach_id);
		if ( strpos( $filename, 'image_1' )) set_post_thumbnail( $post_id, $attach_id );
		if ( strpos( $filename, 'image_1' )) add_post_meta( $post_id, 'image_1', $imgUrl[0] );
		if ( strpos( $filename, 'image_2' )) add_post_meta( $post_id, 'image_2', $imgUrl[0] );
		if ( strpos( $filename, 'image_3' )) add_post_meta( $post_id, 'image_3', $imgUrl[0] );

		$new_image      = get_post( $attach_id );
		$full_size_path = get_attached_file( $new_image->ID );
		$attach_data    = wp_generate_attachment_metadata( $attach_id, $full_size_path );
		wp_update_attachment_metadata( $attach_id, $attach_data );
	}
}