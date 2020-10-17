<?php

namespace SimSocialFeed\Admin;

use SimSocialFeed\WPAdminPage\AdminPage;

final class SocialFeedAdmin extends AdminPage {

	/**
	 * Main top level admin menus
	 *
	 * @return array
	 */
	private static function admin_menu() {
	    $menu = array();
	    $menu['mcolor']      = '#ba315c';
	    $menu['page_title']  = 'Instagram Feed';
	    $menu['menu_title']  = 'Social Feed';
	    $menu['capability']  = 'manage_options';
	    $menu['menu_slug']   = 'social-feed-settings';
	    $menu['function']    = 'social_feed_callback';
	    $menu['icon_url']    = 'dashicons-camera-alt';
	    $menu['position']    = null;
	    $menu['prefix']      = 'simsf';
	    $menu['plugin_path'] = plugin_dir_path( __FILE__ );
	    return $menu;
	}

	/**
	 * Submenu
	 *
	 * @return array
	 */
	private static function submenu() {
	    $menu = array();
	    $menu[] = 'Instagram Feed';
	    $menu[] = 'Refresh Access Token';
	    $menu[] = 'Account Setup';
	    return $menu;
	}

	/**
	 * Init
	 *
	 * @return object
	 */
	public static function init() {
	    return new SocialFeedAdmin( self::admin_menu(), self::submenu() );
	}
}
