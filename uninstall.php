<?php
/**
 *  Uninstall stuff.
 *  do some cleanup after user uninstalls the plugin
 *  ---------------------------------------------------------------------------
 *  -remove stuff
 * ----------------------------------------------------------------------------
 *
 * @category   Plugin
 * @copyright  Copyright © 2020 Uriel Wilson.
 * @package    SimSocialFeed
 * @author     Uriel Wilson
 * @link       https://switchwebdev.com
 *  ----------------------------------------------------------------------------
 */

	// deny direct access.
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		die;
	}

	// Clear scheduled events.
	wp_clear_scheduled_hook( 'sim_social_feed_cron' );

   	// delete settings in the options table.
  	delete_option( 'simsf_token' );
  	delete_option( 'simsf_access_token' );
  	delete_option( 'simsf_user' );
  	delete_option( 'simsf_user_media' );
  	delete_option( 'simsf_notification_email' );


  	// finally clear the cache.
  	wp_cache_flush();
