<?php

use fbap\admin\repositories\GroupRepository;

function show_update_ads( $ad = null, $post, $groups, $schedules ) { ?>

	<?php $groupsRepository = new GroupRepository(); ?>

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
                                <a href="?page=fbap&tab=update-partner&id=<?= $ad->partner_id ?>"><?= $ad->partner_name ?></a>
                            </p>
                        </div>

                        <div class="flex align-center">
                            <p class="font-bold w-30p">URL of affiliate ad:</p>
                            <p class="flex w-70p">
                                <a href="<?= $ad->affiliate_link ?>" target="_blank"><?= $ad->affiliate_link ?></a>
                            </p>
                        </div>

                        <div class="flex align-center">
                            <p class="font-bold w-30p">Post URL:</p>
                            <p class="flex w-70p">
                                <a href="<?= $ad->post_url ?>" target="_blank"><?= $ad->post_url ?></a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="mt-5 bg-white w-full rounded">
                    <div class="bg-gray-100 p-3">
                        <h2 class="leading-4 m-0">2. Update post</h2>
                    </div>
                    <form method="POST" action="" class="p-3">
                        <input type="hidden" name="action" value="update_post">

                        <div class="flex align-center">
                            <p class="font-bold w-30p">Title:</p>
                            <p class="w-70p">
                                <input name="fbap_post_title"
                                       type="text"
                                       id="fbap_post_title"
                                       value="<?= $post->post_title ?>"
                                       class="regular-text w-full">
                            </p>
                        </div>

                        <div class="flex align-center">
                            <p class="font-bold w-30p">Price:</p>
                            <p class="w-70p">
                                <input name="fbap_post_price"
                                       type="text"
                                       id="fbap_post_price"
                                       value="<?= $ad->price ?>"
                                       class="regular-text w-full">
                            </p>
                        </div>

                        <div class="flex">
                            <p class="font-bold w-30p">Description:</p>
                            <p class="w-70p">
                                        <textarea name="fbap_post_description"
                                                  rows="10"
                                                  id="fbap_post_description"
                                                  class="regular-text w-full"><?= $post->post_content ?></textarea>
                            </p>
                        </div>

                        <div class="flex justify-flex-end">
                            <input type="submit"
                                   name="submit"
                                   id="submit"
                                   class="button button-primary"
                                   value="Update">
                        </div>
                    </form>
                </div>

                <div class="mt-5 bg-white w-full rounded">
                    <div class="bg-gray-100 p-3">
                        <h2 class="leading-4 m-0">3. Facebook publications schedule</h2>
                    </div>

                    <div class="p-5">
						<?php $counter = 1 ?>
						<?php foreach ( $schedules as $schedule ) : ?>
                            <div class="border-bottom border-bottom-dashed border-gray-300">
                                <div class="flex align-center">
                                    <h4 id="fb-group-<?= $counter ?>" class="w-60p" style="cursor: pointer;">
										<?= $groupsRepository->getGroupName( $schedule->group_id ) ?>
                                    </h4>
                                    <div class="w-40p" style="text-align: right">
                                        <span class="publication_date"><?= $schedule->publication_time ?></span>
                                    </div>
                                </div>


                                <div id="fb-group-form-<?= $counter ?>" class="schedule-form" style="display: none">
                                    <form method="POST" action="">
                                        <input type="hidden" name="action" value="update_publication">
                                        <input type="hidden" name="ad_id" value="<?= $ad->id ?>">

                                        <div class="flex justify-between align-center">
                                            <select name="fbap_affiliate_partner" id="fbap_affiliate_partner"
                                                    class="w-full">
												<?php foreach ( $groups as $group ) : ?>
                                                    <option value="<?= $group->id ?>>"><?= $group->display_name ?></option>
												<?php endforeach; ?>
                                            </select>
                                            <input type="datetime-local" id="start" name="trip-start" value="">
                                        </div>

                                        <div class="flex justify-flex-end mt-5 mb-5">
                                            <input type="submit"
                                                   name="submit"
                                                   id="submit"
                                                   class="button button-primary"
                                                   value="Update">
                                        </div>
                                    </form>
                                </div>

                            </div>
							<?php $counter ++ ?>
						<?php endforeach; ?>

                        <div id="fb-group-form-create" class="schedule-form-create mt-9 bg-gray-100 p-5">
                            <h2>Add new facebook publication to shedule</h2>
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="create_publication">
                                <input type="hidden" name="ad_id" value="<?= $ad->id ?>">

                                <div class="flex justify-between align-center">
                                    <select name="group_id" id="group_id"
                                            class="w-full">
										<?php foreach ( $groups as $group ) : ?>
                                            <option value="<?= $group->id ?>>"><?= $group->display_name ?></option>
										<?php endforeach; ?>
                                    </select>
                                    <input type="datetime-local" id="publication_time" name="publication_time" value="">
                                </div>

                                <div class="flex justify-flex-end mt-5 mb-5">
                                    <input type="submit"
                                           name="submit"
                                           id="submit"
                                           class="button button-primary"
                                           value="Add to schedule">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="w-50p flex justify-center preview-wrap">
				<?php $description = mb_strimwidth( $ad->description, 0, 200 ); ?>
				<?php $images = json_decode( $ad->images ) ?>

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
                                <span class="title"><?= $post->post_title ?></span> /
                                <span class="price"><?= $ad->price ?></span>
                            </h2>

                            <p class="description"><?= substr( $description, 0, strrpos( $description, ' ' ) ); ?>
                                ...</p>
                            <img src="<?= $images->image_1->url ?>" alt="" class="w-full">
                            <div class="images flex">
                                <img src="<?= $images->image_2->url ?>" alt="" class="w-50p">
                                <img src="<?= $images->image_3->url ?>" alt="" class="w-50p">
                            </div>
                        </div>
                    </div>

                    <div class="preview-post-wrap bg-white mt-5">
						<?php $excerpt = mb_strimwidth( $ad->description, 0, 100 ); ?>
                        <h2>Post preview</h2>
                        <div class="preview-post">
                            <div class="post-image">
                                <img src="<?= $images->image_1->url ?>" alt="">
                            </div>
                            <div class="post-content">
                                <div class="topper">
                                    <div class="category">
                                        Category
                                    </div>
                                    <div class="locale">
                                        Denmark
                                    </div>
                                </div>
                                <h3><span class="title"><?= $post->post_title ?></span></h3>
                                <p class="description"><?= substr( $excerpt, 0, strrpos( $excerpt, ' ' ) ); ?> [...]</p>
                                <span class="price"> <?= $ad->price ?> </span>
                                <img src="<?= $ad->partnersLogo ?>" alt="" class="partner-logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }