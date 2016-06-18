<?php
/**
 * Plugin Name: WPTally API Shortcodes
 * Plugin URI: https://github.com/ahmadawais/WPTallyAPI-Shortcodes
 * Description: Shortcode to Obtain The Total Download Count For Plugins Attached to a WordPress.org Username.
 * Author: mrahmadawais, WPTie
 * Author URI: http://AhmadAwais.com/
 * Version: 0.0.3
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * GitHub Plugin URL: https://github.com/ahmadawais/WPTallyAPI-Shortcodes/
 *
 * @package WTA
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Define global constants.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WTA_NAME' ) ) {
    define( 'WTA_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

if ( ! defined('WTA_DIR' ) ) {
    define( 'WTA_DIR', WP_PLUGIN_DIR . '/' . WTA_NAME );
}

if ( ! defined('WTA_URL' ) ) {
    define( 'WTA_URL', WP_PLUGIN_URL . '/' . WTA_NAME );
}

/**
 * Class: WP_TALLY_API_Shortcodes.
 *
 * @since 1.0.0
 */
if ( file_exists( WTA_DIR . '/class/class-wp-tally-api-shortcodes.php' ) ) {
    require_once( WTA_DIR . '/class/class-wp-tally-api-shortcodes.php' );
}

new WP_TALLY_API_Shortcodes();
