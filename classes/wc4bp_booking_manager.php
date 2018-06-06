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
		require_once 'wc4bp_booking_log.php';
		new wc4bp_booking_log();
		try {
			//loading_dependency
			require_once 'wc4bp_booking_integration.php';
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
}
