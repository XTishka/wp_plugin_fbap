<?php

namespace fbap\admin\services;

use fbap\admin\repositories\PartnerRepository;
use fbap\admin\repositories\ScheduleRepository;
use fbap\includes\FacebookPublisher;
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

	public function updatePost( $post_id, $post ) {
		$post_data = array(
			'ID'           => $post_id,
			'post_title'   => sanitize_text_field( $post['fbap_post_title'] ),
			'post_content' => $post['fbap_post_description'],
		);
		wp_update_post( $post_data );
	}

	public function deletePost( $post_id ) {
		wp_delete_post( $post_id );
	}

	public function uploadPostImages( $post ): array {
		$imagesData = [
			'image_1' => [
				'url'      => $post['fbap_post_image'],
				'post_id'  => $post['post_id'],
				'filename' => $post['post_id'] . '_image_1',
				'title'    => $post['fbap_post_title'],
			],
		];

		return $this->uploadImagesFiles( $imagesData );
	}

	public function deleteImagesFromMedia( $ad ) {
		$images = json_decode( $ad->images );
		foreach ( $images as $image ) {
			wp_delete_attachment( $image->id );
		}
	}

	public function setPostImage( $ad ) {
		$images = json_decode( $ad->images );
		foreach ( $images as $index => $image ) {
			if ( $index == 'image_1' ) {
				set_post_thumbnail( $ad->post_id, $image->id );
			}
		}
	}

	public function connectImagesToPost( $postId, $images ) {
		foreach ( $images as $index => $image ) {
			if ( $index == 'image_1' ) {
				set_post_thumbnail( $postId, $image['id'] );
			}
			add_post_meta( $postId, $index, $image['url'] );
		}
	}

	public function addPostMeta( $post ) {
		// echo '<pre>';
		// print_r($post);
		// echo '</pre>';
		// die();

		add_post_meta( $post['post_id'], 'affiliate_url', $post['fbap_affiliate_url'] );
		add_post_meta( $post['post_id'], 'price', $post['fbap_post_price'] );
		add_post_meta( $post['post_id'], 'affiliate_partner', $post['affiliate_partner_name'] );
		add_post_meta( $post['post_id'], 'partners_special_link', $post['partners_special_link'] );
		add_post_meta( $post['post_id'], 'tradetracker_reference', $post['fbap_tt_reference']);
	}

	public function updatePostPrice( $postId, $postPrice ) {
		update_post_meta( $postId, 'price', $postPrice );
	}

	public function parse( $url ) {
		$data = false;
		if ( stripos( $url, 'luksushuse.dk' ) !== false ) {
			$data = $this->parseLuksushuse( $url );
		}
		if ( stripos( $url, 'dancenter.dk' ) !== false ) {
			$data = $this->parseDancenter( $url );
		}
		if ( stripos( $url, 'feriehusudlejning.dk' ) !== false ) {
			$data = $this->parseFeriehusudlejning( $url );
		}

		return $data;
	}

	public function getPartnerIdByUrl( $url, $partners ) {
		$id = false;
		foreach ( $partners as $partner ) {
			if ( stripos( $url, $partner->url ) !== false ) {
				$id = $partner->id;
			}
		}

		return $id;
	}

	public function parseFeriehusudlejning( $url ) {
		$dom = new Dom;
		$dom->loadFromUrl( $url );

		$images = [];

		$titleElement = $dom->find( 'div.house-description-wrapper span.h1' )[0];
		if ( $titleElement ) {
			$data['title'] = $titleElement->text;
		}

		$priceElemenent = $dom->find( 'span.data-total strong' )[0];
		if ( $priceElemenent ) {
			$data['price'] = 'kr. ' . str_replace( ' DKK', '', $priceElemenent->text );
		}

		$descriptionElements = $dom->find( 'div.house-description-wrapper div.house-desc-content p' )[0];
		$data['description'] = '';
		if ( $descriptionElements ) {
			foreach ( $descriptionElements as $element ) {
				$data['description'] .= $element->text;
				$data['excerpt']     = mb_strimwidth( $data['description'], 0, 200 );
			}
		}

		$imageElements = $dom->find( 'div.house-detail-slider-image' );
		foreach ( $imageElements as $image ) {
			$images[] = $image->getAttribute( 'style' );
		}
		$data['images'][0] = str_replace( 'background-image:url(', '', $images[0] );
		$data['images'][0] = str_replace( ')', '', $data['images'][0] );

		$data['url'] = $url;

		return $data;
	}

	public function parseLuksushuse( $url ) {
		$dom = new Dom;
		$dom->loadFromUrl( $url );

		$images = [];

		// Select post title source
		$postTitle = 'title'; 						// Take from page <title>
		// $postTitle = 'div.item-description h1'; 	// Take from page <h1>

		$titleElement = $dom->find( $postTitle )[0];
		if ( $titleElement ) {
			$data['title'] = $titleElement->text;
		}

		$priceElemenent = $dom->find( 'span.price' )[0];
		if ( $priceElemenent ) {
			$data['price'] = 'kr. ' . $priceElemenent->text;
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

		$nrElement =  $dom->find( 'div.item-info-adress div.clearfix span.right-sp' )[0];
		if ( $nrElement ) {
			$data['item_nr'] = $nrElement->text;
		}

		$soegElements = $dom->find( '#block-system-main-menu li.collapsed div.menu-attach-block-wrapper' )[0];
		if ( $soegElements ) {
			$data['item_nr'] = $nrElement->text;
		}

		$data['tradetracker_reference'] = $this->getTradeTrackerReference('luksushuse', $url, $data['item_nr']);

		return $data;
	}

	public function parseDancenter( $url ) {
		$dom = new Dom;
		$dom->loadFromUrl( $url );

		$images = [];

		// Select post title source
		$titleSource = 'dom.title';		// Take from page <title>
		// $titleSource = 'dom.h1';		// Take from page <h1>

		if ($titleSource == 'dom.h1') {
			$titleElement  = $dom->find( '#VhPageHeaderLinkDesktop a' );
			$data['title'] = '';
			foreach ( $titleElement as $key => $content ) {
				$data['title'] .= $content->text . ', ';
			}
			$data['title'] = substr( $data['title'], 0, - 2 );
		} else {
			$titleElement = $dom->find( 'title' )[0];
			if ( $titleElement ) {
				$data['title'] = $titleElement->text;
			}
		}
		

		$priceElemenent = $dom->find( '#VhPageHeaderLinkDesktop a' );
		if ( $priceElemenent ) {
			$data['price'] = $priceElemenent->text;
		}
		$data['price'] = '';

		$descriptionElement = $dom->find( 'div#VhDescription p' );
		if ( $descriptionElement ) {
			$data['description'] = $descriptionElement->text;
			$data['excerpt']     = mb_strimwidth( $data['description'], 0, 200 );
		}

		$imageElements = $dom->find( '.Vh7ImagesList' );
		foreach ( $imageElements as $image ) {
//			$images[] = $image->getAttribute( 'href' );
			$image->getAttribute( 'class' );
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
			$imgUrl = wp_get_attachment_image_src( $attach_id, 'full' );

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

	public function getFilteredSchedules( $id, $filter ) {
		$schedulesRepository = new ScheduleRepository();
		if ( $filter != 'trashed' ) {
			$schedules = $schedulesRepository->getFilteredSchedulesByAdId( $id, $filter );
		} else {
			$schedules = $schedulesRepository->getTrashedSchedulesByAdId( $id, $filter );
		}

		return $schedules;
	}

	public function createCronTask( $scheduleId, $publicationTime ) {
		$time = strtotime( $publicationTime ) - 7200;
		wp_schedule_single_event( strtotime( $publicationTime ) - 7200, 'publish_link_to_fb_action_hook', [ $scheduleId ] );
	}

	public function removeCronTask( $publicationTime ) {
		$time = strtotime( $publicationTime ) - 7200;
		wp_unschedule_event( strtotime( $publicationTime ) - 7200, 'publish_link_to_fb_action_hook' );
	}

	public function getPartnersSpecialLink( $post, $partnerId ) {
		$specialLink        = '';
		$partnersRepository = new PartnerRepository();
		$partner            = $partnersRepository->getPartnerByID( $partnerId )[0];
		if ( $post['affiliate_partner_name'] == 'Dancenter' ) {
			$url         = str_replace( 'https://www.dancenter.dk/', '', $post['affiliate_link'] );
			$url         = str_replace( '=', '%3D', $url );
			$url         = str_replace( '/?', '%2F%3F', $url );
			$url         = str_replace( '/', '%2F', $url );
			$url         = '%2F' . $url;
			$specialLink = $partner->link;
			$specialLink = str_replace( '[program_id]', $partner->program_id, $specialLink );
			$specialLink = str_replace( '[partner_id]', $partner->partner_id, $specialLink );
			$specialLink = str_replace( '[relative_uri]', $url, $specialLink );
		}
		if ( $post['affiliate_partner_name'] == 'Luksushuse.dk' ) {
			if ( !isset($post[ 'tradetracker' ]) ) {
				$specialLink = $post['affiliate_link'] . '/' . $partner->link;
			} else {
				$url         = str_replace( 'https://www.luksushuse.dk/', '', $post['affiliate_link'] );
				$url         = str_replace( '=', '%3D', $url );
				$url         = str_replace( '/?', '%2F%3F', $url );
				$url         = str_replace( '/', '%2F', $url );
				$url         = '%2F' . $url;
				$specialLink = 'https://tc.tradetracker.net/?c=15302&m=12&a=392653&r=' . $post['fbap_tt_reference'] . '&u=' . $url;
			}
		}
		if ( $post['affiliate_partner_name'] == 'Feriehusudlejning.dk' ) {
			$specialLink = $post['affiliate_link'] . '/' . $partner->link;
		}

		return $specialLink;
	}

	public function getTradeTrackerReference($source, $url, $itemNr) {
		$reference = '';

		if ($source === 'luksushuse') {
			$soegData = ['nordjylland', 'vestjylland', 'limfjorden', 'oestjylland', 'sydjylland', 'fyn-og-oeer', 'nordsjaelland', 'lolland-falster-moen', 'bornholm', 'sverige', 'tyskland'];
			$position = strpos($url, $itemNr);
			$reference = substr($url, 0, $position);
			$reference = str_replace( 'https://www.luksushuse.dk/soeg/', '', $reference );
			foreach ($soegData as $soeg) {
				$reference = str_replace($soeg, '', $reference);
				$reference = str_replace('/', '', $reference);
			}
		}

		return $reference;
	}
}