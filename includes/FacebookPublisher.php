<?php


use Facebook\Exceptions\FacebookResponseException as ResponseException;
use Facebook\Exceptions\FacebookSDKException as SDKException;
use Facebook\Facebook;
use fbap\admin\repositories\AdRepository;
use fbap\admin\repositories\ScheduleRepository;
use fbap\admin\repositories\GroupRepository;

add_action( 'publish_link_to_fb_action_hook', 'publish_link_to_fb' );

function publish_link_to_fb( $scheduleId ) {
	$scheduleRepository = new ScheduleRepository();
	$adRepository       = new AdRepository();
	$groupRepository    = new GroupRepository();

	$schedule = $scheduleRepository->getScheduleByID( $scheduleId );
	$ad       = $adRepository->getAdByID( $schedule->ad_id );
	$group    = $groupRepository->getGroupByID( $schedule->group_id );

	$fb = new Facebook( array(
		'app_id'     => esc_attr( get_option( 'fbap_app_id' ) ),
		'app_secret' => esc_attr( get_option( 'fbap_app_secret' ) ),
		'cookie'     => true
	) );

	$scheduleRepository->updateScheduleStatus($scheduleId, 'published');

	try {
		$response = $fb->post(
			'/' . $group[0]->fb_group_id . '/feed',
			[
				'message' => 'Reklame for: ' . $ad->title . '
				' . $ad->price . '
				
				Book direkte gennem vores samarbejdspartner via link herunder: ' . $ad->post_url . '
				
				' . strip_tags($ad->description),
				'link'    => $ad->post_url,
			],
			esc_attr( get_option( 'fbap_app_token' ) )
		);
	} catch ( ResponseException $e ) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch ( SDKException $e ) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$response->getGraphNode();
	exit();
}


function publish_photo_to_fb( $scheduleId ) {
	$link_1       = 'https://www.dancenter.dk/tradetracker/?ag=32878_12_392653_&tt=9990763_&r=%2Fsommerhus%2Fostjylland%2Fdjursland-mols%2Fbegtrup-vig%2F40948%2F%3Fperiod=20210619-7';
	$link_2       = 'https://fbpa.xtf.com.ua/affiliate-ads/skont-luksussommerhus-i-nordsjaelland-med-plads-til-22-personer/';
	$access_token = 'EAAlHgYpschYBANykP1kG1ZC0cReNZCo8jtynclSYflqVoiprRLZAUGSZB2bqaB8x3eaRYCOhyqDZCisdmKCEsPOOZAjHVPHFTGzafJFZAqmhhvA95vb4f4woC1rTUZBOTvBqZAdtt0oxlBBBJN9hIvYQUw0oc09dVz1BZCGUIaI6Lx0izEJWS2KAujXTjfGmBYOckCFALwX4sTkmEynLNhcFNklS2YQiMptIwfe0KKvAV6vxfKugkefWMp';
	$appid        = '2611896489112086';
	$appsecret    = 'd6864a049b91c74f32e78577f1e0cdab';

	$fb = new Facebook( array(
		'app_id'     => $appid,
		'app_secret' => $appsecret,
		'cookie'     => true
	) );

	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post(
			'/1272033619859187/feed',
			[
				'message' => 'test post link :: ' . $scheduleId,
				//	            'source' => $fb->fileToUpload('https://fbpa.xtf.com.ua/wp-content/uploads/2021/06/175_image_1.jpg'),
				'link'    => $link_2,
			],
			$access_token
		);
	} catch ( ResponseException $e ) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch ( SDKException $e ) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$graphNode = $response->getGraphNode();
}

