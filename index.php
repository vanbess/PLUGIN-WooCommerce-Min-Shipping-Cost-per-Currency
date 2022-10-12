<?php

/**
 * Plugin Name:       Minimum Shipping Cost Per Currency
 * Description:       Allows the setup of minimum shipping cost per currency. Requires Currency Switcher for WooCommerce Pro.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            WC Bessinger
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       min-ship-curr
 */

defined('ABSPATH') || exit();

add_action('plugins_loaded', function () {

    // constants
    define('MSC_PATH', plugin_dir_path(__FILE__));
    define('MSC_URL', plugin_dir_url(__FILE__));
    define('MSC_TDOMAIN', 'min-ship-curr');

    // bail if Currency Switcher for WooCommerce Pro
    if (!class_exists('Alg_WC_Currency_Switcher')) : ?>

        <div class="notice notice-error is-dismissible">
            <p><?php _e('<b>Currency Switcher for WooCommerce need to be installed/activated in order for Minimum Shipping Cost Per Currency plugin to work.</b>', MSC_TDOMAIN); ?></p>
        </div>
<?php
        return;
    endif;

    // admin
    include MSC_PATH . 'admin.php';

    // front
    include MSC_PATH . 'front.php';
});
