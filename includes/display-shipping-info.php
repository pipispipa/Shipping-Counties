<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('woocommerce_single_product_summary', 'ship_from_countries_display_shipping_info', 25);
function ship_from_countries_display_shipping_info() {
    global $product;
    $companies = get_option('ship_from_countries_companies');
    $selected_company_index = get_post_meta($product->get_id(), '_shipping_company', true);
    $selected_company = $companies[$selected_company_index] ?? null;
    
    if ($selected_company) {
        // Split the country codes and trim each one
        $country_codes = array_map('trim', explode(',', $selected_company['shipping_from']));
        
        // Begin 'Ships from' section
        echo '<div class="shipping-info">Ships from: ';
        
        // Loop through each country code and display its flag
        foreach ($country_codes as $code) {
            // Lowercase the country code to match the image file names
            $code = strtolower($code);
            
            // Create the image tag for the flag
            echo '<img src="https://flagcdn.com/40x30/' . esc_attr($code) . '.png" width="40" height="30" alt="' . esc_attr(strtoupper($code)) . ' flag" /> ';
        }
        
        // End 'Ships from' section
        echo '</div>';
    }
}
