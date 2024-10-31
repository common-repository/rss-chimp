<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://kerosin.digital/
 * @since      1.0.0
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 * @author     kerosin.digital <hello@kerosin.digital>
 */
class Rss_Chimp_Deactivator {

	/**
	 * Run on deactivation
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		/**
		 * Delete settings on deactivation
		 *
		 * @since    1.1.0
		 */
		if( get_option('rss_chimp_reset') == '1' ) {
			// Channel settings
			delete_option( 'rss_chimp_channel_choose_image' );
			delete_option( 'rss_chimp_channel_custom_image' );
			delete_option( 'rss_chimp_channel_copyright' );
			delete_option( 'rss_chimp_channel_editor' );
			delete_option( 'rss_chimp_channel_webmaster' );
			// Feed delay
		    delete_option( 'rss_chimp_feed_delay_status' );
		    delete_option( 'rss_chimp_feed_delay_value' );
			// Thumbnails
			delete_option( 'rss_chimp_thumbnail_small' );
			delete_option( 'rss_chimp_thumbnail_medium' );
			// Other
			delete_option( 'rss_chimp_disable_commentsfeed' );
			delete_option( 'rss_chimp_generatortag' );
			delete_option( 'rss_chimp_reset' );		    
		    // Default feed
		    delete_option( 'rss_chimp_defaultfeed_disable' );
		    delete_option( 'rss_chimp_defaultfeed_imagesize' );
			delete_option( 'rss_chimp_defaultfeed_enclosure' );
			delete_option( 'rss_chimp_defaultfeed_image_title' );
			delete_option( 'rss_chimp_defaultfeed_image_description' );
			delete_option( 'rss_chimp_defaultfeed_content_before' );
			delete_option( 'rss_chimp_defaultfeed_content_after' );
			delete_option( 'rss_chimp_defaultfeed_link_parameter' );
		    // Custom feed
		    delete_option( 'rss_chimp_add_customfeed' );
		    delete_option( 'rss_chimp_customfeed_name' );
		    delete_option( 'rss_chimp_customfeed_imagesize' );
			delete_option( 'rss_chimp_customfeed_enclosure' );
		    delete_option( 'rss_chimp_customfeed_image_title' );
		    delete_option( 'rss_chimp_customfeed_image_description' );
		    delete_option( 'rss_chimp_customfeed_lenght' );
		    delete_option( 'rss_chimp_customfeed_content_before' );
		    delete_option( 'rss_chimp_customfeed_content_after' );
		    delete_option( 'rss_chimp_customfeed_link_parameter' );
		}

	}

}