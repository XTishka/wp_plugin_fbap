<?php

function show_delete_group( $group ) { ?>
	<div id="wpbody-content">
		<div class="wrap">

			<h1 class="wp-heading-inline">Affiliate groups</h1>
			<a href="?page=fbap&tab=new-group" class="page-title-action">Add New</a>

			<hr class="wp-header-end">

			<?php fbap_tabs_menu( 'groups' ) ?>

			<div class="clear"></div>
			<h1>Are you sure you want to remove this group?</h1>

			<div class="mt-5 p-5 bg-white w-50p rounded">
				<div class="flex border-bottom border-bottom-dashed border-gray-300">
					<p class="font-bold w-50p">Display name:</p>
					<p class="w-50p"><?= $group->display_name ?></p>
				</div>
				<div class="flex border-bottom border-bottom-dashed border-gray-300">
					<p class="font-bold w-50p">Partner URL:</p>
					<p class="w-50p"><?= $group->url ?></p>
				</div>
				<div class="flex border-bottom border-bottom-dashed border-gray-300">
					<p class="font-bold w-50p">API info:</p>
					<p class="w-50p"><?= $group->api ?></p>
				</div>

				<form method="post" action="" style="margin-top: 40px;">
					<input type="hidden" name="action" value="delete_group">
					<input type="hidden" name="confirm" value="true">
					<div class="flex justify-between">
						<button class="button button-danger">Confirm</button>
						<a href="?page=fbap&tab=groups"  class="button button-primary">Back</a>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php }