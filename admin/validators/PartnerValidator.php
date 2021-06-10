<?php

namespace fbap\admin\validators;

use Rakit\Validation\Validator;

class PartnerValidator {

	public function validateNewPartner($post) {
		$validator = new Validator;

		$validation = $validator->validate( $post + $_FILES, [
			'display_name'        => 'required',
			'url'                 => 'required|',
			'api'                 => '',
			'partner_id'          => 'required|numeric',
			'program_id'          => 'required|numeric',
		] );

		return $validation;
	}

	public function validatePartner($post) {
		$validator = new Validator;

		$validation = $validator->validate( $post + $_FILES, [
			'display_name'        => 'required',
			'url'                 => 'required|',
			'api'                 => '',
			'partner_id'          => 'required|numeric',
			'program_id'          => 'required|numeric',
		] );

		return $validation;
	}
}