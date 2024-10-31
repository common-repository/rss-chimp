<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kerosin.digital/
 * @since             1.0.0
 * @package           Rss_Chimp
 *
 * @wordpress-plugin
 * Plugin Name:       RSS feed with featured images | RSS Chimp
 * Plugin URI:        https://kerosin.digital/rss-chimp
 * Description:       RSS Chimp adds featured images to your RSS feed in the media:content tag for Mailchimp, Google News, Feedly, Flipboard and other services that use data from your feed for marketing automation and content marketing. This lightweight plugin offers various other settings for enhancing your RSS feed.
 * Version:           1.2.6
 * Author:            kerosindigital
 * Author URI:        https://kerosin.digital/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rss-chimp
 * Domain Path:       /languages
 *
 *
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RSS_CHIMP_VERSION', '1.2.6' );
if ( function_exists( 'rss_chimp_fs' ) ) {
    rss_chimp_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'rss_chimp_fs' ) ) {
        /**
         * Initialize Freemius
         * More info at https://github.com/Freemius/wordpress-sdk/
         */
        if ( !function_exists( 'rss_chimp_fs' ) ) {
            // Create a helper function for easy SDK access.
            function rss_chimp_fs() {
                global $rss_chimp_fs;
                if ( !isset( $rss_chimp_fs ) ) {
                    // Include Freemius SDK.
                    require_once dirname( __FILE__ ) . '/freemius/start.php';
                    $rss_chimp_fs = fs_dynamic_init( array(
                        'id'             => '6826',
                        'slug'           => 'rss-chimp',
                        'premium_slug'   => 'rss-chimp-pro',
                        'type'           => 'plugin',
                        'public_key'     => 'pk_694d4c9b717c889e8cf200cd5db86',
                        'is_premium'     => false,
                        'premium_suffix' => 'Pro',
                        'has_addons'     => false,
                        'has_paid_plans' => true,
                        'trial'          => array(
                            'days'               => 7,
                            'is_require_payment' => false,
                        ),
                        'navigation'     => 'tabs',
                        'menu'           => array(
                            'slug'       => 'rss-chimp',
                            'first-path' => 'admin.php?page=rss-chimp&tab=start',
                            'contact'    => false,
                            'support'    => false,
                        ),
                        'is_live'        => true,
                    ) );
                }
                return $rss_chimp_fs;
            }

            // Init Freemius.
            rss_chimp_fs();
            // Signal that SDK was initiated.
            do_action( 'rss_chimp_fs_loaded' );
        }
    }
    /**
     * Modify Freemius
     *
     * @since    1.1.2
     */
    function rss_chimp_custom_icon() {
        return dirname( __FILE__ ) . '/admin/assets/rss-chimp-icon.png';
    }

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-rss-chimp-activator.php
     */
    function activate_rss_chimp() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-rss-chimp-activator.php';
        Rss_Chimp_Activator::activate();
        add_option( 'rss_chimp_customfeed_name', 'rss-chimp' );
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-rss-chimp-deactivator.php
     */
    function deactivate_rss_chimp() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-rss-chimp-deactivator.php';
        Rss_Chimp_Deactivator::deactivate();
    }

    /**
     * The code that runs during plugin uninstall.
     */
    function uninstall_rss_chimp() {
        //General
        delete_option( 'rss_chimp_generatortag' );
        delete_option( 'rss_chimp_reset' );
        //Default feed
        delete_option( 'rss_chimp_defaultfeed_disable' );
        delete_option( 'rss_chimp_defaultfeed_imagesize' );
        delete_option( 'rss_chimp_defaultfeed_enclosure' );
        delete_option( 'rss_chimp_defaultfeed_content_before' );
        delete_option( 'rss_chimp_defaultfeed_content_after' );
        //Custom feed
        delete_option( 'rss_chimp_add_customfeed' );
        delete_option( 'rss_chimp_customfeed_name' );
        delete_option( 'rss_chimp_customfeed_imagesize' );
        delete_option( 'rss_chimp_customfeed_enclosure' );
        delete_option( 'rss_chimp_customfeed_lenght' );
        delete_option( 'rss_chimp_customfeed_content_before' );
        delete_option( 'rss_chimp_customfeed_content_after' );
        rss_chimp_fs()->add_action( 'after_uninstall', 'rss_chimp_fs_uninstall_cleanup' );
    }

    register_activation_hook( __FILE__, 'activate_rss_chimp' );
    register_deactivation_hook( __FILE__, 'deactivate_rss_chimp' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-rss-chimp.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_rss_chimp() {
        $plugin = new Rss_Chimp();
        $plugin->run();
    }

    run_rss_chimp();
}