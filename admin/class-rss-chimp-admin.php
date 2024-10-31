<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://kerosin.digital/
 * @since      1.0.0
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/admin
 * @author     kerosin.digital <hello@kerosin.digital>
 */
class Rss_Chimp_Admin {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The options name to be used in this plugin
     *
     * @since  	1.0.0
     * @access 	private
     * @var  	string 		$option_name 	Option name of this plugin
     */
    private $option_name = 'rss_chimp';

    /**
     * Initialize the class and set its properties.
     *
     * @since	   1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/rss-chimp-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/rss-chimp-admin.js',
            array('jquery'),
            $this->version,
            false
        );
    }

    /**
     * Create plugin pages.
     *
     * @since    1.0.0
     */
    public function rss_chimp_menu_pages() {
        if ( is_plugin_active( 'adminion/adminion.php' ) ) {
            $this->plugin_screen_hook_suffix = add_submenu_page(
                'adminion',
                __( 'RSS Chimp', 'rss-chimp' ),
                __( 'RSS Chimp', 'rss-chimp' ),
                'manage_options',
                $this->plugin_name,
                array($this, 'rss_chimp_admin_display')
            );
        } else {
            $this->plugin_screen_hook_suffix = add_menu_page(
                __( 'RSS Chimp', 'rss-chimp' ),
                __( 'RSS Chimp', 'rss-chimp' ),
                'manage_options',
                'rss-chimp',
                array($this, 'rss_chimp_admin_display'),
                'dashicons-rss'
            );
        }
    }

    /**
     * Render plugin pages.
     *
     * @since  1.0.0
     */
    public function rss_chimp_admin_display() {
        include_once 'partials/rss-chimp-admin-display.php';
    }

