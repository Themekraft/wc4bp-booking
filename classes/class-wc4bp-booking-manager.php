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

class wc4bp_booking_manager {
	private static $plugin_slug = 'wc4bp_booking';
	protected static $version = '1.0.0';
	private $end_points;

	public function __construct() {
		require_once 'class-wc4bp-booking-log.php';
		new wc4bp_booking_log();
		try {
			//loading_dependency
			require_once 'class-wc4bp-booking-integration.php';
			new wc4bp_booking_integration();

		} catch ( Exception $ex ) {
			wc4bp_booking_log::log( array(
				'action'         => get_class( $this ),
				'object_type'    => self::getSlug(),
				'object_subtype' => 'loading_dependency',
				'object_name'    => $ex->getMessage(),
			) );
		}
	}

	/**
	 * Get plugins version
	 *
	 * @return mixed
	 */
	static function getVersion() {
		return self::$version;
	}

	/**
	 * Get plugins slug
	 *
	 * @return string
	 */
	static function getSlug() {
		return self::$plugin_slug;
	}

	/*
	 * Inserts a new key/value after the key in the array.
	 *
	 * @param $key
	 *   The key to insert after.
	 * @param $array
	 *   An array to insert in to.
	 * @param $new_key
	 *   The key to insert.
	 * @param $new_value
	 *   An value to insert.
	 *
	 * @return
	 *   The new array if the key exists, FALSE otherwise.
	 *
	 * @see array_insert_before()
	 */
	static function array_insert_after( $key, array &$array, $new_key, $new_value ) {
		if ( array_key_exists( $key, $array ) ) {
			$new = array();
			foreach ( $array as $k => $value ) {
				$new[ $k ] = $value;
				if ( $k === $key ) {
					$new[ $new_key ] = $new_value;
				}
			}

			return $new;
		}

		return false;
	}
}
