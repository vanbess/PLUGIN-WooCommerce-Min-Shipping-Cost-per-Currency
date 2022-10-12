<?php

/*********************************************************
 * CHANGE SHIPPING COST IN CART BASED ON DEFINED SETTINGS
 *********************************************************/

/**
 * Overrides Currency Switcher Pro function change_shipping_price_by_currency,
 * which assumes that the shipping cost added below is in the default currency
 * and converts it to the current currency, causing mismatch between backend defined
 * currency -> minimum shipping cost and what is displayed on the front 
 */

add_filter('woocommerce_package_rates', function ($rates, $package) {

    // bail if is admin or not doing ajax
    if (is_admin() && !defined('DOING_AJAX')) :
        return;
    endif;

    // retrieve current currency
    $curr_currency = alg_get_current_currency_code();

    // retrieve currency -> min ship cost array
    $curr_ship_cost_data = maybe_unserialize(get_option('min_ship_costs_curr'));

    // if $curr_currency not in $curr_ship_cost_data, bail and return default rates
    if (!key_exists($curr_currency, $curr_ship_cost_data)) :
        return $rates;
    endif;

    // set cart shipping cost
    $rates['free_shipping:13']->cost = $curr_ship_cost_data[$curr_currency];
    $rates['free_shipping:13']->label = __('Shipping Cost', MSC_TDOMAIN);

    return $rates;
}, PHP_INT_MAX, 2);
