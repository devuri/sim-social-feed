<?php
/**
 * Sim Social Feed
 *
 * @package           SimSocialFeed
 * @author            Uriel Wilson
 * @copyright         2020 Uriel Wilson
 * @license           GPL-2.0
 * @link           		https://urielwilson.com
 *
 * @wordpress-plugin
 * Plugin Name:       Sim Social Feed
 * Plugin URI:        https://switchwebdev.com/wordpress-plugins/
 * Description:       Easily Display Social Media Photo Feed for Instagram.
 * Version:           1.2.5
 * Requires at least: 3.4
 * Requires PHP:      5.6
 * Author:            SwitchWebdev.com
 * Author URI:        https://switchwebdev.com
 * Text Domain:       sim-social-feed
 * Domain Path:       languages
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

    # deny direct access
    if ( ! defined( 'WPINC' ) ) {
      die;
    }

    /**
     * Load composer
     */
    require_once 'vendor/autoload.php';

    /**
     * setup the ig class
     */
    function simsocial(){
      /**
       * initialize the feed API
       * how to get the token
       * @link https://www.youtube.com/watch?v=rWUcb8jXgVA
       */
      $instagram = new EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay(get_option('wpsf_token'));

      /**
       * get the object
       */
      return $instagram;
    }

    /**
     *  require_once // Load the main class.
     */
    require_once plugin_dir_path( __FILE__ ) . '/src/class-sim-social-feed.php';

    /**
     *  require_once // shortcode.
     */
    require_once plugin_dir_path( __FILE__ ) . '/src/shortcode.php';

    /**
     * load the admin page
     */
    require_once plugin_dir_path( __FILE__ ). 'src/admin/class-socialfeed-settings-admin.php';
