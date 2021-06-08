<?php

function show_index_ads() { ?>

	<div id="wpbody-content">
		<div class="wrap">

			<h1 class="wp-heading-inline">Affiliate ads</h1>
			<a href="?page=fbap&tab=create-ad" class="page-title-action">Add New</a>

			<hr class="wp-header-end">

            <?php fbap_tabs_menu('ads') ?>


		</div>
	</div>

<?php }