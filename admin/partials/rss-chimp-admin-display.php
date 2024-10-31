<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://kerosin.digital/
 * @since      1.0.0
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/admin/partials
 */

?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="kd-wrap">
        <?php
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=rss-chimp&tab=start" class="nav-tab"><?php esc_html_e('Start', 'rss-chimp'); ?></a>
            <a href="?page=rss-chimp&tab=general" class="nav-tab"><?php esc_html_e('General', 'rss-chimp'); ?></a>
            <a href="?page=rss-chimp&tab=feeds" class="nav-tab"><?php esc_html_e('Feeds', 'rss-chimp'); ?></a>
        </h2>
        <div class="kd-content">
            <form action="options.php" method="post">
                <?php
                settings_errors();
                wp_nonce_field('rss_chimp_nonce_action', 'rss_chimp_nonce_field');

                if ($active_tab == 'start') {
                    ?>
                    <div id="plugin-information-title" class="with-banner" style="background-image:url(<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'assets/rss-chimp-banner.jpg'); ?>)">
                        <div class="vignette"></div>
                        <h2><?php esc_html_e('RSS Chimp — Featured images in RSS feed'); ?></h2>
                    </div>
                    <h2><?php esc_html_e('How to use RSS Chimp'); ?></h2>
                    <p><?php esc_html_e('Thank you for installing RSS Chimp. The plugin automatically adds featured images to your RSS feed after activating the plugin when a new blog post is finished.', 'rss-chimp'); ?></p>
                    <p><?php
                        printf(
                            esc_html__('If you have troubles with the plugin please check out the %1$s and have a look at the %2$s.', 'rss-chimp'),
                            '<a href="https://kerosin.digital/docs/rss-chimp/getting-started-guide/?utm_source=plugin&utm_medium=link&utm_campaign=rss.chimp&utm_term=wp-tab-start" target="_blank">' . esc_html__('"Getting Started Guide"', 'rss-chimp') . '</a>',
                            '<a href="https://kerosin.digital/support/docs/?utm_source=plugin&utm_medium=link&utm_campaign=rss.chimp&utm_term=wp-tab-start" target="_blank">' . esc_html__('documentation', 'rss-chimp') . '</a>'
                        );
                        ?></p>
                    <h2><?php esc_html_e('Do you like RSS Chimp?'); ?></h2>
                    <p><?php
                        printf(
                            esc_html__('If you like RSS Chimp, please take a minute to rate it on %1$s.', 'rss-chimp'),
                            '<a href="https://wordpress.org/support/plugin/rss-chimp/reviews/#new-post" target="_blank" class="kd-fivestar">★★★★★</a>'
                        );
                        ?></p>
                    <p><?php
                        printf(
                            esc_html__('You can support the development of the free version of RSS Chimp and make a contribution on %1$s.', 'rss-chimp'),
                            '<a target="_blank" href="https://www.buymeacoffee.com/kerosindigital">' . esc_html__('Buy Me a Coffee', 'rss-chimp') . '</a>'
                        );
                        ?></p>
                    <div class="kd-btn">
                        <a href="https://www.buymeacoffee.com/kerosindigital" target="_blank">
                            <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'assets/bmc-full-logo.svg'); ?>" width="150px" height="auto">
                        </a>
                    </div>
                    <?php
                } elseif ($active_tab == 'general') {
                    ?>
                    <div class="kd-panel">
                        <?php
                        settings_fields($this->plugin_name . '_tab_general');
                        do_settings_sections($this->plugin_name . '_channel_settings');

                        if (rss_chimp_fs()->is__premium_only() && rss_chimp_fs()->is_plan('pro', true)) {
                            do_settings_sections($this->plugin_name . '_feed_delay_settings');
                        }

                        do_settings_sections($this->plugin_name . '_thumbnail_settings');
                        do_settings_sections($this->plugin_name . '_other_settings');
                        submit_button();
                        ?>
                    </div>
                    <?php
                } elseif ($active_tab == 'feeds') {
                    ?>
                    <div class="kd-tabs-navigation">
                        <a class="tablinks active" onclick="kdTabs(event, 'tab1')"><?php esc_html_e('Default feed', 'rss-chimp'); ?></a>
                        <?php if (rss_chimp_fs()->is__premium_only() && rss_chimp_fs()->is_plan('pro', true)) { ?>
                            <a class="tablinks" onclick="kdTabs(event, 'tab2')"><?php esc_html_e('Custom feed', 'rss-chimp'); ?></a>
                        <?php } ?>
                    </div>
                    <div class="kd-panel">
                        <?php
                        settings_fields($this->plugin_name . '_tab_feeds');

                        ?>
                        <div id="tab1" class="tabcontent first">
                            <?php
                            do_settings_sections($this->plugin_name . '_defaultfeed_settings');

                            $validator = 'https://validator.w3.org/feed/check.cgi?url=' . get_bloginfo_rss('rss2_url');
                            ?>
                            <p><?php
                                printf(
                                    esc_html__('Validate your feed with the W3C Feed Validation Service: %1$s', 'rss-chimp'),
                                    '<a href="' . esc_url($validator) . '" target="_blank">' . esc_html__('Validate default feed', 'rss-chimp') . '</a>'
                                );
                                ?></p>
                        </div>
                        <?php if (rss_chimp_fs()->is__premium_only() && rss_chimp_fs()->is_plan('pro', true)) { ?>
                            <div id="tab2" class="tabcontent">
                                <?php
                                do_settings_sections($this->plugin_name . '_customfeed_settings');

                                if (get_option('rss_chimp_add_customfeed') == '1') {
                                    $custom = 'https://validator.w3.org/feed/check.cgi?url=' . esc_url(get_site_url() . '/' . get_option('rss_chimp_customfeed_name'));
                                    ?>
                                    <p><?php
                                        printf(
                                            esc_html__('Validate your feed with the W3C Feed Validation Service: %1$s', 'rss-chimp'),
                                            '<a href="' . esc_url($custom) . '" target="_blank">' . esc_html__('Validate custom feed', 'rss-chimp') . '</a>'
                                        );
                                        ?></p>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <?php submit_button(); ?>
                    </div>
                    <?php
                }
                ?>
            </form>
        </div>
        <ul class="kd-sidebar">
            <?php if (rss_chimp_fs()->is_free_plan()) { ?>
                <li class="kd-sidebar-item" id="upgrade">
                    <h2><?php esc_html_e('Update to RSS Chimp Pro and unlock awesome features', 'rss-chimp'); ?></h2>
                    <ul>
                        <li><?php esc_html_e('Create an additional RSS feed for our site', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Select from all registered image sizes', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Add custom HTML before/after feed items', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Delay the publication of new posts in the feed', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Change the additional feeds permalink', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Define length of the posts in the custom feed', 'rss-chimp'); ?></li>
                        <li><?php esc_html_e('Hide WordPress version from the feed', 'rss-chimp'); ?></li>
                    </ul>
                    <div class="kd-btn">
                        <a href="<?php echo esc_url(rss_chimp_fs()->get_upgrade_url()); ?>">
                            <?php esc_html_e('Upgrade now', 'rss-chimp'); ?>
                        </a>
                    </div>
                </li>
            <?php } ?>
            <li class="kd-sidebar-item" id="support">
                <h2><?php esc_html_e('Houston, we have a problem!', 'rss-chimp'); ?></h2>
                <p><?php
                    printf(
                        esc_html__('Have you checked out the %1$s?', 'rss-chimp'),
                        '<a target="_blank" href="https://kerosin.digital/support/docs/?utm_source=plugin&utm_medium=link&utm_campaign=rss.chimp&utm_term=wp-sidebar">' . esc_html__('documentation', 'rss-chimp') . '</a>'
                    );
                    ?></p>
                <p><?php
                    printf(
                        esc_html__('If you still have troubles with RSS Chimp please use the %1$s.', 'rss-chimp'),
                        '<a target="_blank" href="https://wordpress.org/support/plugin/rss-chimp/">' . esc_html__('forum', 'rss-chimp') . '</a>'
                    );
                    ?></p>
            </li>
        </ul>
    </div>
</div>
