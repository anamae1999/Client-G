<?php
add_action( 'wp_enqueue_scripts', 'photograph_enqueue_styles' );
function photograph_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', '', '1.0.9' );

    // wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', '', 1.0 );
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
    // unset($fields['billing']['billing_first_name']);
    // unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    // unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    // unset($fields['billing']['billing_email']);
    unset($fields['account']['account_username']);
    unset($fields['account']['account_password']);
    unset($fields['account']['account_password-2']);

    return $fields;
}

// Reference: https://docs.woocommerce.com/document/image-sizes-theme-developers/
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
    return 'thumbnail';
} );
add_filter( 'woocommerce_gallery_image_size', function( $size ) {
    // return 'woocommerce_thumbnail';
    // return array('', 500);
} );

function custom_footer_scripts(){
    if(is_front_page()): ?>
        <script>
            let hasSale = jQuery( ".sale-products li" ).length;
            if(!hasSale){
                jQuery( ".sale-products-category" ).remove();
            }
        </script>
<?php
    endif;
}
add_action('wp_footer', 'custom_footer_scripts');

/**
 * Removes the payment instructions from the COD payment gateway in WooCommerce.
 */
function custom_remove_instructions(){
    if ( ! class_exists( 'WC_Payment_Gateways' ) ) {
        return;
    }
    $gateways           = WC_Payment_Gateways::instance(); // gateway instance
    $available_gateways = $gateways->get_available_payment_gateways();
    if ( isset( $available_gateways['cod'] ) ) {
        remove_action( 'woocommerce_email_before_order_table', array( $available_gateways['cod'], 'email_instructions' ), 10, 3 );
    }
}
add_action( 'woocommerce_email_before_order_table', 'custom_remove_instructions', 1 );

// Adds image to WooCommerce order emails
function add_image_to_wc_emails( $args ) {
    $args['show_image'] = true;
    $args['image_size'] = array( 100, 50 );
    return $args;
}
add_filter( 'woocommerce_email_order_items_args', 'add_image_to_wc_emails' );

function header_custom_code(){ ?>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '227161372249754');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=227161372249754&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
<?php
}
add_action('wp_head', 'header_custom_code');

function disallow_adding_addons_only($is_valid, $product_id) {
    $addon_product_ids = array(
        524, // mini caviar pie
        309, // wine
        308, // mini wine
    );
    $addon_exceptions = array(
        307, // pesto
    );

    $is_addon = in_array($product_id, $addon_product_ids); // not including pesto
    $error_message = __( 'You cannot add addons ONLY to your cart.', 'woocommerce' );
    $cart = WC()->cart->get_cart();
    if(empty($cart)){
        if(!in_array($product_id, $addon_product_ids)){
            return true;
        }
    }
    else {
        foreach($cart as $cart_item_key => $values) {
            $product = $values['data'];
            if($is_addon && in_array($product->id, $addon_exceptions)){
                continue;
            }
            if (!in_array($product->id, $addon_product_ids)) {
                return true;
            }

            /**
             * TODO: Dynamic approach
             * - check if the current product being added is under 'Add Ons' category
             *
             * $categories = wc_get_product_category_list( $product->get_id() ); // returns categories in string
             *
             */
        }
    }

    wc_add_notice( $error_message, 'error' );
    return false;
}
add_filter('woocommerce_add_to_cart_validation', 'disallow_adding_addons_only', 10, 2);

function disallow_update_addons_remaining( $removed_cart_item_key, $instance )
{
    $addon_product_ids = array(
        524, // mini caviar pie
        309, // wine
        308 // mini wine
    );
    $addon_exceptions = array(
        307 // pesto
    );

    $error_message = __( 'Not allowed having addons ONLY', 'woocommerce' );
    $has_main_product = false;
    $has_addon = false;
    $has_addon_exceptions = false;

    $cart = WC()->cart->get_cart();
    foreach($cart as $cart_item_key => $cart_item_values) {
        $product = $cart_item_values['data'];
        $product_id = $product->id;

        // if($cart_item_key == $removed_cart_item_key){
        //     continue;
        // }

        if (!in_array($product_id, $addon_product_ids)){ // could be main product / addon exceptions

            if(!in_array($product_id, $addon_exceptions)){
                $has_main_product = true;
                break;
            }
            else {
                $has_addon_exceptions = true;
            }
        }
        else {
            $has_addon = true;
        }
    }

    if(!$has_main_product && $has_addon){
        $instance->restore_cart_item( $removed_cart_item_key );
        wc_add_notice( $error_message, 'error' );
        add_filter('woocommerce_add_success', '__return_false');
    }
}
// woocommerce_remove_cart_item - before the item is removed
add_action( 'woocommerce_cart_item_removed', 'disallow_update_addons_remaining', 10, 2 );

?>