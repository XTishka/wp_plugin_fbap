<?php

function affiliate_partners_create( $post, $errors = null ) { ?>
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
                           type="url"
                           id="url"
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
<?php }