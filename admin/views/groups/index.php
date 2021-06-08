<?php

function show_index_group( $data ) {
	?>

	<div id="wpbody-content">
		<div class="wrap">

			<h1 class="wp-heading-inline">Affiliate groups</h1>
			<a href="?page=fbap&tab=create-group" class="page-title-action">Add New</a>

			<hr class="wp-header-end">

			<?php fbap_tabs_menu('groups') ?>

			<div class="clear"></div>

			<table class="wp-list-table widefat fixed striped table-view-list users mt-5">
				<thead>
				<tr>

					<th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
						<a href="#">
							<span>Facebook Group</span>
						</a>
					</th>

					<th scope="col" class="manage-column column-name">
						URL
					</th>

					<th scope="col" class="manage-column column-name">
						API
					</th>
				</tr>
				</thead>

				<tbody id="the-list" data-wp-lists="list:user">

				<?php foreach ($data as $group) : ?>
					<tr id="group-<?= $group->id ?>">

						<td class="username column-username has-row-actions column-primary" data-colname="Display name">
							<strong>
								<a href="?page=fbap&tab=update-group&id=<?= $group->id ?>">
									<?= $group->display_name ?>
								</a>
							</strong>
							<br>
							<div class="row-actions">
								<span class="edit"> <a href="?page=fbap&tab=update-group&id=<?= $group->id ?>"> Edit </a> | </span>
								<span class="trash"><a href="?page=fbap&tab=trash-group&id=<?= $group->id ?>" class="submitdelete">Trash</a></span>
							</div>
						</td>

						<td class="name column-name" data-colname="URL">
							<span aria-hidden="true"><?= $group->url ?></span>
						</td>

						<td class="name column-name" data-colname="API">
							<span aria-hidden="true"><?= $group->api ?></span>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>

				<tfoot>
				<tr>

					<th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
						<a href="#">
							<span>Company name</span>
						</a>
					</th>

					<th scope="col" class="manage-column column-name">
						Partners URL
					</th>

					<th scope="col" class="manage-column column-name">
						API
					</th>
				</tr>
				</tfoot>

			</table>

		</div>
	</div>

<?php }