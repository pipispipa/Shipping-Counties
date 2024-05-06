<?php
/**
 * Plugin Name: Ship From Countries for WooCommerce
 * Description: Adds a meta box to specify countries from which the product is shipped and displays these countries as flags on the product detail page with a modern design. Ensures compatibility with WooCommerce's HPOS feature.
 * Version: 1.1
 * Author: PANNIKOLOV
 * WC requires at least: 3.0.0
 * WC tested up to: 5.9.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Declare compatibility with WooCommerce's custom order tables feature.
add_action('before_woocommerce_init', function() {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

// styling
function ship_from_countries_enqueue_styles() {
    if (is_product()) {
        wp_enqueue_style('ship-from-countries-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), filemtime(plugin_dir_path(__FILE__) . 'css/style.css'), 'all');
    }
}
add_action('wp_enqueue_scripts', 'ship_from_countries_enqueue_styles');


// Enqueue admin scripts and styles
function ship_from_countries_admin_scripts() {
    wp_enqueue_script('ship-from-countries-admin-js', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'admin.js'), true);
}
add_action('admin_enqueue_scripts', 'ship_from_countries_admin_scripts');


// Register and display the settings page
include_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Add custom product meta box for selecting shipping companies
include_once plugin_dir_path(__FILE__) . 'includes/product-meta-box.php';

// Display selected company's shipping countries on the product page
include_once plugin_dir_path(__FILE__) . 'includes/display-shipping-info.php';