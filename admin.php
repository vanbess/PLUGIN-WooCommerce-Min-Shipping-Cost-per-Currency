<?php

/**
 * ADMIN PAGE   
 */

add_action('admin_menu', function () {
    add_menu_page(
        __('Minimum Shipping Cost per Currency', MSC_TDOMAIN),
        __('Currency Shipping', MSC_TDOMAIN),
        'manage_options',
        'min-currency-ship-cost',
        'min_currency_ship_cost',
        'dashicons-airplane',
        20
    );
});

// render admin page
function min_currency_ship_cost() {

    global $title; ?>

    <div>

        <h2 style="background: white; padding: 15px 20px; margin-top: 0; margin-left: -19px; box-shadow: 0px 2px 4px lightgrey;"><?php echo $title; ?></h2>

        <div id="msc-cont">

            <?php
            if (isset($_POST['msc-save-settings'])) :

                // retrieve currency and ship cost data
                $currencies = $_POST['currencies'];
                $ship_costs = $_POST['ship_costs'];

                // combine
                $combined = array_combine($currencies, $ship_costs);

                // filter
                $combined = array_filter($combined);

                // save
                update_option('min_ship_costs_curr', maybe_serialize($combined));

                // admin notice 
            ?>

                <div class="notice notice-success is-dismissible" style="left: -15px;">
                    <p><?php _e('Settings saved successfully.', MSC_TDOMAIN); ?></p>
                </div>
            <?php endif; ?>

            <p>
                <i>
                    <b>
                        <?php _e('Use the inputs below to define minimum shipping cost per currency.<br> Note that currency list below is determined by currencies set up under WooCommerce->Settings->Currency Settings->Currencies.<br> You can leave minimum shipping cost input empty to disable for a specific currency.', MSC_TDOMAIN); ?>
                    </b>
                </i>
            </p>

            <form action="" method="post">

                <?php
                // retrieve current settings
                $curr_settings = maybe_unserialize(get_option('min_ship_costs_curr'));

                // retrieve enable currencies
                $enabled_currencies = alg_get_enabled_currencies();

                // loop
                foreach ($enabled_currencies as $currency) : ?>
                    <p>
                        <input type="text" class="min-ship-currency" name="currencies[]" readonly value="<?php echo $currency; ?>" style="background: #72aee64a; font-weight: 500;">
                        <input type="number" class="min-ship-cost" name="ship_costs[]" min="0.01" step="0.01" value="<?php echo $curr_settings ? $curr_settings[$currency] : ''; ?>" placeholder="<?php echo 'min ship cost'; ?>">
                    </p>
                <?php endforeach; ?>

                <!-- save settings -->
                <p>
                    <input type="submit" class="button button-primary button-large" name="msc-save-settings" value="<?php _e('Save Settings', MSC_TDOMAIN); ?>">
                </p>
            </form>

        </div>

    </div>

<?php }
