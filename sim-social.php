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
 * Description:       Easily Display Social Media Photo Feed for Instagram. The feed will schedule twicedaily updates, you can also update manually with a single click.
 * Version:           2.4.0
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
     * setup activation schedule
     */
    register_activation_hook( __FILE__, 'sim_social_feed_setup' );

    /**
     * setup some defualts
     */
    function sim_social_feed_setup(){

      /**
       * check if the event is already scheduled
       * if not setup our scheduled event
       * wp_next_scheduled
       * @link https://developer.wordpress.org/reference/functions/wp_next_scheduled/
       */
      if( ! wp_next_scheduled( 'sim_social_feed_cron' ) ){
        wp_schedule_event( time(), 'twicedaily', 'sim_social_feed_cron' );
      }

      /**
       * default
       */
      $simsf_token = array();
      $simsf_token['token'] = null;
      $simsf_token['reset'] = null;

      $simsf_user_media = array();
      $simsf_access_token = array();

      update_option('simsf_token',$simsf_token);
      update_option('simsf_user_media',$simsf_user_media);
      update_option('simsf_access_token',$simsf_access_token);
    }

    /**
     * remove the scheduled event
     */
    register_deactivation_hook( __FILE__, 'sim_social_reset' );
    function sim_social_reset(){

      /**
       * remove the scheduled event
       */
      wp_clear_scheduled_hook( 'sim_social_feed_cron' );

      /**
       * default
       */
      $simsf_token = array();
      $simsf_token['token'] = null;
      $simsf_token['reset'] = null;

      $simsf_user_media = array();
      $simsf_access_token = array();

      update_option('simsf_token',$simsf_token);
      update_option('simsf_user_media',$simsf_user_media);
      update_option('simsf_access_token',$simsf_access_token);
    }


    /**
     * Load composer
     */
    require_once 'vendor/autoload.php';

    /**
     *  require_once // schedule.
     */
    require_once plugin_dir_path( __FILE__ ) . '/src/schedule.php';

    /**
     *  require_once // shortcode.
     */
    require_once plugin_dir_path( __FILE__ ) . '/src/shortcode.php';

    function sim_social_assets() {
      // register styles
      wp_register_style('sim-social-feed-grid', plugin_dir_url(__FILE__) . 'assets/css/simsocial-photo-gird.css', array(), '1.4.3', 'all');
    }
    add_action( 'init', 'sim_social_assets' );

    /**
     * setup the ig class
     */
    function simsocial(){
      /**
       * initialize the feed API
       * how to get the token
       * @link https://www.youtube.com/watch?v=rWUcb8jXgVA
       */
      $instagram = new EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay(get_option('simsf_token')['access_token']);

      /**
       * get the object
       */
      return $instagram;
    }


    /**
     * create admin pages
     */

    SimSocialFeed\Admin\SocialFeedAdmin::init();
