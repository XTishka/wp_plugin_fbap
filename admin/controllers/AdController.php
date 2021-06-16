<?php

namespace fbap\admin\controllers;

use fbap\admin\repositories\GroupRepository;
use fbap\admin\repositories\PartnerRepository;
use fbap\admin\repositories\ScheduleRepository;
use fbap\admin\services\AdService;
use fbap\admin\repositories\AdRepository;

class AdController {

	public function index() {
		$repository = new AdRepository();
		$groupRepository = new GroupRepository();
		$partnerRepository = new PartnerRepository();
		$scheduleRepository = new ScheduleRepository();

		show_index_ads( $repository->getAllAds(), $groupRepository, $partnerRepository, $scheduleRepository );
	}

	public function create() {
		$post     = $_POST;
		$partners = new PartnerRepository();
		$groups   = new GroupRepository();
		$service  = new AdService();

		$data['parser']['url'] = '';
		$data['show_form']     = false;

		if ( ! $post ) {
			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] and $post['affiliate_partner_id'] ) {
			$url                          = $post['fbap_affiliate_url'];
			$data['show_form']            = true;
			$data['parser']               = $service->parse( $url );
			$data['affiliate_partner_id'] = $post['affiliate_partner_id'];

			show_create_ad( $data, $partners->getAllPartners(), $groups->getAllGroups() );
		}

		// Create post and image upload
		if ( $post and $post['action'] == 'create_post' ) {
			$service    = new AdService();
			$repository = new AdRepository();

			$partner                        = $partners->getPartnerByID( $post['affiliate_partner_id'] )[0];
			$post['post_id']                = $service->createPost( $post );
			$post['images']                 = $service->uploadPostImages( $post );
			$post['affiliate_partner_name'] = $partner->display_name;
			$publication                    = get_post( $post['post_id'] );
			$post['post_url']               = $publication->guid;
			$post['affiliate_link']         = $post['fbap_affiliate_url'];
			$service->connectImagesToPost( $post['post_id'], $post['images'] );
			$service->addPostMeta( $post );
			$repository->insertAd( $post );

			$adsRepository = new AdRepository();
			$groupRepository = new GroupRepository();
			$partnerRepository = new PartnerRepository();
			$scheduleRepository = new ScheduleRepository();
			show_index_ads( $adsRepository->getAllAds(), $groupRepository, $partnerRepository, $scheduleRepository  );
		}
	}

	public function update( $id ) {
		$repository = new AdRepository();
		$service = new AdService();
		$partnersRepository = new PartnerRepository();
		$groupsRepository = new GroupRepository();
		$groups = $groupsRepository->getAllGroups();
		$schedulesRepository = new ScheduleRepository();
		$filter = 'waiting';
		if (isset($_GET['filter'])) :
			if ($_GET['filter'] == 'waiting') $filter = 'waiting';
			if ($_GET['filter'] == 'published') $filter = 'published';
			if ($_GET['filter'] == 'trashed') $filter = 'trashed';
			endif;
		$schedules = $service->getFilteredSchedules($id, $filter);

		$ad = $repository->getAdByID( $id );
		$ad->partnersLogo = $partnersRepository->getPartnersLogo($id);
		if ($_POST and $_POST['action'] == 'update_post') {
			$service->updatePost($ad->post_id, $_POST);
			$service->updatePostPrice($ad->post_id, $_POST['fbap_post_price']);
			$repository->updateAd($id, $_POST);
			$ad = $repository->getAdByID( $id );
		}

		if ($_POST and $_POST['action'] == 'create_publication') {
			$schedulesRepository->insertSchedule($_POST);
			$schedules = $service->getFilteredSchedules($id, $filter);
		}

		if ($_POST and $_POST['action'] == 'update_publication_schedule') {
			$schedulesRepository->updateSchedule($_POST);
			$schedules = $service->getFilteredSchedules($id, $filter);
		}

		if (isset($_GET['trash'])) {
			$schedulesRepository->trashSchedule($_GET['trash']);
			$schedules = $service->getFilteredSchedules($id, $filter);
		}

		if ($_POST and $_POST['action'] == 'delete_ad') {

			$service->deletePost($ad->post_id);
			$service->deleteImagesFromMedia($ad);
			$schedules = $schedulesRepository->getAllAdsSchedulesWithTrashed($ad->id);
			foreach ($schedules as $schedule) {
				$schedulesRepository->deleteSchedule($schedule->id);
			}
			$repository->trashAd($ad->id);
		}

		$post = get_post($ad->post_id);
		if ($post) {
			show_update_ads( $ad, $post, $groups, $schedules );
		} else {
			$adsRepository = new AdRepository();
			$groupRepository = new GroupRepository();
			$partnerRepository = new PartnerRepository();
			$scheduleRepository = new ScheduleRepository();
			show_index_ads( $adsRepository->getAllAds(), $groupRepository, $partnerRepository, $scheduleRepository  );
		}
	}
}