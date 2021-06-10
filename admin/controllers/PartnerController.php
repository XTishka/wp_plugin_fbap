<?php

namespace fbap\admin\controllers;

use fbap\admin\repositories\PartnerRepository;
use fbap\admin\validators\PartnerValidator;

class PartnerController {

	public function index() {
		$partners = new PartnerRepository();
		show_index_partner( $partners->getAllPartners() );
	}

	public function create() {
		if ( $_POST ) {
			$validation = new PartnerValidator();
			if ( $validation->validateNewPartner( $_POST )->fails() ) {
				show_create_partner( $_POST, $validation->validateNewPartner( $_POST )->errors() );
			} else {
				$partners = new PartnerRepository();
				$partners->insertPartner( $_POST );
				show_index_partner( $partners->getAllPartners() );
			}
		} else {
			show_create_partner( $_POST );
		}
	}

	public function update( $id ) {
		$request = new PartnerRepository();
		$partner = $request->getPartnerByID( $id );
		if ( $partner ) {
			if ( $_POST ) {
				$validation = new PartnerValidator();
				if ( $validation->validatePartner( $_POST )->fails() ) {
					show_update_partner( $partner[0], $_POST, $validation->validateNewPartner( $_POST )->errors() );
				} else {
					$partners = new PartnerRepository();
					$partners->updatePartner( $id, $_POST );
					show_index_partner( $partners->getAllPartners() );
				}
			} else {
				show_update_partner( $partner[0], $_POST );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}

	public function trash( $id ) {
		$request = new PartnerRepository();
		$partner = $request->getPartnerByID( $id );
		if ( $partner ) {
			if ( $_POST and $_POST['confirm'] == 'true' ) {
				$partners = new PartnerRepository();
				$partners->trashPartner($id);
				show_index_partner( $partners->getAllPartners() );
			} else {
				show_delete_partner( $partner[0] );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}

	public function delete( $id ) {
		$request = new PartnerRepository();
		$partner = $request->getPartnerByID( $id );
		if ( $partner ) {
			if ( $_POST and $_POST['confirm'] == 'true' ) {
				$partners = new PartnerRepository();
				$partners->deletePartner($id);
				show_index_partner( $partners->getAllPartners() );
			} else {
				show_delete_partner( $partner[0] );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}
}