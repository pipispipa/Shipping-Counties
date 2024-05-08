<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook into the product summary to display shipping information
add_action('woocommerce_single_product_summary', 'ship_from_countries_display_shipping_info', 25);

function ship_from_countries_display_shipping_info() {
    global $product;

    // Retrieve shipping companies from options
    $companies = get_option('ship_from_countries_companies');
    $selected_company_index = get_post_meta($product->get_id(), '_shipping_company', true);
    $selected_company = $companies[$selected_company_index] ?? null;

    // Check if the selected company exists
    if ($selected_company) {
        // Split the country codes, sanitize and trim each one
        $country_codes = array_map('sanitize_text_field', array_map('trim', explode(',', $selected_company['shipping_from'])));

        // Begin 'Ships from' section
        echo '<div class="shipping-info">Ships from: ';

        // Loop through each sanitized country code and display its flag
        foreach ($country_codes as $code) {
            $code = strtolower($code);

            // Create an image tag with escaped attributes for the flag
            echo '<img src="https://flagcdn.com/40x30/' . esc_attr($code) . '.png" width="40" height="30" alt="' . esc_attr(strtoupper($code)) . ' flag" /> ';
        }

        // End 'Ships from' section
        echo '</div>';
    }
}
