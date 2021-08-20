<?php

namespace fbap\admin\validators;

use Rakit\Validation\Validator;

class GroupValidator {

	public function validateNewGroup( $post ) {
		$validator = new Validator;

		$validation = $validator->validate( $post + $_FILES, [
			'display_name' => 'required',
			'fb_group_id'  => 'required|numeric',
		] );

		return $validation;
	}

	public function validateGroup( $post ) {
		$validator = new Validator;

		$validation = $validator->validate( $post + $_FILES, [
			'display_name' => 'required',
			'fb_group_id'  => 'required|numeric',
		] );

		return $validation;
	}
}