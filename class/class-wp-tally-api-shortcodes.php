<?php
/**
 * Class: WP_TALLY_API_Shortcodes
 *
 * Main class for shortcodes.
 *
 * @since 	0.0.1
 * @package WTA
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_TALLY_API_Shortcodes' ) ) :

/**
 * WP_TALLY_API_Shortcodes.
 *
 * @since 0.0.1
 */
class WP_TALLY_API_Shortcodes {

	/**
	 * Construct.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		// Load the plugin.
		add_action( 'plugins_loaded', array( $this, 'register' ) );
	}

	/**
	 * Register.
	 *
	 * @since 0.0.1
	 */
	public function register() {
		add_shortcode( 'wta', array( $this, 'shortcode' ) );
	}

	/**
	 * Shortcode.
	 *
	 * @param Attributes $atts Username|Plugin|Plugin Download Count.
	 * @since 0.0.1
	 */
	public function shortcode( $atts ) {
		// Save $atts.
		$_atts = shortcode_atts( array(
		        'u' => 'mrahmadawais', 	// Username.
		        'p' => 'n', 			// Plugin Count.
		        'd' => 'y', 			// Plugin Download Count.
		    ), $atts );
		// Get WPTAlly's object.
		$wptally_response = $this->get_stats( $_atts['u'] );

		// Bail if there is an error.
		if ( ! is_object( $wptally_response ) ) {
			return $wptally_response;
		}

		// Is plugin count?
		if ( 'y' == $_atts['p'] ) {
			// Plugin Count.
			$plugin_count = $wptally_response->info->plugin_count;

			// Return count with no decimal but thousand separator.
			return number_format( $plugin_count, 0, '.', ',' );
		}

		// Is plugin download count?
		if ( 'y' == $_atts['d'] ) {
			// Plugin Download Count.
			$plugin_download_count = $wptally_response->info->total_plugin_downloads;

			// Return count with no decimal but thousand separator.
			return number_format( $plugin_download_count, 0, '.', ',' );
		}

		// Default return.
		return number_format( $plugin_download_count, 0, '.', ',' );
	}

	/**
	 * WP HTTP API GET.
	 *
	 * @param Username $username WPORG Username.
	 * @since 1.0.0
	 */
	public function get_stats( $username ) {
		// Set a transient.
		$transient = 'wta_response';

		// Delete trasient for debugging.
		// delete_transient( $transient );

		// Get the value.
		$wta_transient = get_transient( $transient );

		// WPORG Username.
		// API URL.
		$url = 'http://wptally.com/api/' . $username;

		// If no transient then fetch.
		if ( false === $wta_transient || null === $wta_transient || is_wp_error( $wta_transient ) ) {
			// Get the response.
			$response  = wp_safe_remote_get( $url );

			// If not WP_Error.
			if ( ! is_wp_error( $response ) ) {
				// Retreive the body and JSON decode it as an object.
				$wta = json_decode( wp_remote_retrieve_body( $response ) );

				// Set a transient for future.
		    	set_transient( $transient, $wta, 24 * HOUR_IN_SECONDS );

		    	// Return the object.
				return $wta;
		    } elseif ( true === WP_DEBUG && is_wp_error( $response ) ) {
	    	    return $response->get_error_message();
		    } else {
		    	return '(Unable to fetch at this time!)';
		    }
		} else {
			return $wta_transient;
		}
	}
}

endif;
