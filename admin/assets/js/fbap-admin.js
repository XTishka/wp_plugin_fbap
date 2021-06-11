let $ = jQuery.noConflict();

$(function () {

	getEditedPostTitle();
	getEditedPostPrice();
	getEditedPostDescription();
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
