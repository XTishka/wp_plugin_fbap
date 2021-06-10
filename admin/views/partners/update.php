<?php

function show_update_partner( $partner, $post, $errors = null ) {
	$display_name = $post ? $post['display_name'] : $partner->display_name;
	$url          = $post ? $post['url'] : $partner->url;
	$api          = $post ? $post['api'] : $partner->api;
	$partner_id   = $post ? $post['partner_id'] : $partner->partner_id;
	$program_id   = $post ? $post['program_id'] : $partner->program_id;
	?>

    <div id="wpbody-content">
        <div class="wrap">

            <h1 class="wp-heading-inline">Affiliate partners</h1>
            <a href="?page=fbap&tab=new-partner" class="page-title-action">Add New</a>

            <hr class="wp-header-end">

			<?php fbap_tabs_menu( 'partners' ) ?>

            <div class="clear"></div>
            <h1>Create new partner</h1>

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
                <input type="hidden" name="action" value="create_partner">

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
                                   value="<?= $display_name ?>"
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
                                   value="<?= $url ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="api">API info</label>
                        </th>
                        <td>
                            <input name="api"
                                   type="text"
                                   id="api"
                                   value="<?= $api ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="partner_id">Partner ID</label>
                        </th>
                        <td>
                            <input name="partner_id"
                                   type="numder"
                                   id="partner_id"
                                   value="<?= $partner_id ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="program_id">Program ID</label>
                        </th>
                        <td>
                            <input name="program_id"
                                   type="numder"
                                   id="program_id"
                                   value="<?= $program_id ?>"
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
                           value="Update partner">
                </p>
            </form>

        </div>
    </div>

<?php }