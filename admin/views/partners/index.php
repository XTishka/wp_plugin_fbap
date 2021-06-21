<?php

function show_index_partner( $data ) {
	?>

    <div id="wpbody-content">
        <div class="wrap">

            <h1 class="wp-heading-inline">Affiliate partners</h1>
            <a href="?page=fbap&tab=create-partner" class="page-title-action">Add New</a>

            <hr class="wp-header-end">

			<?php fbap_tabs_menu('partners') ?>

            <div class="clear"></div>

            <table class="wp-list-table widefat striped table-view-list users mt-5">
                <thead>
                <tr>

                    <th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
                        <a href="#">
                            <span>Partners name</span>
                        </a>
                    </th>

                    <th scope="col" class="manage-column column-name">
                        API info
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Partner ID
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Program ID
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Special URL String
                    </th>
                </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:user">

		        <?php foreach ($data as $partner) : ?>
                    <tr id="partner-<?= $partner->id ?>">

                        <td class="username column-username has-row-actions column-primary" data-colname="Display name">
                            <strong>
                                <a href="?page=fbap&tab=update-partner&id=<?= $partner->id ?>">
							        <?= $partner->display_name ?>
                                </a>
                            </strong>
                            <br>
                            <div class="row-actions">
                                <span class="edit"> <a href="?page=fbap&tab=update-partner&id=<?= $partner->id ?>"> Edit </a> | </span>
                                <span class="trash"><a href="?page=fbap&tab=trash-partner&id=<?= $partner->id ?>" class="submitdelete">Trash</a></span>
                            </div>
                        </td>

                        <td class="name column-name" data-colname="API">
                            <span aria-hidden="true"><?= $partner->api ?></span>
                        </td>

                        <td class="name column-name" data-colname="Partner ID">
                            <span aria-hidden="true"><?= $partner->partner_id ?></span>
                        </td>

                        <td class="name column-name" data-colname="Program ID">
                            <span aria-hidden="true"><?= $partner->program_id ?></span>
                        </td>

                        <td class="name column-name" data-colname="Special link">
                            <span aria-hidden="true"><?= $partner->link ?></span>
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
                        Special URL String
                    </th>

                    <th scope="col" class="manage-column column-name">
                        API info
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Partner ID
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Program ID
                    </th>
                </tr>
                </tfoot>

            </table>

        </div>
    </div>

<?php }