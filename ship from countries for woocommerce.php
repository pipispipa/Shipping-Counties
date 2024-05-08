<?php
/**
 * Plugin Name: Ship From Countries for WooCommerce
 * Plugin URI: [Your Plugin's Home Page or WordPress Plugin Page URL]
 * Description: Adds a meta box to specify countries from which the product is shipped and displays these countries as flags on the product detail page with a modern design. Ensures compatibility with WooCommerce's HPOS feature.
 * Version: 1.1
 * Author: PANNIKOLOV
 * Author URI: [https://profiles.wordpress.org/pannikolov/]
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * WC requires at least: 3.0.0
 * WC tested up to: 5.9.0
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Declare compatibility with WooCommerce's custom order tables feature
add_action('before_woocommerce_init', function() {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

// Enqueue styles for product page only
function ship_from_countries_enqueue_styles() {
    if (is_product()) {
        wp_enqueue_style(
            'ship-from-countries-style',
            plugin_dir_url(__FILE__) . 'css/style.css',
            [],
            filemtime(plugin_dir_path(__FILE__) . 'css/style.css'),
            'all'
        );
    }
}
add_action('wp_enqueue_scripts', 'ship_from_countries_enqueue_styles');

// Enqueue admin scripts and styles securely
function ship_from_countries_admin_scripts() {
    wp_enqueue_script(
        'ship-from-countries-admin-js',
        plugin_dir_url(__FILE__) . 'admin.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . 'admin.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'ship_from_countries_admin_scripts');

// Include other PHP files
include_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';
include_once plugin_dir_path(__FILE__) . 'includes/product-meta-box.php';
include_once plugin_dir_path(__FILE__) . 'includes/display-shipping-info.php';
