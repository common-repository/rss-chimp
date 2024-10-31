<?php

/**
 * Fired during plugin activation
 *
 * @link       https://kerosin.digital/
 * @since      1.0.0
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 * @author     kerosin.digital <hello@kerosin.digital>
 */
class Rss_Chimp_Activator {
    /**
     * Run on activation
     *
     * @since    1.0.0
     */
    public static function activate() {
        /**
         * Flush and rebuild rewrite rules upon activation
         *
         * @since    1.1.3
         */
        delete_option( 'rewrite_rules' );
    }

}
