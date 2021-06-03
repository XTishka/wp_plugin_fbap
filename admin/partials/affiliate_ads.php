<?php

use fbap\admin\includes\AffiliateAds;

function fbap_affiliate_ads() { ?>
	<?php
	$data = new AffiliateAds();
	$data->parse( 'https://www.luksushuse.dk/soeg/lolland-falster-moen/marielyst/481' );

	$default_tab = 'ads';
	$tab         = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;
	?>

    <div id="wpbody-content">
        <div class="wrap">
			<?= $data->getHeader( $tab ) ?>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">Filter pages list</h2>

            <ul class="subsubsub">

				<?php foreach ( $data->tabs as $index => $item ) : ?>
                    <li class="fbap-partners">
                        <a href="?page=fbap-affiliate-ads&tab=<?= $index ?>" aria-current="page"
                           class="<?php if ( $tab === $index ): ?>current<?php endif; ?>">
							<?= $item ?>
							<?php if ( $index != 'settings' ) : ?>
                                <span class="count">(3)</span>
							<?php endif; ?>
                        </a>
						<?php if ( array_key_last( $data->tabs ) != $index )
							echo " | " ?>
                    </li>
				<?php endforeach; ?>

            </ul>

			<?php $data->getContent($tab); ?>
        </div>
    </div>

	<?php
}