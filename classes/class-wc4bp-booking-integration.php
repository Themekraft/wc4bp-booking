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

class wc4bp_bookings_integration {

    public function __construct() {

        add_shortcode( 'woo_bookings_page', array( $this, 'wc4bp_my_account_process_shortcode_bookings_page' ) );
        add_shortcode( 'woo_bookings_view_page', array( $this, 'wc4bp_my_account_process_shortcode_bookings_view_page'));
        add_filter( 'wc4bp_add_endpoint', array( $this, 'wc4bp_bookings_menu_items' ) );
        add_filter( 'wc4bp_load_template_path', array( $this, 'load_template_path' ), 99, 2 );
        add_filter( 'wc4bp_members_get_template_directory', array( $this, 'get_template_directory' ), 10, 1 );
        add_filter( 'wc4bp_screen_function', array( $this, 'screen_function' ), 10, 2 );
    }

    public function screen_function( $screen_function, $id ) {
        if ( 'bookings' === $id ) {
            $screen_function = array( $this, 'wc4bp_bookings_screen_function' );
        }
        if($id === 'checkout'){

            if(isset($_GET['change_payment_method'])){

                $screen_function = array( $this, 'wc4bp_bookings_screen_function' );
            }
        }

        return $screen_function;
    }
    public function wc4bp_bookings_screen_function() {
        bp_core_load_template( apply_filters( 'wc4bp_bookings_template', 'shop/member/plugin' ) );
    }

    public function wc4bp_my_account_process_shortcode_bookings_page( $attr, $content ) {

        wc_print_notices();
       $order_management = new  WC_Booking_Order_Manager();
       $order_management->my_bookings();
       // wc_get_template( 'myaccount/bookings.php', array(), '',WC_BOOKINGS_TEMPLATE_PATH  );
    }
    public function load_template_path( $path, $template_directory ) {
        global $bp;
        if ( 'bookings' === $bp->current_action ) {
            $is_view_subscription = array_search( 'view-subscription', $bp->unfiltered_uri, true );
            if ( false !== $is_view_subscription ) {
                $path = 'view-booking';
            } else {
                $path = 'bookings';
            }
        }

        return $path;
    }
    public function get_template_directory( $dir ) {
        global $bp;
        if ( 'bookings' === $bp->current_action ) {
            return wc4bp_bookings_VIEW_PATH;
        }

        return $dir;
    }

    public function wc4bp_bookings_menu_items( $menu_items ) {
        // Add our menu item after the Orders tab if it exists, otherwise just add it to the end
        if ( array_key_exists( 'orders', $menu_items ) ) {
            $menu_items = wc4bp_bookings_manager::array_insert_after( 'orders', $menu_items, 'bookings', __( 'Bookings', 'woocommerce-bookings' ) );
        } else {
            $menu_items['bookings'] = __( 'Bookings', 'woocommerce-bookings' );
        }

        return $menu_items;
    }
}