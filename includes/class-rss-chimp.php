<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://kerosin.digital/
 * @since      1.0.0
 *
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Rss_Chimp
 * @subpackage Rss_Chimp/includes
 * @author     kerosin.digital <hello@kerosin.digital>
 */
class Rss_Chimp {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rss_Chimp_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'RSS_CHIMP_VERSION' ) ) {
            $this->version = RSS_CHIMP_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'rss-chimp';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Rss_Chimp_Loader. Orchestrates the hooks of the plugin.
     * - Rss_Chimp_i18n. Defines internationalization functionality.
     * - Rss_Chimp_Admin. Defines all hooks for the admin area.
     * - Rss_Chimp_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rss-chimp-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rss-chimp-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rss-chimp-admin.php';
        $this->loader = new Rss_Chimp_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Rss_Chimp_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new Rss_Chimp_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new Rss_Chimp_Admin($this->get_plugin_name(), $this->get_version());
        rss_chimp_fs()->add_filter( 'plugin_icon', 'rss_chimp_custom_icon' );
        //Compatibility:  Check if Rank Math is active
        if ( is_plugin_active( 'seo-by-rank-math-pro/rank-math-pro.php' ) ) {
            add_filter( 'rank_math/rss/add_media_namespace', function () {
                echo "";
            }, 20 );
        }
        if ( isset( $_GET['page'] ) && $_GET['page'] == 'rss-chimp' || isset( $_GET['page'] ) && $_GET['page'] == 'rss-chimp-account' || isset( $_GET['page'] ) && $_GET['page'] == 'rss-chimp-pricing' ) {
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        }
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'rss_chimp_admin_notices' );
        $this->loader->add_action(
            'admin_menu',
            $plugin_admin,
            'rss_chimp_menu_pages',
            11
        );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'rss_chimp_settings_init' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'rss_chimp_flush_permalinks' );
        $this->loader->add_action( 'after_setup_theme', $plugin_admin, 'rss_chimp_imagesizes' );
        $this->loader->add_action( 'rss2_ns', $plugin_admin, 'rss_chimp_add_namespace' );
        $this->loader->add_action( 'rss2_item', $plugin_admin, 'rss_chimp_add_featuredimage' );
        $this->loader->add_action( 'the_permalink_rss', $plugin_admin, 'rss_chimp_defaultfeed_add_link_parameter' );
        // Channel settings
        if ( get_option( 'rss_chimp_channel_choose_image' ) !== 'off' ) {
            $this->loader->add_action( 'rss2_head', $plugin_admin, 'rss_chimp_channel_add_image' );
        }
        $this->loader->add_action( 'after_setup_theme', $plugin_admin, 'rss_chimp_channel_remove_favicon' );
        // Disable comments feed
        if ( get_option( 'rss_chimp_disable_commentsfeed' ) == '1' ) {
            add_filter( 'feed_links_show_comments_feed', '__return_false' );
        }
        $this->loader->add_action( 'after_setup_theme', $plugin_admin, 'rss_chimp_remove_generatortag' );
        $this->loader->add_action(
            'rss2_head',
            $plugin_admin,
            'rss_chimp_add_generatortag',
            10,
            1
        );
        // Disable feeds
        if ( get_option( 'rss_chimp_defaultfeed_disable' ) == '1' ) {
            $this->loader->add_action(
                'do_feed',
                $plugin_admin,
                'rss_chimp_redirect_disabled_feed',
                1
            );
            $this->loader->add_action(
                'do_feed_rdf',
                $plugin_admin,
                'rss_chimp_redirect_disabled_feed',
                1
            );
            $this->loader->add_action(
                'do_feed_rss',
                $plugin_admin,
                'rss_chimp_redirect_disabled_feed',
                1
            );
            $this->loader->add_action(
                'do_feed_rss2',
                $plugin_admin,
                'rss_chimp_redirect_disabled_feed',
                1
            );
            $this->loader->add_action(
                'do_feed_atom',
                $plugin_admin,
                'rss_chimp_redirect_disabled_feed',
                1
            );
            remove_action( 'wp_head', 'feed_links', 2 );
            remove_action( 'wp_head', 'feed_links_extra', 3 );
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Rss_Chimp_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
