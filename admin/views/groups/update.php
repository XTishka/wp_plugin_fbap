<?php

function show_update_group( $group, $post, $errors = null ) {
	$display_name = $post ? $post['display_name'] : $group->display_name;
	$url          = $post ? $post['url'] : $group->url;
	$members      = $post ? $post['members_qty'] : $group->members_qty;
	$fb_group_id  = $post ? $post['fb_group_id'] : $group->fb_group_id;
	?>

    <div id="wpbody-content">
        <div class="wrap">

            <h1 class="wp-heading-inline">Affiliate groups</h1>
            <a href="?page=fbap&tab=new-group" class="page-title-action">Add New</a>

            <hr class="wp-header-end">

			<?php fbap_tabs_menu( 'groups' ) ?>

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
                                   value="<?= $display_name ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="url">Group members</label>
                        </th>
                        <td>
                            <input name="members_qty"
                                   type="members_qty"
                                   id="members_qty"
                                   value="<?= $members ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="api">Group ID</label>
                        </th>
                        <td>
                            <input name="fb_group_id"
                                   type="text"
                                   id="api"
                                   value="<?= $fb_group_id ?>"
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
                           value="Update group">
                </p>
            </form>

        </div>
    </div>

<?php }