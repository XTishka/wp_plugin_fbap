<?php

function fbap_tabs_menu($tab) { ?>
    <ul class="subsubsub">

        <li class="fbap-ads">
            <a href="?page=fbap&tab=ads" aria-current="page"
               class="<?php if ( $tab === 'ads' ): ?>current<?php endif; ?>">
				Affiliate ads <span class="count">(3)</span> |
            </a>
        </li>

        <li class="fbap-partners">
            <a href="?page=fbap&tab=partners" aria-current="page"
               class="<?php if ( $tab === 'partners' ): ?>current<?php endif; ?>">
                Affiliate partners <span class="count">(3)</span> |
            </a>
        </li>

        <li class="fbap-groups">
            <a href="?page=fbap&tab=groups" aria-current="page"
               class="<?php if ( $tab === 'groups' ): ?>current<?php endif; ?>">
                Affiliate groups <span class="count">(3)</span> |
            </a>
        </li>

        <li class="fbap-settings">
            <a href="?page=fbap&tab=settings" aria-current="page"
               class="<?php if ( $tab === 'settings' ): ?>current<?php endif; ?>">
                Settings
            </a>
        </li>

    </ul>
<?php }