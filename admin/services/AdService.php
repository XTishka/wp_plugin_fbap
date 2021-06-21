<?php

namespace fbap\admin\services;

use fbap\admin\repositories\PartnerRepository;
use fbap\admin\repositories\ScheduleRepository;
use PHPHtmlParser\Dom;
use fbap\includes\FacebookApi;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

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
				'url'      => $post['image_1'],
				'post_id'  => $post['post_id'],
				'filename' => $post['post_id'] . '_image_1',
				'title'    => $post['fbap_post_title'],
			],
			'image_2' => [
				'url'      => $post['image_2'],
				'post_id'  => $post['post_id'],
				'filename' => $post['post_id'] . '_image_2',
				'title'    => $post['fbap_post_title'],
			],
			'image_3' => [
				'url'      => $post['image_3'],
				'post_id'  => $post['post_id'],
				'filename' => $post['post_id'] . '_image_3',
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

	public function connectImagesToPost( $postId, $images ) {
		foreach ( $images as $index => $image ) {
			if ( $index == 'image_1' ) {
				set_post_thumbnail( $postId, $image['id'] );
			}
			add_post_meta( $postId, $index, $image['url'] );
		}
	}

	public function addPostMeta( $post ) {
		add_post_meta( $post['post_id'], 'affiliate_url', $post['fbap_affiliate_url'] );
		add_post_meta( $post['post_id'], 'price', $post['fbap_post_price'] );
		add_post_meta( $post['post_id'], 'affiliate_partner', $post['affiliate_partner_name'] );
		add_post_meta( $post['post_id'], 'partners_special_link', $post['partners_special_link'] );
	}

	public function updatePostPrice( $postId, $postPrice ) {
		update_post_meta( $postId, 'price', $postPrice );
	}

	public function parse( $url ) {
		$data = false;
		if (stripos($url, 'luksushuse.dk') !== false) $data = $this->parseLuksushuse($url);
		if (stripos($url, 'dancenter.dk') !== false) $data = $this->parseDancenter($url);
		return $data;
	}

	public function parseLuksushuse( $url ) {
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

	public function parseDancenter( $url ) {
		$dom = new Dom;
		$dom->loadFromUrl( $url );

		$images = [];

		$titleElement = $dom->find( '#VhPageHeaderLinkDesktop a' );
		$data['title'] = '';
		foreach ($titleElement as $key => $content)
		{
			$data['title'] .= $content->text . ', ';
		}
		$data['title'] = substr($data['title'], 0, -2);

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
			echo $image->getAttribute('class');
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
		$publicationTime = strtotime( $publicationTime );
		$leftTime        = $publicationTime - time();

		add_action( 'fb_post_publication_' . $scheduleId, $this->test_service_cron() );
		wp_schedule_single_event( time() + $leftTime, 'fb_post_publication_' . $scheduleId );
	}

	public function getPartnersSpecialLink( $post, $partnerId ) {
		$specialLink = '';
		$partnersRepository = new PartnerRepository();
		$partner = $partnersRepository->getPartnerByID($partnerId)[0];
		if ($post['affiliate_partner_name'] == 'Tradetracker.net') {
			$specialLink = $partner->link;
			$specialLink = str_replace('[program_id]', $partner->program_id, $specialLink);
			$specialLink = str_replace('[partner_id]', $partner->partner_id, $specialLink);
			$specialLink = str_replace('[relative_uri]', $post['affiliate_link'], $specialLink);
		}
		if ($post['affiliate_partner_name'] == 'Luksushuse.dk') {
			$specialLink = $post['affiliate_link'] . '/' . $partner->link;
		}
		return $specialLink;
	}


	public function test_service_cron() {
//		update_option('admin_email','takhir.berdyiev@gmail.com');

//		$access_token = 'EAAQLDfablPwBAHyMpJDROu9hnZCbLLkvXrrUFFDiqyX5ZBFPUNCbDav0S2ioDKauVNpZCqyJBYYL0UR3DpaLMAd0kZAGx9p8t18NJyC7hNzXvZAMh01IHeZBd1TTEPHPtOerLceC1IuTC3R6J6ieWBBZCZClh5xNJPjZCEQF4EZBRmqZAluxRPvdEY1kNLJyvVpvjnELTu9AhjvFwZDZD';
//		$facebookData = array();
//		$facebookData['consumer_key'] = '1138054506714364';
//		$facebookData['consumer_secret'] = '4421463704530436';
//
//		$title = 'Test post';
//		$targetUrl = 'https://xtf.com.ua';
//		$imgUrl = 'http://fbap.local/wp-content/uploads/2021/06/504_image_1.jpg';
//		$description = 'Dette fantastiske poolhus med stort aktivitetsrum og eksklusivt poolområde danner de bedste rammer for en god ferie.';
//
//		$facebook = new FacebookApi($facebookData);
//		$facebook->share($title, $targetUrl, $imgUrl, $description, $access_token);

//		$fb = new Facebook([
//			'app_id' => '1138054506714364',
//			'app_secret' => '1dc957c34e798212bcfe8a212d727ce4',
//			'default_graph_version' => 'v2.10',
//		]);
//
//		$data = [
//			'message' => 'My awesome photo upload example.',
//			'source' => $fb->fileToUpload('http://fbap.local/wp-content/uploads/2021/06/504_image_1.jpg'),
//		];
//
//		try {
//			// Returns a `Facebook\FacebookResponse` object
//			$response = $fb->post('/me/photos', $data, 'EAAQLDfablPwBAHyMpJDROu9hnZCbLLkvXrrUFFDiqyX5ZBFPUNCbDav0S2ioDKauVNpZCqyJBYYL0UR3DpaLMAd0kZAGx9p8t18NJyC7hNzXvZAMh01IHeZBd1TTEPHPtOerLceC1IuTC3R6J6ieWBBZCZClh5xNJPjZCEQF4EZBRmqZAluxRPvdEY1kNLJyvVpvjnELTu9AhjvFwZDZD');
//		} catch(FacebookResponseException $e) {
//			echo 'Graph returned an error: ' . $e->getMessage();
//			exit;
//		} catch(FacebookSDKException $e) {
//			echo 'Facebook SDK returned an error: ' . $e->getMessage();
//			exit;
//		}
//
//		$graphNode = $response->getGraphNode();
//
//		echo 'Photo ID: ' . $graphNode['id'];

	}

	public function fb_login() {

	}
}