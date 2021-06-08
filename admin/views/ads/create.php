<?php

function show_create_ad( $data, $partners, $groups ) { ?>

    <div id="wpbody-content">
        <div class="wrap">

            <h1 class="wp-heading-inline">Affiliate ads</h1>
            <a href="?page=fbap&tab=create-ad" class="page-title-action">Add New</a>

            <hr class="wp-header-end">

			<?php fbap_tabs_menu( 'ads' ) ?>

            <div class="clear"></div>


            <div class="flex">
                <div class="w-50p">

                    <form method="POST" action="">
                        <input type="hidden" name="action" value="preview">
                        <table class="form-table" role="presentation">
                            <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="fbap_affiliate_url">URL of affiliate ad</label>
                                </th>
                                <td class="flex">
                                    <input name="fbap_affiliate_url"
                                           type="text"
                                           id="fbap_affiliate_url"
                                           value="<?= $data['parser']['url'] ?>"
                                           class="regular-text w-full">
                                    <button class="button button-primary" type="submit">Get preview</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>

					<?php if ( $data['show_form'] == true ) : ?>
                        <form method="post" action="#">
                            <input type="hidden" name="option_page" value="general">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" id="_wpnonce" name="_wpnonce" value="48fffd449a">
                            <input type="hidden" name="_wp_http_referer" value="/wp-admin/options-general.php">

                            <table class="form-table" role="presentation">

                                <tbody>
                                <tr>
                                    <th scope="row">
                                        <label for="fbap_affiliate_url">URL of affiliate ad</label>
                                    </th>
                                    <td>
                                        <input name="fbap_affiliate_url"
                                               type="text"
                                               id="fbap_affiliate_url"
                                               value="<?= $data['parser']['url'] ?>"
                                               class="regular-text w-full">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <label for="fbap_free_text">Free text (if any)</label>
                                    </th>
                                    <td>
                                        <input name="fbap_free_text"
                                               type="text"
                                               id="fbap_free_text"
                                               value=""
                                               class="regular-text w-full">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><label for="fbap_affiliate_partner">Affiliate partner</label>
                                    </th>
                                    <td>
                                        <select name="fbap_affiliate_partner" id="fbap_affiliate_partner"
                                                class="w-full">
											<?php foreach ( $partners as $partner ) : ?>
                                                <option value="<?= $partner->id ?>>"><?= $partner->display_name ?></option>
											<?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><label for="fbap_affiliate_partner">Publish date on FB group</label>
                                    </th>
                                    <td class="flex">
                                        <select name="fbap_affiliate_partner" id="fbap_affiliate_partner"
                                                class="w-full">
		                                    <?php foreach ( $groups as $group ) : ?>
                                                <option value="<?= $group->id ?>>"><?= $group->display_name ?></option>
		                                    <?php endforeach; ?>
                                        </select>
                                        <input type="datetime-local" id="start" name="trip-start" value="" >
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row"><label for="fbap_affiliate_partner">Publish date on FB group</label>
                                    </th>
                                    <td class="flex">
                                        <select name="fbap_affiliate_partner" id="fbap_affiliate_partner"
                                                class="w-full">
			                                <?php foreach ( $groups as $group ) : ?>
                                                <option value="<?= $group->id ?>>"><?= $group->display_name ?></option>
			                                <?php endforeach; ?>
                                        </select>
                                        <input type="datetime-local" id="start" name="trip-start" value="" >
                                    </td>
                                    <td class="flex">
                                        <select name="fbap_affiliate_partner" id="fbap_affiliate_partner"
                                                class="w-full">
			                                <?php foreach ( $groups as $group ) : ?>
                                                <option value="<?= $group->id ?>>"><?= $group->display_name ?></option>
			                                <?php endforeach; ?>
                                        </select>
                                        <input type="datetime-local" id="start" name="trip-start" value="" >
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">Published</th>
                                    <td>
                                        <fieldset>
                                            <label for="fbap_ad_published">
                                                <input name="users_can_register"
                                                       type="checkbox"
                                                       class="w-full"
                                                       id="fbap_ad_published"
                                                       value="1">
                                            </label>
                                        </fieldset>
                                    </td>
                                </tr>

                                </tbody>
                            </table>


                            <p class="submit">
                                <input type="submit"
                                       name="submit"
                                       id="submit"
                                       class="button button-primary"
                                       value="Save">
                            </p>
                        </form>
					<?php endif; ?>
                </div>

                <div class="w-50p flex justify-center preview-wrap">
					<?php if ( $data['show_form'] == true ) : ?>
                        <div class="preview-box">
                            <div class="header">
                                <div class="fbap-logo">
                                    <img src="<?= plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/img/logo-100x100.png'; ?>">
                                </div>
                                <div class="fbap-title">
                                    <h4>Ferieboligsiden.dk</h4>
                                    <p><?= date( 'F j' ); ?> at <?= date( 'h:i A' ); ?></p>
                                </div>
                            </div>
                            <div class="content">
                                <h2>
									<?= $data['parser']['title'] ?> / <?= $data['parser']['price'] ?> kr
                                </h2>
                                <p><?= $data['parser']['excerpt'] ?> ...</p>
                                <img src="<?= $data['parser']['images'][0] ?>" alt="" class="w-full">
                                <div class="images flex">
                                    <img src="<?= $data['parser']['images'][1] ?>" alt="" class="w-50p">
                                    <img src="<?= $data['parser']['images'][2] ?>" alt="" class="w-50p">
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
                </div>
            </div>


            <div class="clear"></div>


        </div>
    </div>
<?php }