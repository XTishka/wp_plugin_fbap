let $ = jQuery.noConflict();

$(function () {

	getEditedPostTitle();
	getEditedPostPrice();
	getEditedPostDescription();
	getEditedPostImage();
	// toggleScheduleForm();
	toggleBlocks();
	toggleTradetrackerReference();
});

function getEditedPostTitle() {
	let postTitle = $('#fbap_post_title');
	let fbPreviewTitle = $('.preview-box .title');

	postTitle.on('input', function() {
		fbPreviewTitle.text($(this).val());
	});
}

function getEditedPostPrice() {
	let postPrice = $('#fbap_post_price');
	let postPreviewPrice = $('.preview-box .price');

	postPrice.on('input', function() {
		postPreviewPrice.text($(this).val());
	});
}

function getEditedPostDescription() {
	let postDescription = $('#fbap_post_description');
	let postPreviewDescription = $('.preview-box .description');

	postDescription.on('input', function() {
		postPreviewDescription.text($(this).val().substring(0, 200) + '...');
	});
}

function getEditedPostImage() {
	let postImage = $('#fbap_post_image');
	let postPreviewImage = $('.image-preview');

	postImage.on('input', function() {
		postPreviewImage.attr('src', postImage.val());
	});
}

function toggleScheduleForm() {
	let formClass = $('.publications-schedule-form');

	for (let i = 1; i <= formClass.length; i++) {
		$('#fb-group-' + i).on('click', function () {
			$('.schedule-edit-' + i).toggle();
		});
	}
}

function toggleBlocks() {
	for (let i = 1; i <= 4; i++) {
		$('.toggle-header-' + i).on('click', function () {
			$('.toggled-content-' + i).toggle();
		});
	}
}

function toggleTradetrackerReference() {
	let tradetrackerCheckbox = $('#tradetracker');
	let subfield = $('.tradetrecker-field');

	tradetrackerCheckbox.click(function(){
		console.log('click...');
		if(tradetrackerCheckbox.prop('checked')) {
			console.log('reference checked');
			subfield.show();
		} else {
			subfield.hide();
		}
	});
}

