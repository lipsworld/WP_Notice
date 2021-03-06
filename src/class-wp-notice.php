<?php
/**
 * Display notices in WordPress administration panel.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius\WP_Notice
 * @copyright 2017 - 2018 (c) Josantonius - WP_Notice
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Notice
 * @since     1.0.0
 */

namespace Josantonius\WP_Notice;

/**
 * Notice Handler.
 */
class WP_Notice {

	/**
	 * Array with notices.
	 *
	 * @var array $notices
	 */
	public static $notices = null;

	/**
	 * Set notices.
	 *
	 * @param string $index → index.
	 * @param array  $param → param.
	 *
	 * @return boolean true
	 */
	public static function __callstatic( $index, $param ) {

		if ( is_null( self::$notices ) ) {
			add_action( 'admin_notices', __CLASS__ . '::display' );
		}

		$message = isset( $param[0] ) ? $param[0] : 'unknown';
		$remove  = ( isset( $param[1] ) && ! $param[1] ) ? '' : 'is-dismissible';

		if ( 'error' === $index && isset( $param[0]->errors ) ) {
			foreach ( $param[0]->errors as $value ) {
				$message = $value[0];
			}
		}

		$class = 'notice notice-' . $index . ' ' . $remove;

		self::$notices[] = "<div class='$class'><p>$message</p></div>";

		return true;
	}

	/**
	 * Display all saved notices.
	 *
	 * @return void
	 */
	public static function display() {

		foreach ( self::$notices as $value ) {
			echo $value;
		}
	}
}
