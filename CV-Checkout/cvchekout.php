<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.abyxo.com
 * @since             1.0.0
 * @package           cv-checkout
 *
 * @wordpress-plugin
 * Plugin Name:       CV-Checkout
 * Plugin URI:        https://www.abyxo.com
 * Description:       Plugin made by Abyxo for Carriere-Villa website.
 * Version:           1.0.0
 * Author:            Mathis Delmas
 * Author URI:        https://www.abyxo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cv-checkout
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'cvchekout_VERSION', '1.0.0' );
define( 'cvchekout_PLUGIN_URL_PATH', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cvchekout-activator.php
 */
function activate_cvchekout() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cvchekout-activator.php';
	cvchekout_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cvchekout-deactivator.php
 */
function deactivate_cvchekout() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cvchekout-deactivator.php';
	cvchekout_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cvchekout' );
register_deactivation_hook( __FILE__, 'deactivate_cvchekout' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cvchekout.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cvchekout() {

	$plugin = new cvchekout();
	$plugin->run();

}
run_cvchekout();

add_action( 'woocommerce_before_checkout_form', 'bbloomer_cart_on_checkout_page', 11 );

function bbloomer_cart_on_checkout_page() {
    echo do_shortcode( '[elementor-template id="171"]' );
}

add_action( 'woocommerce_before_checkout_form', 'add_login_on_cart_checkout_page', 11 );

function add_login_on_cart_checkout_page() {
    echo do_shortcode( '[elementor-template id="176"]' );
}

add_action( 'woocommerce_before_checkout_form', 'add_register_on_cart_checkout_page', 11 );

function add_register_on_cart_checkout_page() {
    echo do_shortcode( '[elementor-template id="10233"]' );
}

add_action( 'woocommerce_before_checkout_form', 'add_produit_complementaire_to_checkout', 11 );

function add_produit_complementaire_to_checkout() {
    echo do_shortcode( '[elementor-template id="10234"]' );
}




