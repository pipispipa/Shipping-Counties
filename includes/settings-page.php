<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('admin_menu', 'ship_from_countries_add_admin_menu');
function ship_from_countries_add_admin_menu() { 
    add_menu_page('Shipping Companies', 'Shipping Companies', 'manage_options', 'ship-from-countries', 'ship_from_countries_settings_page');
}

add_action('admin_init', 'ship_from_countries_settings_init');
function ship_from_countries_settings_init() { 
    register_setting('shipFromCountries', 'ship_from_countries_companies');
}

function ship_from_countries_settings_page() {
    ?>
    <div class="wrap">
    <h2>Shipping Companies</h2>
    <form method="post" action="options.php">
        <?php
        settings_fields('shipFromCountries');
        // Ensure $companies is always an array
        $companies = get_option('ship_from_countries_companies');
        if (!is_array($companies)) {
            $companies = []; // Initialize as an empty array if not set
        }
        ?>
        <table class="form-table">
            <tbody id="shipping-companies">
            <?php foreach ($companies as $index => $company): ?>
                <tr valign="top">
                    <th scope="row">Company Name:</th>
                    <td>
                        <input type="text" name="ship_from_countries_companies[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($company['name'] ?? ''); ?>" />
                        Shipping From: <input type="text" name="ship_from_countries_companies[<?php echo esc_attr($index); ?>][shipping_from]" value="<?php echo esc_attr($company['shipping_from'] ?? ''); ?>" />
                        <button class="button remove-company" type="button">Remove</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button id="add-company" class="button">Add Company</button>
        <?php submit_button(); ?>
    </form>
    </div>
    <script>
        // JavaScript for adding and removing companies
    </script>
    <?php
}
