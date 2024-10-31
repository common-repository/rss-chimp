<?php

echo '<ul class="kd-sidebar">';

if ( rss_chimp_fs()->is_free_plan() ) {
    echo '<li class="kd-sidebar-item" id="upgrade">';
    echo '<h2>' . __( 'Update to RSS Chimp Pro and unlock awesome features', 'rss-chimp' ) . '</h2>';
    echo '<ul>';
    echo '<li>' . __( 'Create an additional RSS feed for our site', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Select from all registered image sizes', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Add custom HTML before/after feed items', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Delay the publication of new posts in the feed', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Change the additional feeds permalink', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Define length of the posts in the custom feed', 'rss-chimp' ) . '</li>';
    echo '<li>' . __( 'Hide WordPress version from the feed', 'rss-chimp' ) . '</li>';
    echo '</ul>';
    echo '<div class="kd-btn"><a href="' . rss_chimp_fs()->get_upgrade_url() . '">' . __( 'Upgrade now', 'rss-chimp' ) . '</a></div>';
    echo '</li>';
}

echo '<li class="kd-sidebar-item" id="support">';
echo '<h2>' . __( 'Houston, we have a problem!', 'rss-chimp' ) . '</h2>';
echo '<p>' . sprintf( __( 'Have you checked out the <a target="_blank" href="%1$s">documentation</a>?', 'rss-chimp' ), 'https://kerosin.digital/support/docs/?utm_source=plugin&utm_medium=link&utm_campaign=rss.chimp&utm_term=wp-sidebar' ) . '</p>';
echo '<p>' . sprintf( __( 'If you still have troubles with RSS Chimp please use the <a target="_blank" href="%1$s">forum</a>.', 'rss-chimp' ), 'https://wordpress.org/support/plugin/rss-chimp/' ) . '</p>';
echo '</li>';

echo '<li class="kd-sidebar-item" id="support">';
echo '<h2>' . __( 'Do you like RSS Chimp?', 'rss-chimp' ) . ' <span class="rate"><i>★</i><i>★</i><i>★</i><i>★</i><i>★</i></span></h2>';
echo '<p>' . sprintf( __( 'Support RSS Chimp and give the plugin a <a target="_blank" href="%1$s">five-star rating in the WordPress.org repository</a>.', 'rss-chimp' ), 'https://wordpress.org/support/plugin/rss-chimp/reviews/#new-post' ) . '</p>';
echo '</li>';

echo '</ul>';

?>