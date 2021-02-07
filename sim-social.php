<?php
/**
 * Sim Social Feed
 *
 * @package   SimSocialFeed
 * @author    Uriel Wilson
 * @copyright 2020 Uriel Wilson
 * @license   GPL-2.0
 * @link      https://urielwilson.com
 *
 * @wordpress-plugin
 * Plugin Name:       Sim Social Feed
 * Plugin URI:        https://switchwebdev.com/wordpress-plugins/
 * Description:       Easily Display Social Media Photo Feed for Instagram. The feed will schedule twicedaily updates, you can also update manually with a single click.
 * Version:           2.8.1
 * Requires at least: 3.4
 * Requires PHP:      5.6
 * Author:            SwitchWebdev.com
 * Author URI:        https://switchwebdev.com
 * Text Domain:       sim-social-feed
 * Domain Path:       languages
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

 	// deny direct access.
    if ( ! defined( 'WPINC' ) ) {
     	die;
    }

    /**
     * Load composer
     */
    require_once 'vendor/autoload.php';

    /**
     * Setup some defualts setup activation schedule
     */
    register_activation_hook( __FILE__, function() {

	       	/**
	       	 * Check if the event is already scheduled
	       	 * if not setup our scheduled event
	       	 *
	       	 * @link https://developer.wordpress.org/reference/functions/wp_next_scheduled/
	       	 */
		    if ( ! wp_next_scheduled( 'sim_social_feed_cron' ) ) {
		        wp_schedule_event( time(), 'twicedaily', 'sim_social_feed_cron' );
		    }

			/**
			 * Setup some defaults
			 */
			$simsf_token = array();
			$simsf_token['token'] = null;
			$simsf_token['reset'] = null;

			update_option( 'simsf_token', $simsf_token );
			update_option( 'simsf_user_media', array() );
			update_option( 'simsf_access_token', array() );
	    }
	);

    /**
     * Handle Deactivation
     */
    register_deactivation_hook( __FILE__, function() {

		    /**
		     * Remove the scheduled event
		     */
		    wp_clear_scheduled_hook( 'sim_social_feed_cron' );

		    /**
		     * Setup some defaults
		     */
		    $simsf_token = array();
		    $simsf_token['token'] = null;
		    $simsf_token['reset'] = null;

		    update_option( 'simsf_token', $simsf_token );
		    update_option( 'simsf_user_media', array() );
		    update_option( 'simsf_access_token', array() );
	    }
	);

	// register styles.
    add_action( 'init', function() {

	    	wp_register_style( 'igfeed-grid', plugin_dir_url( __FILE__ ) . 'assets/css/igfeed-gird.css', array(), '1.6.3', 'all' );
	    }
	);

    /**
     * Create admin pages
     */
    SimSocialFeed\Admin\SocialFeedAdmin::init();
