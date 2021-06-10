<?php

namespace fbap\admin\services;

use fbap\admin\repositories\PartnerRepository;
use PHPHtmlParser\Dom;

class AdService {

	public function createPost( $post ) {
		$post_data = array(
			'post_title'   => sanitize_text_field( $post['fbap_post_title'] ),
			'post_content' => $post['fbap_post_description'],
			'post_type'    => 'affiliate-ads',
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
		);
		$post_id   = wp_insert_post( $post_data );

		return $post_id;
	}

	public function uploadPostImages( $post ): array {
		$imagesData = [
			'image_1' => [
				'url'      => $post['image_1'],
				'post_id'  => $post['id'],
				'filename' => $post['id'] . '_image_1',
				'title'    => $post['fbap_post_title'],
			],
			'image_2' => [
				'url'      => $post['image_2'],
				'post_id'  => $post['id'],
				'filename' => $post['id'] . '_image_2',
				'title'    => $post['fbap_post_title'],
			],
			'image_3' => [
				'url'      => $post['image_3'],
				'post_id'  => $post['id'],
				'filename' => $post['id'] . '_image_3',
				'title'    => $post['fbap_post_title'],
			],
		];

		return $this->uploadImagesFiles( $imagesData );
	}

	public function connectImagesToPost( $postId, $images) {
		foreach ($images as $index => $image) {
			if ($index == 'image_1') {
				set_post_thumbnail( $postId, $image['id'] );
			}
			add_post_meta( $postId, $index, $image['url'] );
		}
	}

	public function addPostMeta($post) {
		$partners = new PartnerRepository();
		$partner  = $partners->getPartnerByID( $post['fbap_affiliate_partner'] );

		add_post_meta( $post['id'], 'affiliate_url', $post['fbap_affiliate_url'] );
		add_post_meta( $post['id'], 'price', $post['fbap_post_price'] );
		add_post_meta( $post['id'], 'affiliate_partner', $partner[0]->display_name );
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

	public function uploadImagesFiles( $imagesData ): array {
		$images = [];
		foreach ( $imagesData as $index => $image ) {
			$filename = $this->getFilenameWithExtention( $image['url'], $image['filename'] );

			$uploaddir  = wp_upload_dir();
			$uploadfile = $uploaddir['path'] . '/' . $filename;

			$contents = file_get_contents( $image['url'] );
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
				'post_title'     => $image['title'],
				'post_content'   => '',
				'post_status'    => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $uploadfile );

			$new_image      = get_post( $attach_id );
			$full_size_path = get_attached_file( $new_image->ID );
			$attach_data    = wp_generate_attachment_metadata( $attach_id, $full_size_path );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			$imgUrl = wp_get_attachment_image_src( $attach_id );

			$images[ $index ] = [
				'id'       => $attach_id,
				'filename' => $filename,
				'url'      => $imgUrl[0],
			];
		}
		return $images;
	}

	public function getFilenameWithExtention( $url, $filename ) {
		if ( strpos( $url, '.jpg' ) ) {
			$filename = $filename . '.jpg';
		}
		if ( strpos( $url, '.jpeg' ) ) {
			$filename = $filename . '.jpeg';
		}
		if ( strpos( $url, '.png' ) ) {
			$filename = $filename . '.png';
		}

		return $filename;
	}
}