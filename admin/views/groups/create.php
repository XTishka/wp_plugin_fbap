<?php

function show_create_group( $post, $errors = null ) { ?>

	<div id="wpbody-content">
		<div class="wrap">

			<h1 class="wp-heading-inline">Affiliate groups</h1>
			<a href="?page=fbap&tab=new-group" class="page-title-action">Add New</a>

			<hr class="wp-header-end">

			<?php fbap_tabs_menu('groups') ?>

			<div class="clear"></div>
			<h1>Create new group</h1>

			<?php if ( $post and $errors != null ) : ?>

				<div class="notice notice-error is-dismissible">
					<ul class="list-disc m-4">
						<?php foreach ( $errors->firstOfAll() as $error ) : ?>
							<li><?= $error ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form method="post" action="">
				<input type="hidden" name="action" value="create_group">

				<table class="form-table" role="presentation">

					<tbody>
					<tr>
						<th scope="row">
							<label for="display_name">Display name</label>
						</th>
						<td>
							<input name="display_name"
							       type="text"
							       id="display_name"
							       value="<?php if ( $post )
								       echo $post['display_name'] ?>"
							       class="regular-text">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="url">Partners URL</label>
						</th>
						<td>
							<input name="url"
							       type="url"
							       id="url"
							       value="<?php if ( $post )
								       echo $post['url'] ?>"
							       class="regular-text">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="api">API</label>
						</th>
						<td>
							<input name="api"
							       type="text"
							       id="api"
							       value="<?php if ( $post )
								       echo $post['api'] ?>"
							       class="regular-text">
						</td>
					</tr>

					</tbody>
				</table>


				<p class="submit">
					<input type="submit"
					       name="submit"
					       id="submit"
					       class="button button-primary"
					       value="Create group">
				</p>
			</form>

		</div>
	</div>

<?php }