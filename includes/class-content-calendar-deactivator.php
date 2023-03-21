<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://rishabh.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Content_Calendar
 * @subpackage Content_Calendar/includes
 * @author     Rishabh <rishabh.pandey@wisdmlabs.com>
 */
class Content_Calendar_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$wpdb -> query("DROP TABLE IF EXISTS wp_content_data");
	}

}
