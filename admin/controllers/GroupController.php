<?php

namespace fbap\admin\controllers;

use fbap\admin\repositories\GroupRepository;
use fbap\admin\validators\GroupValidator;

class GroupController {

	public function index() {
		$partners = new GroupRepository();
		show_index_group( $partners->getAllGroups() );
	}

	public function create() {
		if ( $_POST ) {
			$validation = new GroupValidator();
			if ( $validation->validateNewGroup( $_POST )->fails() ) {
				show_create_group( $_POST, $validation->validateNewGroup( $_POST )->errors() );
			} else {
				$partners = new GroupRepository();
				$partners->insertGroup( $_POST );
				show_index_group( $partners->getAllGroups() );
			}
		} else {
			show_create_group( $_POST );
		}
	}

	public function update( $id ) {
		$request = new GroupRepository();
		$partner = $request->getGroupByID( $id );
		if ( $partner ) {
			if ( $_POST ) {
				$validation = new GroupValidator();
				if ( $validation->validateGroup( $_POST )->fails() ) {
					show_update_group( $partner[0], $_POST, $validation->validateNewGroup( $_POST )->errors() );
				} else {
					$partners = new GroupRepository();
					$partners->updateGroup( $id, $_POST );
					show_index_group( $partners->getAllGroups() );
				}
			} else {
				show_update_group( $partner[0], $_POST );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}

	public function trash( $id ) {
		$request = new GroupRepository();
		$partner = $request->getGroupByID( $id );
		if ( $partner ) {
			if ( $_POST and $_POST['confirm'] == 'true' ) {
				$partners = new GroupRepository();
				$partners->trashGroup($id);
				show_index_group( $partners->getAllGroups() );
			} else {
				show_delete_group( $partner[0] );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}

	public function delete( $id ) {
		$request = new GroupRepository();
		$partner = $request->getGroupByID( $id );
		if ( $partner ) {
			if ( $_POST and $_POST['confirm'] == 'true' ) {
				$partners = new GroupRepository();
				$partners->deleteGroup($id);
				show_index_group( $partners->getAllGroups() );
			} else {
				show_delete_group( $partner[0] );
			}
		} else {
			echo 'No partners found by this ID: ' . $id;
		}
	}
}