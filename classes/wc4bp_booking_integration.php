<?php
/**
 * @package        WordPress
 * @subpackage     BuddyPress, Woocommerce, WC4BP
 * @author         ThemKraft Dev Team
 * @copyright      2017, Themekraft
 * @link           http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/
 * @license        http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class wc4bp_booking_integration {

    public function __construct() {
        add_filter( 'wc4bp_add_endpoint', array( $this, 'wc4bp_booking_menu_items' ) );

    }

    public function wc4bp_booking_menu_items( $menu_items ) {
        // Add our menu item after the Orders tab if it exists, otherwise just add it to the end
        if ( array_key_exists( 'orders', $menu_items ) ) {
            $menu_items = wcs_array_insert_after( 'orders', $menu_items, 'bookings', __( 'Bookings', 'woocommerce-bookings' ) );
        } else {
            $menu_items['bookings'] = __( 'Bookings', 'woocommerce-bookings' );
        }

        return $menu_items;
    }
}