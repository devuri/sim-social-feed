<?php

use WPAdminPage\AdminPage;

final class Social_Feed_Admin extends AdminPage {

  /**
   * admin_menu()
   *
   * Main top level admin menus
   * @return [type] [description]
   */
  private static function admin_menu(){
    $menu = array();
    $menu[] = '#ba315c'; //
    $menu[] = 'Social Feed Settings';
    $menu[] = 'Social Feed';
    $menu[] = 'manage_options';
    $menu[] = 'social-feed-settings';
    $menu[] = 'social_feed_callback';
    $menu[] = 'dashicons-camera-alt';
    $menu[] = null;
    $menu[] = 'wpsf';
    $menu[] = plugin_dir_path( __FILE__ );
    return $menu;
  }

  private static function submenu(){
    $menu = array();
    $menu[] = 'Social Feed Settings';
    $menu[] = 'Refresh Feed';
    $menu[] = 'Refresh Access Token';
    return $menu;
  }

  /**
   * init
   * @return
   */
  public static function init(){
    return new Social_Feed_Admin (self::admin_menu(),self::submenu());
  }
}
  // create admin pages
  Social_Feed_Admin::init();
