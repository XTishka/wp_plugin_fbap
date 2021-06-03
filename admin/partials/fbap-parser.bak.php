<?php

use PHPHtmlParser\Dom;

//function parse( $url ) {
//	$dom = new Dom;
//	$dom->loadFromUrl( $url );
//
//	$data   = [];
//	$images = [];
//
//	$titleElement = $dom->find( 'div.item-description h1' )[0];
//	if ( $titleElement ) {
//		$data['title'] = $titleElement->text;
//	}
//
//	$priceElemenent = $dom->find( 'span.price' )[0];
//	if ( $priceElemenent ) {
//		$data['price'] = $priceElemenent->text;
//	}
//
//	$descriptionElement = $dom->find( 'div.item-description div' )[0];
//	if ( $descriptionElement ) {
//		$data['description'] = $descriptionElement->text;
//		$data['excerpt']     = mb_strimwidth( $data['description'], 0, 200 );
//	}
//
//	$imageElements = $dom->find( 'a.fresco' );
//	foreach ( $imageElements as $image ) {
//		$images[] = $image->getAttribute( 'href' );
//	}
//	$data['images'] = $images;
//
//	$data['url'] = $url;
//
//	return $data;
//}

add_action( 'admin_action_wpse10500', 'wpse10500_admin_action' );
function wpse10500_admin_action() {
	// Do your stuff here
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit();
}

function wpse10500_do_page() {
	?>
    <form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
        <input type="hidden" name="action" value="wpse10500"/>
        <input type="submit" value="Do it!"/>
    </form>
	<?php
}

function fbap_affiliate_ads() { ?>

    <div id="wpbody" role="main">

        <div id="wpbody-content">
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    Affiliate ads
                </h1>
                <a href="#" class="page-title-action">Add New</a>

                <hr class="wp-header-end">

                <h2 class="screen-reader-text">Filter pages list</h2>

                <ul class="subsubsub">
                    <li class="fbap-ads">
                        <a href="#" class="current" aria-current="page">
                            Affiliate ads <span class="count">(79)</span>
                        </a> |
                    </li>

                    <li class="fbap-partners">
                        <a href="#" aria-current="page">
                            Affiliate partners <span class="count">(3)</span>
                        </a> |
                    </li>

                    <li class="fbap-fb-groups">
                        <a href="#" aria-current="page">
                            Facebook groups <span class="count">(4)</span>
                        </a> |
                    </li>

                    <li class="fbap-settings">
                        <a href="#" aria-current="page">
                            Settings
                        </a>
                    </li>
                </ul>

                <div class="clear"></div>


                <div class="flex">
                    <div class="w-50p">
						<?php
						$post        = $_POST;
						$previewLink = '';
						$dataForm    = false;
						if ( $post and $post['action'] == 'preview' and $post['fbap_affiliate_url'] ) {
							$previewLink = $post['fbap_affiliate_url'];
							$data        = parse( $previewLink );
							$dataForm    = true;
						}
						?>
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
                                               value="<?= $previewLink ?>"
                                               class="regular-text w-full">
                                        <button class="button button-primary" type="submit">Get preview</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>

						<?php if ( $dataForm == true ) : ?>
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
                                                   value="<?= $data['url'] ?>"
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
                                                <option selected="selected" value="subscriber">Select</option>
                                                <option value="feriehusudlejning">SJ Feriehusudlejning</option>
                                                <option value="dancenter">DanCenter</option>
                                                <option value="luksushuse">Luksushuse</option>
                                            </select>
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
						<?php if ( $dataForm == true ) : ?>
                            <div class="preview-box">
                                <div class="header">
                                    <div class="fbap-logo">
                                        <img src="<?= plugin_dir_url( dirname( __FILE__ ) ) . 'img/logo-100x100.png'; ?>">
                                    </div>
                                    <div class="fbap-title">
                                        <h4>Ferieboligsiden.dk</h4>
                                        <p><?= date( 'F j' ); ?> at <?= date( 'h:i A' ); ?></p>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2>
										<?= $data['title'] ?> / <?= $data['price'] ?> kr
                                    </h2>
                                    <p><?= $data['excerpt'] ?> ...</p>
                                    <img src="<?= $data['images'][0] ?>" alt="" class="w-full">
                                    <div class="images flex">
                                        <img src="<?= $data['images'][1] ?>" alt="" class="w-50p">
                                        <img src="<?= $data['images'][2] ?>" alt="" class="w-50p">
                                    </div>
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>


                <div class="clear"></div>
            </div>


            <div class="clear"></div>
        </div><!-- wpbody-content -->
        <div class="clear"></div>
    </div>


	<?php
}