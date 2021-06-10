<?php

namespace fbap\admin\controllers;

use fbap\admin\repositories\GroupRepository;
use fbap\admin\repositories\PartnerRepository;
use fbap\admin\services\AdService;

class AdController {

	public function index() {
		show_index_ads();
	}

	public function create() {
		$post     = $_POST;
		$partners = new PartnerRepository();
		$groups   = new GroupRepository();
		$service  = new AdService();

		$data['parser']['url'] = '';
		$data['show_form']     = false;
		if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] ) {
			$url               = $post['fbap_affiliate_url'];
			$data['show_form'] = true;
			$data['parser']    = $service->parse( $url );
			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		if ( ! $post ) {
			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		// Create post and image upload
		if ( $post and $post['action'] == 'create_post' ) {
			$service        = new AdService();
			$post['id']     = $service->createPost( $post );
			$post['images'] = $service->uploadPostImages( $post );
			$service->connectImagesToPost($post['id'], $post['images']);
			$service->addPostMeta($post);

			echo '<pre>';
			print_r( $post );
			echo '</pre>';


			show_update_ads( get_post( $post['id'] ) );
		}
	}
}