    /**
     * Register all related settings of this plugin
     *
     * @since  1.0.0
     */
    public function rss_chimp_settings_init() {
        // Channel settings
        add_settings_section(
            $this->option_name . '_channel_settings',
            __( 'Feed channel options', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_settings_cb'),
            $this->plugin_name . '_channel_settings'
        );
        add_settings_field(
            $this->option_name . '_channel_choose_image',
            __( 'Preferred logo', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_choose_image_cb'),
            $this->plugin_name . '_channel_settings',
            $this->option_name . '_channel_settings',
            array(
                'label_for' => $this->option_name . '_channel_choose_image',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_channel_choose_image' );
        add_settings_field(
            $this->option_name . '_channel_custom_image',
            __( 'Custom logo', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_custom_image_cb'),
            $this->plugin_name . '_channel_settings',
            $this->option_name . '_channel_settings',
            array(
                'label_for' => $this->option_name . '_channel_custom_image',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_channel_custom_image' );
        add_settings_field(
            $this->option_name . '_channel_copyright',
            __( 'Copyright', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_copyright_cb'),
            $this->plugin_name . '_channel_settings',
            $this->option_name . '_channel_settings',
            array(
                'label_for' => $this->option_name . '_channel_copyright',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_channel_copyright' );
        add_settings_field(
            $this->option_name . '_channel_editor',
            __( 'Editor', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_editor_cb'),
            $this->plugin_name . '_channel_settings',
            $this->option_name . '_channel_settings',
            array(
                'label_for' => $this->option_name . '_channel_editor',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_channel_editor' );
        add_settings_field(
            $this->option_name . '_channel_webmaster',
            __( 'Webmaster', 'rss-chimp' ),
            array($this, $this->option_name . '_channel_webmaster_cb'),
            $this->plugin_name . '_channel_settings',
            $this->option_name . '_channel_settings',
            array(
                'label_for' => $this->option_name . '_channel_webmaster',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_channel_webmaster' );
        //Thumbnail settings
        add_settings_section(
            $this->option_name . '_thumbnail_settings',
            __( 'Thumbnail options', 'rss-chimp' ),
            array($this, $this->option_name . '_thumbnail_settings_cb'),
            $this->plugin_name . '_thumbnail_settings'
        );
        add_settings_field(
            $this->option_name . '_thumbnail_small',
            __( 'RSS Chimp Small', 'rss-chimp' ),
            array($this, $this->option_name . '_thumbnail_small_cb'),
            $this->plugin_name . '_thumbnail_settings',
            $this->option_name . '_thumbnail_settings',
            array(
                'label_for' => $this->option_name . '_thumbnail_small',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_thumbnail_small' );
        //Other settings
        add_settings_section(
            $this->option_name . '_other_settings',
            __( 'Other options', 'rss-chimp' ),
            array($this, $this->option_name . '_other_settings_cb'),
            $this->plugin_name . '_other_settings'
        );
        add_settings_field(
            $this->option_name . '_disable_commentsfeed',
            __( 'Deactivate comments feed', 'rss-chimp' ),
            array($this, $this->option_name . '_disable_commentsfeed_cb'),
            $this->plugin_name . '_other_settings',
            $this->option_name . '_other_settings',
            array(
                'label_for' => $this->option_name . '_disable_commentsfeed',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_disable_commentsfeed' );
        add_settings_field(
            $this->option_name . '_reset',
            __( 'Reset all options on deactivation', 'rss-chimp' ),
            array($this, $this->option_name . '_reset_cb'),
            $this->plugin_name . '_other_settings',
            $this->option_name . '_other_settings',
            array(
                'label_for' => $this->option_name . '_reset',
            )
        );
        register_setting( $this->plugin_name . '_tab_general', $this->option_name . '_reset' );
        // Default feed
        add_settings_section(
            $this->option_name . '_defaultfeed_settings',
            __( 'Default feed', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_settings_cb'),
            $this->plugin_name . '_defaultfeed_settings'
        );
        add_settings_field(
            $this->option_name . '_defaultfeed_disable',
            __( 'Disable default feeds', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_disable_cb'),
            $this->plugin_name . '_defaultfeed_settings',
            $this->option_name . '_defaultfeed_settings',
            array(
                'label_for' => $this->option_name . '_defaultfeed_disable',
            )
        );
        register_setting( $this->plugin_name . '_tab_feeds', $this->option_name . '_defaultfeed_disable' );
        add_settings_field(
            $this->option_name . '_defaultfeed_imagesize',
            __( 'Image size for the default WordPress feed', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_imagesize_cb'),
            $this->plugin_name . '_defaultfeed_settings',
            $this->option_name . '_defaultfeed_settings',
            array(
                'label_for' => $this->option_name . '_defaultfeed_imagesize',
            )
        );
        register_setting( $this->plugin_name . '_tab_feeds', $this->option_name . '_defaultfeed_imagesize' );
        add_settings_field(
            $this->option_name . '_defaultfeed_enclosure',
            __( 'Also add image with enclosure tag to the feed', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_enclosure_cb'),
            $this->plugin_name . '_defaultfeed_settings',
            $this->option_name . '_defaultfeed_settings',
            array(
                'label_for' => $this->option_name . '_defaultfeed_enclosure',
            )
        );
        register_setting( $this->plugin_name . '_tab_feeds', $this->option_name . '_defaultfeed_enclosure' );
        add_settings_field(
            $this->option_name . '_defaultfeed_image_title',
            __( 'Include the title of the featured image', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_image_title_cb'),
            $this->plugin_name . '_defaultfeed_settings',
            $this->option_name . '_defaultfeed_settings',
            array(
                'label_for' => $this->option_name . '_defaultfeed_image_title',
            )
        );
        register_setting( $this->plugin_name . '_tab_feeds', $this->option_name . '_defaultfeed_image_title' );
        add_settings_field(
            $this->option_name . '_defaultfeed_image_description',
            __( 'Include the description of the featured image', 'rss-chimp' ),
            array($this, $this->option_name . '_defaultfeed_image_description_cb'),
            $this->plugin_name . '_defaultfeed_settings',
            $this->option_name . '_defaultfeed_settings',
            array(
                'label_for' => $this->option_name . '_defaultfeed_image_description',
            )
        );
        register_setting( $this->plugin_name . '_tab_feeds', $this->option_name . '_defaultfeed_image_description' );
    }

    /**
     * Render the text for the channel settings
     *
     * @since  1.2.0
     */
    public function rss_chimp_channel_settings_cb() {
        //echo '<p>';
        //echo  __( 'Adapt the feeds created by WordPress to your needs.' );
        //echo '</p>';
    }

    /**
     * Render the text for the feed delay settings
     *
     * @since  1.2.0
     */
    public function rss_chimp_feed_delay_settings_cb() {
        //echo '<p>';
        //echo  __( 'Adapt the feeds created by WordPress to your needs.' );
        //echo '</p>';
    }

    /**
     * Render the text for the other settings
     *
     * @since  1.2.3
     */
    public function rss_chimp_thumbnail_settings_cb() {
        //echo '<p>';
        //echo  __( 'Adapt the feeds created by WordPress to your needs.' );
        //echo '</p>';
    }

    /**
     * Render the text for the other settings
     *
     * @since  1.0.0
     */
    public function rss_chimp_other_settings_cb() {
        //echo '<p>';
        //echo  __( 'Adapt the feeds created by WordPress to your needs.' );
        //echo '</p>';
    }

    /**
     * Render the text for the default feed settings
     *
     * @since  1.0.0
     */
    public function rss_chimp_defaultfeed_settings_cb() {
        $optinlink = admin_url( 'plugins.php' );
        $upgradelink = rss_chimp_fs()->get_upgrade_url();
        echo '<p>';
        echo __( 'Here you can customize the default WordPress feed and set the size of the attached image.', 'rss-chimp' );
        if ( rss_chimp_fs()->is_plan( 'pro', true ) ) {
        } else {
            echo '<br>';
            echo sprintf( __( '<a href="%1$s">Upgrade to pro</a> for all image sizes and many more features.', 'rss-chimp' ), $upgradelink );
        }
        echo '</p>';
    }

    /**
     * Render the select for chosing the channel image
     *
     * @since    1.2.0
     */
    public function rss_chimp_channel_choose_image_cb() {
        echo '<select name="' . $this->option_name . '_channel_choose_image' . '">';
        echo '<option value="off" ' . selected( 'off', get_option( 'rss_chimp_channel_choose_image' ), false ) . '>' . __( 'Disabled', 'rss-chimp' ) . '</option>';
        echo '<option value="favicon" ' . selected( 'favicon', get_option( 'rss_chimp_channel_choose_image' ), false ) . '>' . __( 'Favicon', 'rss-chimp' ) . '</option>';
        echo '<option value="sitelogo" ' . selected( 'sitelogo', get_option( 'rss_chimp_channel_choose_image' ), false ) . '>' . __( 'Site logo', 'rss-chimp' ) . '</option>';
        echo '<option value="customimage" ' . selected( 'customimage', get_option( 'rss_chimp_channel_choose_image' ), false ) . '>' . __( 'Custom image', 'rss-chimp' ) . '</option>';
        echo '</select>';
    }

    /**
     * Render the media select for the channel image
     *
     * @since  1.2.0
     */
    public function rss_chimp_channel_custom_image_cb() {
        echo '<input id="background_image" type="hidden" name="' . $this->option_name . '_channel_custom_image' . '" value="' . get_option( 'rss_chimp_channel_custom_image' ) . '" />';
        echo '<input id="upload_image_button" type="button" class="button button-primary kd-media-select-button" value="' . __( 'Select logo', 'rss-chimp' ) . '" />';
        echo '<input id="reset_image_button" type="button" onclick="ClearFields();" class="button remove-button kd-media-reset-button" value="' . __( 'Remove logo', 'rss-chimp' ) . '" />';
        echo '<img id="background_image_thumb" class="kd-media-select-img" src="' . get_option( 'rss_chimp_channel_custom_image' ) . '" />';
    }

    /**
     * Render the textfield for the channel copyright
     *
     * @since  1.2.0
     */
    public function rss_chimp_channel_copyright_cb() {
        echo '<input type="text" name="' . $this->option_name . '_channel_copyright' . '" value="' . get_option( 'rss_chimp_channel_copyright' ) . '" placeholder="' . __( '&copy 2022, Company name', 'rss-chimp' ) . '" />';
    }

    /**
     * Render the textfield for the channel editor
     *
     * @since  1.2.0
     */
    public function rss_chimp_channel_editor_cb() {
        echo '<input type="text" name="' . $this->option_name . '_channel_editor' . '" value="' . get_option( 'rss_chimp_channel_editor' ) . '" placeholder="' . __( 'johnny@example.com (Johnny Controletti)', 'rss-chimp' ) . '" />';
    }

    /**
     * Render the textfield for the channel webmaster
     *
     * @since  1.2.0
     */
    public function rss_chimp_channel_webmaster_cb() {
        echo '<input type="text" name="' . $this->option_name . '_channel_webmaster' . '" value="' . get_option( 'rss_chimp_channel_webmaster' ) . '" placeholder="' . __( 'jane@example.com (Jane Controletti)', 'rss-chimp' ) . '" />';
    }

    /**
     * Render the select for enabling/disabling the feed delay
     *
     * @since    1.2.0
     */
    public function rss_chimp_feed_delay_status_cb() {
        echo '<select name="' . $this->option_name . '_feed_delay_status' . '">';
        echo '<option value="off" ' . selected( 'disabled', get_option( 'rss_chimp_feed_delay_status' ), false ) . '>' . __( 'Disabled', 'rss-chimp' ) . '</option>';
        echo '<option value="on" ' . selected( 'enabled', get_option( 'rss_chimp_feed_delay_status' ), false ) . '>' . __( 'Enabled', 'rss-chimp' ) . '</option>';
        echo '</select>';
    }

    /**
     * Render the fields for the feed delay
     *
     * @since  1.2.0
     */
    public function rss_chimp_feed_delay_value_cb() {
        $options = get_option( 'rss_chimp_feed_delay_value', [] );
        $args = ( isset( $options ) ? (array) $options : [] );
        ?>
		<input type="number" name="rss_chimp_feed_delay_value[VALUE]" value="<?php 
        echo ( isset( $options['VALUE'] ) ? $options['VALUE'] : '' );
        ?>" />
		<select id="rss_chimp_admin_widget" name="rss_chimp_feed_delay_value[UNIT]">
			<option <?php 
        selected( in_array( 'SECOND', $args ), 1 );
        ?> value="SECOND"><?php 
        _e( 'Seconds', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'MINUTE', $args ), 1 );
        ?> value="MINUTE"><?php 
        _e( 'Minutes', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'HOUR', $args ), 1 );
        ?> value="HOUR"><?php 
        _e( 'Hours', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'DAY', $args ), 1 );
        ?> value="DAY"><?php 
        _e( 'Days', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'WEEK', $args ), 1 );
        ?> value="WEEK"><?php 
        _e( 'Weeks', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'MONTH', $args ), 1 );
        ?> value="MONTH"><?php 
        _e( 'Months', 'rss-chimp' );
        ?></option>
			<option <?php 
        selected( in_array( 'YEAR', $args ), 1 );
        ?> value="YEAR"><?php 
        _e( 'Years', 'rss-chimp' );
        ?></option>
		</select>
		<?php 
    }

    /**
     * Render the checkbox for removing version number from feeds
     *
     * @since  1.2.6
     */
    public function rss_chimp_disable_commentsfeed_cb() {
        echo '<input type="checkbox" name="' . $this->option_name . '_disable_commentsfeed' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_disable_commentsfeed' ), false ) . '" />';
    }

    /**
     * Render the options for thumbnails
     *
     * @since  1.2.3
     */
    public function rss_chimp_thumbnail_small_cb() {
        echo '<label for="rss_chimp_thumbnail_small">';
        echo '<input type="checkbox" name="' . $this->option_name . '_thumbnail_small' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_thumbnail_small' ), false ) . '" />';
        echo '(150x84 Pixel, cropped)';
        echo '</label">';
    }

    public function rss_chimp_thumbnail_medium_cb() {
        echo '<label for="rss_chimp_thumbnail_medium">';
        echo '<input type="checkbox" name="' . $this->option_name . '_thumbnail_medium' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_thumbnail_medium' ), false ) . '" />';
        echo '(640x360 Pixel, cropped)';
        echo '</label">';
    }

    /**
     * Render the checkbox for reseting the plugin upon activation
     *
     * @since  1.1.0
     */
    public function rss_chimp_reset_cb() {
        echo '<input type="checkbox" name="' . $this->option_name . '_reset' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_reset' ), false ) . '" />';
    }

    /**
     * Render the checkbox for disabeling the default feeds
     *
     * @since  1.0.0
     */
    public function rss_chimp_defaultfeed_disable_cb() {
        echo '<label for="rss_chimp_defaultfeed_disable">';
        echo '<input type="checkbox" name="' . $this->option_name . '_defaultfeed_disable' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_defaultfeed_disable' ), false ) . '" />';
        echo '<strong>Attention:</strong> When activated, the comment feed is also removed.';
        echo '</label>';
    }

    /**
     * Render the select for choosing the default feed image size
     *
     * @since  1.0.0
     */
    public function rss_chimp_defaultfeed_imagesize_cb() {
        if ( rss_chimp_fs()->is_plan( 'pro', true ) ) {
            $position = get_option( $this->option_name . '_defaultfeed_imagesize' );
            $image_sizes = get_intermediate_image_sizes();
            echo '<select name="' . $this->option_name . '_defaultfeed_imagesize' . '" class="input">';
            foreach ( $image_sizes as $size ) {
                echo '<option value="' . $size . '"' . selected( get_option( 'rss_chimp_defaultfeed_imagesize' ), $size ) . '>' . $size . '</option>';
            }
            echo '</select>';
        } else {
            $position = get_option( $this->option_name . '_defaultfeed_imagesize' );
            if ( get_option( 'rss_chimp_thumbnail_small' ) == '1' ) {
                $image_sizes = array(
                    "thumbnail"       => "thumbnail",
                    "medium"          => "medium",
                    "rss-chimp-small" => "rss-chimp-small",
                );
            } else {
                $image_sizes = array(
                    "thumbnail" => "thumbnail",
                    "medium"    => "medium",
                );
            }
            echo '<select name="' . $this->option_name . '_defaultfeed_imagesize' . '" class="input">';
            foreach ( $image_sizes as $size ) {
                echo '<option value="' . $size . '"' . selected( get_option( 'rss_chimp_defaultfeed_imagesize' ), $size ) . '>' . $size . '</option>';
            }
            echo '</select>';
        }
    }

    /**
     * Render the checkbox for the image enclosure tag
     *
     * @since  1.2.1
     */
    public function rss_chimp_defaultfeed_enclosure_cb() {
        echo '<input type="checkbox" name="' . $this->option_name . '_defaultfeed_enclosure' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_defaultfeed_enclosure' ), false ) . '" />';
    }

    /**
     * Render the checkbox for the image title in the default feed
     *
     * @since  1.2.1
     */
    public function rss_chimp_defaultfeed_image_title_cb() {
        echo '<input type="checkbox" name="' . $this->option_name . '_defaultfeed_image_title' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_defaultfeed_image_title' ), false ) . '" />';
    }

    /**
     * Render the checkbox for the image description in the default feed
     *
     * @since  1.2.1
     */
    public function rss_chimp_defaultfeed_image_description_cb() {
        echo '<input type="checkbox" name="' . $this->option_name . '_defaultfeed_image_description' . '" value="1" "' . checked( 1, get_option( 'rss_chimp_defaultfeed_image_description' ), false ) . '" />';
    }

    /**
     * Render the input for the default feed URL parameter
     *
     * @since  1.2.2
     */
    public function rss_chimp_defaultfeed_link_parameter_cb() {
        echo '<input type="text" name="' . $this->option_name . '_defaultfeed_link_parameter' . '" value="' . get_option( 'rss_chimp_defaultfeed_link_parameter' ) . '" />';
    }

    /**
     * Add additional image sizes
     *
     * @since    1.0.0
     */
    function rss_chimp_imagesizes() {
        if ( get_option( 'rss_chimp_thumbnail_small' ) == '1' ) {
            add_image_size(
                'rss-chimp-small',
                150,
                84,
                TRUE
            );
        }
    }

    /**
     * Extend the RSS namespace with the media specification
     *
     * @since    1.0.0
     */
    function rss_chimp_add_namespace() {
        echo 'xmlns:media="http://search.yahoo.com/mrss/"' . "\n";
    }

    /**
     * Add the featured image
     *
     * @since    1.0.0
     */
    function rss_chimp_add_featuredimage() {
        global $post;
        $output = '';
        if ( get_post_type() !== 'post' ) {
            return;
        }
        if ( has_post_thumbnail( $post->ID ) ) {
            // Get image size
            $imagesize = get_option( $this->option_name . '_defaultfeed_imagesize' );
            // Get thumbnail url of featured image
            $thumbnail_url = get_the_post_thumbnail_url( $post->ID, $imagesize );
            // Get the file size of the featured image
            if ( $thumbnail_url ) {
                $image_path = parse_url( $thumbnail_url, PHP_URL_PATH );
                $thumbnail_path = $_SERVER['DOCUMENT_ROOT'] . $image_path;
                $thumbnail_size = filesize( $thumbnail_path );
            }
            // Get mime type of image
            $mime_type = explode( '/', get_post_mime_type( get_post_thumbnail_id( $post->ID ) ) );
            $mime = $mime_type['1'];
            // Add image with <enclosure>
            if ( get_option( 'rss_chimp_defaultfeed_enclosure' ) == '1' ) {
                $output .= '<enclosure url="' . esc_url( $thumbnail_url ) . '" length="' . $thumbnail_size . '" type="image/' . $mime . '"/>';
            }
            // Add image with <media:content>
            $output .= '<media:content url="' . esc_url( $thumbnail_url ) . '" medium="image" type="image/' . $mime . '" />';
            // Get title and description of the featured image
            $post_thumbnail = get_posts( array(
                'p'         => get_post_thumbnail_id( $post->ID ),
                'post_type' => 'attachment',
            ) );
            $image_title = $post_thumbnail[0]->post_title;
            $image_description = $post_thumbnail[0]->post_content;
            // Add image title
            if ( get_option( 'rss_chimp_defaultfeed_image_title' ) == '1' ) {
                if ( !empty( $image_title ) ) {
                    $output .= '<media:title><![CDATA[' . $image_title . ']]></media:title>';
                }
            }
            // Add image description
            if ( get_option( 'rss_chimp_defaultfeed_image_description' ) == '1' ) {
                if ( !empty( $image_description ) ) {
                    $output .= '<media:description><![CDATA[' . $image_description . ']]></media:description>';
                }
            }
        }
        echo $output;
    }

    /**
     * Add URL parameter to  default feed links
     *
     * @since    1.2.2
     */
    function rss_chimp_defaultfeed_add_link_parameter( $post_permalink ) {
        return $post_permalink . get_option( 'rss_chimp_defaultfeed_link_parameter' );
    }

    /**
     * Add channel meta to the RSS feed
     *
     * @since    1.2.0
     */
    function rss_chimp_channel_add_image() {
        // Channel logo
        if ( get_option( 'rss_chimp_channel_choose_image' ) == 'favicon' ) {
            // Favicon
            if ( has_site_icon() ) {
                echo '<image>' . "\n";
                $themefavicon = get_option( 'site_icon' );
                $image = wp_get_attachment_image_url( $themefavicon, 'full' );
                echo '<url>' . $image . '</url>' . "\n";
                echo '<title>' . get_bloginfo( 'name' ) . '</title>' . "\n";
                echo '<link>' . get_bloginfo( 'siteurl' ) . '</link>' . "\n";
                echo '</image>' . "\n";
            }
        } else {
            if ( get_option( 'rss_chimp_channel_choose_image' ) == 'sitelogo' ) {
                // Site logo
                if ( has_custom_logo() ) {
                    echo '<image>' . "\n";
                    $themelogo = get_theme_mod( 'custom_logo' );
                    $image = wp_get_attachment_image_src( $themelogo, 'full' );
                    $image_url = $image[0];
                    echo '<url>' . $image_url . '</url>' . "\n";
                    echo '<title>' . get_bloginfo( 'name' ) . '</title>' . "\n";
                    echo '<link>' . get_bloginfo( 'siteurl' ) . '</link>' . "\n";
                    echo '</image>' . "\n";
                }
            } else {
                if ( get_option( 'rss_chimp_channel_choose_image' ) == 'customimage' ) {
                    // Custm image
                    if ( !empty( get_option( 'rss_chimp_channel_custom_image' ) ) ) {
                        echo '<image>' . "\n";
                        echo '<url>' . get_option( 'rss_chimp_channel_custom_image' ) . '</url>' . "\n";
                        echo '<title>' . get_bloginfo( 'name' ) . '</title>' . "\n";
                        echo '<link>' . get_bloginfo( 'siteurl' ) . '</link>' . "\n";
                        echo '</image>' . "\n";
                    }
                }
            }
        }
        // Copyright
        if ( !empty( get_option( 'rss_chimp_channel_copyright' ) ) ) {
            echo '<copyright>' . get_option( 'rss_chimp_channel_copyright' ) . '</copyright>';
        }
        // Editor
        if ( !empty( get_option( 'rss_chimp_channel_editor' ) ) ) {
            echo '<managingEditor>' . get_option( 'rss_chimp_channel_editor' ) . '</managingEditor>';
        }
        // Webmaster
        if ( !empty( get_option( 'rss_chimp_channel_webmaster' ) ) ) {
            echo '<webMaster>' . get_option( 'rss_chimp_channel_webmaster' ) . '</webMaster>';
        }
    }

    /**
     * Removes default WordPress functionality to add favicon as RSS logo
     *
     * @since  1.2.0
     */
    function rss_chimp_channel_remove_favicon() {
        remove_action( 'rss2_head', 'rss2_site_icon' );
    }

    /**
     * Handles the feed delay
     *
     * @since  1.2.0
     */
    function rss_chimp_feed_delay( $where ) {
        global $wpdb;
        $values = get_option( 'rss_chimp_feed_delay_value' );
        if ( is_feed() ) {
            // timestamp in WP-format
            $now = gmdate( 'Y-m-d H:i:s' );
            // value for wait; + device
            $wait = $values['VALUE'];
            // integer
            // http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
            $device = $values['UNIT'];
            //MINUTE, HOUR, DAY, WEEK, MONTH, YEAR
            // add SQL-sytax to default $where
            $where .= " AND TIMESTAMPDIFF({$device}, {$wpdb->posts}.post_date_gmt, '{$now}') > {$wait} ";
        }
        return $where;
    }

    /**
     * Add generator tag for RSS Chimp
     *
     * @since  1.0.0
     */
    function rss_chimp_add_generatortag() {
        echo '<generator>https://kerosin.digital/rss-chimp</generator>';
    }

    /**
     * Remove the WordPress generator tag from all feeds
     *
     * @since  1.0.0
     */
    function rss_chimp_remove_generatortag() {
        remove_action( 'rss2_head', 'the_generator' );
        remove_action( 'rss_head', 'the_generator' );
        remove_action( 'rdf_header', 'the_generator' );
        remove_action( 'atom_head', 'the_generator' );
        remove_action( 'commentsrss2_head', 'the_generator' );
        remove_action( 'opml_head', 'the_generator' );
        remove_action( 'app_head', 'the_generator' );
        remove_action( 'comments_atom_head', 'the_generator' );
    }

    /**
     * Disable certain feeds
     *
     * @since  1.0.0
     */
    function rss_chimp_redirect_disabled_feed() {
        wp_redirect( home_url() );
        die;
    }

    /**
     * Flush rewrite rules when saving the options page
     *
     * @since  1.2.6
     */
    function rss_chimp_flush_permalinks() {
        if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {
            flush_rewrite_rules();
        }
    }

    /**
     * Admin notices handling
     *
     * @since  1.2.0
     */
    function rss_chimp_admin_notices() {
        if ( isset( $_GET['page'] ) && $_GET['page'] == 'rss-chimp' ) {
            if ( isset( $_GET['settings-updated'] ) ) {
                if ( get_option( 'rss_chimp_channel_choose_image' ) == 'favicon' ) {
                    if ( function_exists( 'wp_site_icon' ) ) {
                        if ( !has_site_icon() ) {
                            echo '<div class="notice notice-warning is-dismissible">';
                            echo '<p>' . __( 'Warning: You have chosen the site favicon as the default RSS channel image, but it is not set.', 'rss-chimp' ) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        if ( !function_exists( 'wp_site_icon' ) ) {
                            echo '<div class="notice notice-error is-dismissible">';
                            echo '<p>' . __( 'Error: You have chosen the site favicon as the default RSS channel image, but your template does not support a favicon.', 'rss-chimp' ) . '</p>';
                            echo '</div>';
                        }
                    }
                }
                if ( get_option( 'rss_chimp_channel_choose_image' ) == 'sitelogo' ) {
                    if ( function_exists( 'the_custom_logo' ) ) {
                        if ( !has_custom_logo() ) {
                            echo '<div class="notice notice-warning is-dismissible">';
                            echo '<p>' . __( 'Warning: You have chosen the site logo as the default RSS channel image, but it is not set.', 'rss-chimp' ) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        if ( !function_exists( 'the_custom_logo' ) ) {
                            echo '<div class="notice notice-error is-dismissible">';
                            echo '<p>' . __( 'Error: You have chosen the site logo as the default RSS channel image, but your template does not support a site logo.', 'rss-chimp' ) . '</p>';
                            echo '</div>';
                        }
                    }
                }
                if ( get_option( 'rss_chimp_channel_choose_image' ) == 'customimage' ) {
                    if ( get_option( 'rss_chimp_channel_custom_image' ) == '' ) {
                        echo '<div class="notice notice-warning is-dismissible">';
                        echo '<p>' . __( 'Warning: You have chosen a custom image as the default RSS channel image, but it is not set.', 'rss-chimp' ) . '</p>';
                        echo '</div>';
                    }
                }
            }
        }
    }

}
