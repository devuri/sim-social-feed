<?php
/**
 *  Uninstall stuff.
 *  do some cleanup after user uninstalls the plugin
 *  ----------------------------------------------------------------------------
 *  -remove stuff
 * ----------------------------------------------------------------------------
 * @category  	Plugin
 * @copyright 	Copyright © 2020 Uriel Wilson.
 * @package   	SimSocialFeed
 * @author    	Uriel Wilson
 * @link      	https://switchwebdev.com
 *  ----------------------------------------------------------------------------
 */

	# deny direct access
  if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	  die;
  }

  # delete settings in the options table.
  delete_option('wpsf_user');
  delete_option('wpsf_access_token');
  delete_option('wpsf_user_media');


  //finally clear the cache
  wp_cache_flush();
