<?php

function affiliate_partners_index( $data ) {
	?>
    <table class="wp-list-table widefat fixed striped table-view-list users">
        <thead>
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
                    <a href="#">
                        <?= $partner->display_name ?>
                    </a>
                </strong>
                <br>
                <div class="row-actions">
                    <span class="edit"> <a href="#"> Edit </a> | </span>
                    <span class="view"> <a href="#"> View </a> </span>
                </div>
            </td>

            <td class="name column-name" data-colname="URL">
                <span aria-hidden="true"><?= $partner->url ?></span>
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

            <td class="name column-name" data-colname="Special URL String">
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
                Partners URL
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
        </tfoot>

    </table>
<?php }