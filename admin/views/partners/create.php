<?php

function show_create_partner( $post, $errors = null ) { ?>

    <div id="wpbody-content">
        <div class="wrap">

            <h1 class="wp-heading-inline">Affiliate partners</h1>
<!--            <a href="?page=fbap&tab=new-partner" class="page-title-action">Add New</a>-->

            <hr class="wp-header-end">

	        <?php fbap_tabs_menu('partners') ?>

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
                                   id="url"
                                   type="url"
                                   value="<?php if ( $post )
						               echo $post['url'] ?>"
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
                                   value="<?php if ( $post )
						               echo $post['api'] ?>"
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
                                   value="<?php if ( $post )
						               echo $post['partner_id'] ?>"
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
                                   value="<?php if ( $post )
						               echo $post['program_id'] ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="program_id">Special link template</label>
                        </th>
                        <td>
                            <input name="link"
                                   id="link"
                                   value="<?php if ( $post )
			                           echo $post['link'] ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="partner_logo">Partner's logo URL</label>
                        </th>
                        <td>
                            <input name="partner_logo"
                                   type="numder"
                                   id="partner_logo"
                                   value="<?php if ( $post )
			                           echo $post['partner_logo'] ?>"
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
                           value="Create partner">
                </p>
            </form>

        </div>
    </div>

<?php }