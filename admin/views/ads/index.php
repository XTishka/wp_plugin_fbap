<?php

function show_index_ads($ads) { ?>

	<div id="wpbody-content">
		<div class="wrap">

			<h1 class="wp-heading-inline">Affiliate ads</h1>
			<a href="?page=fbap&tab=create-ad" class="page-title-action">Add New</a>

			<hr class="wp-header-end">

            <?php fbap_tabs_menu('ads') ?>

            <div class="clear"></div>

            <table class="wp-list-table widefat fixed striped table-view-list users mt-5">
                <thead>
                <tr>

                    <th scope="col" id="username" class="manage-column column-username column-primary sortable desc w-20p">
                        <a href="#">
                            <span>Title</span>
                        </a>
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Description
                    </th>

                    <th scope="col" class="manage-column column-name" style="width: 150px">
                        Image
                    </th>

                    <th scope="col" class="manage-column column-name w-10p">
                        Facebook groups
                    </th>

                    <th scope="col" class="manage-column column-name w-10p">
                        Affiliate partner
                    </th>

                    <th scope="col" class="manage-column column-name w-10p">
                        Created at
                    </th>

                    <th scope="col" class="manage-column column-name" style="width: 50px">
                        Clicks
                    </th>
                </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:user">

				<?php foreach ($ads as $ad) : ?>
                    <tr id="group-<?= $ad->id ?>">

                        <td class="username column-username has-row-actions column-primary" data-colname="title">
                            <strong>
                                <a href="?page=fbap&tab=update-ad&id=<?= $ad->id ?>">
									<?= $ad->title ?>
                                </a>
                            </strong>
                            <br>
                            <div class="row-actions">
                                <span class="edit"> <a href="?page=fbap&tab=update-ad&id=<?= $ad->id ?>"> Edit </a> | </span>
                                <span class="edit"> <a href="<?= $ad->post_url ?>" target="_blank"> View post </a> | </span>
                                <span class="edit"> <a href="<?= $ad->affiliate_link ?>" target="_blank"> View affiliate link </a></span>
                            </div>
                        </td>

                        <td class="name column-name" data-colname="description">
                            <?php $description = mb_strimwidth( $ad->description, 0, 250 ); ?>
                            <span aria-hidden="true"><?= substr ($description, 0, strrpos($description, ' ')); ?> ...</span>
                        </td>

                        <td class="name column-name" data-colname="image">
                            <?php $images = json_decode($ad->images) ?>
                            <span aria-hidden="true">
                                <img src="<?= $images->image_1->url ?>" alt="<?= $ad->title ?>" style="width: 100%">
                            </span>
                        </td>

                        <td class="name column-name" data-colname="groups">
                           groups
                        </td>

                        <td class="name column-name" data-colname="partner">
                            <a href="?page=fbap&tab=update-partner&id=<?= $ad->partner_id ?>">
		                        <?= $ad->partner_name ?>
                            </a>
                        </td>

                        <td class="name column-name" data-colname="created at">
                                <span aria-hidden="true"> <?= $ad->created_at ?> </span>
                        </td>

                        <td class="name column-name" data-colname="clicks">
                            <span aria-hidden="true"> <?= $ad->clicks ?> </span>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>

                <tfoot>
                <tr>

                    <th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
                        <a href="#">
                            <span>Title</span>
                        </a>
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Description
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Image
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Facebook groups
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Affiliate partner
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Created at
                    </th>

                    <th scope="col" class="manage-column column-name">
                        Clicks
                    </th>
                </tr>
                </tfoot>

            </table>

            <pre>
                <?php print_r($ads) ?>
            </pre>


		</div>
	</div>

<?php }