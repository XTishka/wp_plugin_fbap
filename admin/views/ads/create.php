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

                    <div class="mt-5 bg-white w-full rounded">
                        <div class="bg-gray-100 p-3">
                            <h2 class="leading-4 m-0">1. Parse affiliates page</h2>
                        </div>
                        <form method="POST" action="" class="p-3">
                            <input type="hidden" name="action" value="preview">

                            <div class="flex align-center">
                                <p class="font-bold w-30p">Affiliate partner:</p>
                                <p class="w-70p">
                                    <select name="affiliate_partner_id" id="affiliate_partner_id" class="w-full">
										<?php foreach ( $partners as $partner ) : ?>
											<?php $selected = $partner->id == $data['affiliate_partner_id'] ? 'selected' : ''; ?>
                                            <option value="<?= $partner->id ?>" <?= $selected ?>>
												<?= $partner->display_name ?>
                                            </option>
										<?php endforeach; ?>
                                    </select>
                                </p>
                            </div>

                            <div class="flex align-center">
                                <p class="font-bold w-30p">URL of affiliate ad:</p>
                                <p class="flex w-70p">
                                    <input name="fbap_affiliate_url"
                                           type="text"
                                           id="fbap_affiliate_url"
                                           value="<?= $data['parser']['url'] ?>"
                                           class="regular-text w-full">
                                    <button class="button button-primary" type="submit">Get preview</button>
                                </p>
                            </div>
                        </form>
                    </div>

					<?php if ( $data['show_form'] == true ) : ?>
                        <div class="mt-5 bg-white w-full rounded">
                            <div class="bg-gray-100 p-3">
                                <h2 class="leading-4 m-0">2. Create post</h2>
                            </div>
                            <form method="POST" action="" class="p-3">
                                <input type="hidden" name="action" value="create_post">
                                <input type="hidden" name="image_1" value="<?= $data['parser']['images'][0] ?>">
                                <input type="hidden" name="image_2" value="<?= $data['parser']['images'][1] ?>">
                                <input type="hidden" name="image_3" value="<?= $data['parser']['images'][2] ?>">
                                <input type="hidden" name="affiliate_partner_id" value="<?= $data['affiliate_partner_id'] ?>">
                                <input type="hidden" name="fbap_affiliate_url" value="<?= $data['parser']['url'] ?>">

                                <div class="flex align-center">
                                    <p class="font-bold w-30p">Title:</p>
                                    <p class="w-70p">
                                        <input name="fbap_post_title"
                                               type="text"
                                               id="fbap_post_title"
                                               value="<?= $data['parser']['title'] ?>"
                                               class="regular-text w-full">
                                    </p>
                                </div>

                                <div class="flex align-center">
                                    <p class="font-bold w-30p">Price:</p>
                                    <p class="w-70p">
                                        <input name="fbap_post_price"
                                               type="text"
                                               id="fbap_post_price"
                                               value="<?= $data['parser']['price'] ?> kr"
                                               class="regular-text w-full">
                                    </p>
                                </div>

                                <div class="flex">
                                    <p class="font-bold w-30p">Description:</p>
                                    <p class="w-70p">
                                        <textarea name="fbap_post_description"
                                                  rows="10"
                                                  id="fbap_post_description"
                                                  class="regular-text w-full"><?= $data['parser']['description'] ?></textarea>
                                    </p>
                                </div>

                                <div class="flex justify-flex-end">
                                    <input type="submit"
                                           name="submit"
                                           id="submit"
                                           class="button button-primary"
                                           value="Publicate">
                                </div>
                            </form>
                        </div>
					<?php endif; ?>
                </div>

                <div class="w-50p flex justify-center preview-wrap">
					<?php if ( $data['show_form'] == true ) : ?>
                        <div class="preview-box">
                            <div class="bg-white">
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
                                        <span class="title"><?= $data['parser']['title'] ?></span> /
                                        <span class="price"><?= $data['parser']['price'] ?></span>
                                    </h2>
                                    <p  class="description"><?= $data['parser']['excerpt'] ?> ...</p>
                                    <img src="<?= $data['parser']['images'][0] ?>" alt="" class="w-full">
                                    <div class="images flex">
                                        <img src="<?= $data['parser']['images'][1] ?>" alt="" class="w-50p">
                                        <img src="<?= $data['parser']['images'][2] ?>" alt="" class="w-50p">
                                    </div>
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