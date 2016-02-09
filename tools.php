<?php
/*
Plugin Name: Blue Blaze Tools
Plugin URI:  https://github.com/blueblazeassociates/blueblaze--tools
Description: Provides some extra tools for making WordPress site development easier.
Version:     0.1.0
Author:      Blue Blaze Associates
Author URI:  http://www.blueblazeassociates.com
License:     GPL v2 or later
*/

/**
 * http://www.smashingmagazine.com/2011/03/08/ten-things-every-wordpress-plugin-developer-should-know/
 *
 * @param string $message
 */
function blueblaze_tools__log( $message ) {
  if ( true === WP_DEBUG ) {
    if ( is_array( $message ) || is_object( $message ) ) {
      error_log( print_r( $message, true ) );
    } else {
      error_log( $message );
    }
  }
}

/**
 * Outputs the html checked attribute.
 *
 * Compares the first two arguments and if identical marks as checked
 *
 * This function is a replacement for the 'checked' function that comes with WordPress.
 * This function is different in that it only outputs 'checked' and not the full 'checked="checked"'.
 *
 * For the original implementation, find the function 'checked' in the file wp-includes/general-template.php.
 *
 * For documentation on the original function, see https://codex.wordpress.org/Function_Reference/checked
 *
 * @since 1.0.0
 *
 * @param mixed $checked One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * @return string html attribute or empty string
 */
function blueblaze_tools__checked( $checked, $current = true, $echo = true ) {
  return __blueblaze_tools__checked_selected_helper( $checked, $current, $echo, 'checked' );
}

/**
 * Private helper function for checked, selected, and disabled.
 *
 * Compares the first two arguments and if identical marks as $type
 *
 * @since 2.8.0
 * @access private
 *
 * @param mixed $helper One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * @param string $type The type of checked|selected|disabled we are doing
 * @return string html attribute or empty string
 */
function __blueblaze_tools__checked_selected_helper( $helper, $current, $echo, $type ) {
  if ( (string) $helper === (string) $current ) {
    $result = " $type";
  } else {
    $result = '';
  }

  if ( $echo ) {
    echo $result;
  }

  return $result;
}

/**
 * Disable WordPress Heartbeat, if desired.
 *
 * See http://www.wpbeginner.com/plugins/how-to-limit-heartbeat-api-in-wordpress/
 */
function blueblaze_tools__stop_heartbeat() {
  wp_deregister_script( 'heartbeat' );
}
if ( true === filter_var( getenv( 'BBA_WORDPRESS_DISABLE_HEARTBEAT' ), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ) {
  add_action( 'init', 'blueblaze_tools__stop_heartbeat', 1 );
}

/**
 * Tests whether one string ends with another.
 *
 * @param string $string The string whose end is being tested.
 * @param string $test The ending that is being looked for.
 *
 * @return boolean
 */
function blueblaze_tools__string_endswith( $string, $test ) {
  $strlen = strlen( $string );
  $testlen = strlen( $test );
  if ( $testlen > $strlen ) {
    return false;
  }
  return substr_compare( $string, $test, $strlen - $testlen, $testlen ) === 0;
}
