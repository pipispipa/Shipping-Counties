<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('add_meta_boxes', 'ship_from_countries_add_product_meta_box');
function ship_from_countries_add_product_meta_box() {
    add_meta_box('select-shipping-company', 'Select Shipping Company', 'ship_from_countries_product_meta_box_callback', 'product', 'side', 'default');
}

function ship_from_countries_product_meta_box_callback($post) {
    // Nonce field for security
    wp_nonce_field(basename(__FILE__), 'shipping_company_nonce');

    $companies = get_option('ship_from_countries_companies');
    $selected_company = get_post_meta($post->ID, '_shipping_company', true);
    ?>
    <select name="_shipping_company" id="shipping-company-select">
        <option value="">Select a Company</option>
        <?php foreach ((array) $companies as $index => $company): ?>
            <option value="<?php echo esc_attr($index); ?>" <?php selected($selected_company, $index); ?>><?php echo esc_html($company['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}

add_action('save_post', 'ship_from_countries_save_product_meta');
function ship_from_countries_save_product_meta($post_id) {
    // Check if nonce is set
    if (!isset($_POST['shipping_company_nonce']) || !wp_verify_nonce($_POST['shipping_company_nonce'], basename(__FILE__))) {
        return;
    }

    // Proceed with saving data
    if (isset($_POST['_shipping_company'])) {
        update_post_meta($post_id, '_shipping_company', sanitize_text_field($_POST['_shipping_company']));
    }
}


