<?php

use Rakit\Validation\Validator;

function validateNewPartner( $post ) {
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