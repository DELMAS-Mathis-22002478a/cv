<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.abyxo.com
 * @since      1.0.0
 *
 * @package    cvchekout
 * @subpackage cvchekout/includes
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
 * @package    cvchekout
 * @subpackage cvchekout/includes
 * @author     Dylan Prudhomme <dylan.prudhomme@abyxo.agency>
 */
class cvchekout {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      cvchekout_Loader    $loader    Maintains and registers all hooks for the plugin.
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
        if ( defined( 'cvchekout_VERSION' ) ) {
            $this->version = cvchekout_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'cvchekout';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - cvchekout_Loader. Orchestrates the hooks of the plugin.
     * - cvchekout_i18n. Defines internationalization functionality.
     * - cvchekout_Admin. Defines all hooks for the admin area.
     * - cvchekout_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /* 
         * Utilities functions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/utils.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cvchekout-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cvchekout-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cvchekout-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cvchekout-admin-shipping.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public-woocommerce.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public-woocommerce-template.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public-product-extras.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public-shipping.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvchekout-public-checkout.php';

        $this->loader = new cvchekout_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the cvchekout_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new cvchekout_i18n();

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

        $plugin_admin = new cvchekout_Admin( $this->get_plugin_name(), $this->get_version() );
        $plugin_shipping = new cvchekout_Admin_Shipping();

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action( 'woocommerce_init', $plugin_shipping, 'add_shipping_form_fields');
        $this->loader->add_filter( 'woocommerce_form_field_media', $plugin_shipping, 'filter_woocommerce_form_field_media', 10, 4 );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new cvchekout_Public( $this->get_plugin_name(), $this->get_version() );
        $plugin_woocommerce = new cvchekout_Public_Woocommerce();
        $plugin_woocommerce_template = new cvchekout_Public_Woocommerce_Template();
        $plugin_product_extras = new cvchekout_Public_Product_Extras();
        $plugin_shipping = new cvchekout_Public_Shipping();
        $plugin_checkout = new cvchekout_Public_Checkout();

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        // Woocommerce
        $this->loader->add_filter( 'woocommerce_login_redirect', $plugin_woocommerce, 'custom_redirect_after_login', 10, 2 );
        // Woocommerce override templates through plugin
        add_filter('woocommerce_shipping_calculator_enable_city', '__return_false');
        add_filter('woocommerce_shipping_calculator_enable_state', '__return_false');
        $this->loader->add_filter( 'woocommerce_locate_template', $plugin_woocommerce_template, 'add_woocommerce_template_path', 10, 3 );
        $this->loader->add_filter( 'woocommerce_cart_item_name', $plugin_woocommerce_template, 'remove_variation_from_product_title', 10, 3 );
        $this->loader->add_filter( 'woocommerce_after_cart_item_name', $plugin_woocommerce_template, 'add_variation_under_product_title', 10, 2 );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_woocommerce_template, 'selectwoo_dequeue_stylesandscripts', 100 );
        // Woocommerce shipping
        $this->loader->add_filter( 'woocommerce_package_rates', $plugin_shipping, 'custom_shipping_costs', 20, 2 );
        // Wocoommerce checkout
        $this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_checkout, 'reorganise_checkout_fields');
        $this->loader->add_filter( 'woocommerce_gateway_icon', $plugin_woocommerce_template, 'edit_paypal_icon', 10, 2);
        // Woocommerce move payment under customer details
        $this->loader->add_action( 'wp_head', $plugin_woocommerce_template, 'move_payment_methods_under_customer_details');
        // Ultimate product addons twigs
        $this->loader->add_filter( 'pewc_filter_end_add_cart_item_data', $plugin_product_extras, 'add_group_item_field_to_cart_item_data', 10, 5 );
        $this->loader->add_filter( 'pewc_end_get_item_data', $plugin_product_extras, 'edit_cart_item_data', 10, 3 );
        $this->loader->add_action( 'pewc_field_item_extra_fields', $plugin_product_extras, 'pewc_add_addons_parameters', 10, 4 );
        $this->loader->add_filter( 'pewc_item_params', $plugin_product_extras, 'pewc_add_custom_field_params', 10, 2 );
        $this->loader->add_filter( 'pewc_default_field_value', $plugin_product_extras, 'add_textarea_default_value', 10, 4 );
        // Ajax update custom cart item meta
        $this->loader->add_action( 'wp_ajax_nopriv_cvchekout_update_gift_message', $plugin_product_extras, 'cvchekout_update_gift_message' );
        $this->loader->add_action( 'wp_ajax_cvchekout_update_gift_message', $plugin_product_extras, 'cvchekout_update_gift_message' );
        // Ajax delete custom cart item meta
        $this->loader->add_action( 'wp_ajax_nopriv_cvchekout_delete_gift_option', $plugin_product_extras, 'cvchekout_delete_gift_option' );
        $this->loader->add_action( 'wp_ajax_cvchekout_delete_gift_option', $plugin_product_extras, 'cvchekout_delete_gift_option' );
        // Ajax add custom cart item meta
        $this->loader->add_action( 'wp_ajax_nopriv_cvchekout_add_gift_option', $plugin_product_extras, 'cvchekout_add_gift_option' );
        $this->loader->add_action( 'wp_ajax_cvchekout_add_gift_option', $plugin_product_extras, 'cvchekout_add_gift_option' );
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
     * @return    cvchekout_Loader    Orchestrates the hooks of the plugin.
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
