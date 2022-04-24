<?php
/**
 * Plugin Name:       Gutenuser
 * Description:       A Gutenberg block to show your user! 
 * Version:           0.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Author:            warren nguyen
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenuser
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

defined( 'ABSPATH' ) || exit;
define('GUTENUSER_PATH', plugin_dir_path( __FILE__ ) );
define('GUTENUSER_URL', plugins_url('',__FILE__) );
define('GUTENUSER_VERSION', '1.0');

include GUTENUSER_PATH.'/inc/setup.php';

/*
 * gutenuser
 * @date	5/4/2022
 * @since	1.0
 * load gutenuser and the other library
 * @param	void
 */
function gutenuser() {
	global $gutenuser;
	
	// Instantiate only once.
	if( !isset($gutenuser) ) {
		$gutenuser = new Wsetup();
		$gutenuser->initialize();
	}
	return $gutenuser;
}

// Instantiate.
gutenuser();