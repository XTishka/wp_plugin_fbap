<?php

use fbap\admin\controllers\AdController;
use fbap\admin\controllers\PartnerController;
use fbap\admin\controllers\GroupController;

function fbap_routing() { ?>
	<?php

	$default_tab = 'ads';
	$tab         = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;
	$id         = isset( $_GET['id'] ) ? $_GET['id'] : null;

	if ( $tab == 'ads') {
		$controller = new AdController();
		$controller->index();
	}

	if ( $tab == 'create-ad') {
		$controller = new AdController();
		$controller->create();
	}

	if ( $tab == 'partners') {
		$controller = new PartnerController();
		$controller->index();
	}

	if ( $tab == 'create-partner') {
		$controller = new PartnerController();
		$controller->create();
	}

	if ( $tab == 'update-partner') {
		$controller = new PartnerController();
		$controller->update($id);
	}

	if ( $tab == 'trash-partner') {
		$controller = new PartnerController();
		$controller->trash($id);
	}

	if ( $tab == 'groups') {
		$controller = new GroupController();
		$controller->index();
	}

	if ( $tab == 'create-group') {
		$controller = new GroupController();
		$controller->create();
	}

	if ( $tab == 'update-group') {
		$controller = new GroupController();
		$controller->update($id);
	}

	if ( $tab == 'trash-group') {
		$controller = new GroupController();
		$controller->trash($id);
	}
}