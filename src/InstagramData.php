<?php

namespace SimSocialFeed;

use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

class InstagramData
{
	/**
	 * Get defined Access Token
	 *
	 * @return mixed bool|string
	 */
	public static function access_token() {

		if ( ! isset( get_option( 'simsf_token' )['access_token'] ) ) {
			return false;
		}

		if ( false === get_option( 'simsf_token' )['access_token'] ) {
			return false;
		}

		if ( empty( get_option( 'simsf_token' )['access_token'] ) ) {
			return false;
		}

		return get_option( 'simsf_token' )['access_token'];
	}

	/**
	 * Setup the IG class
	 *
	 * Initialize the feed API
	 * how to get the token
	 *
	 * @link https://www.youtube.com/watch?v=rWUcb8jXgVA
	 * @link https://github.com/espresso-dev/instagram-basic-display-php
	 */
	public static function api() {
		return new InstagramBasicDisplay( self::access_token() );
	}

	/**
	 * Lets make sure all is well
	 *
	 * @return boolean
	 */
	public static function is_request_ok() {
		try {
			self::api()->getUserProfile();
		} catch ( \Exception $e ) {
			return false;
		}
		return true;
	}

	/**
	 * Error_message()
	 * give the user some feedback for request error
	 *
	 * @return string
	 */
	public static function error_message() {
		return 'Error: The Request Failed. <br> Configuration data is missing or incorrect <br> Please check the Account Settings !!!';
	}

	/**
	 * Check the user ID
	 *
	 * @return boolean
	 */
	public static function user_check() {
		if ( isset( get_option( 'simsf_user' )['id'] ) ) {
			if ( is_numeric( get_option( 'simsf_user' )['id'] ) ) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * User profile
	 *
	 * Convert user data object to array
	 *
	 * @return array
	 */
	public static function user_profile() {
		$user = self::api()->getUserProfile();
		$user_data = (array) $user;
		return $user_data;
	}

	/**
	 * User media
	 *
	 * @return object
	 */
	public static function user_media() {

		// Get the users profile.
		$id = get_option( 'simsf_user' )['id'];

		// get the media.
		$user_media = self::api()->getUserMedia( $id, 40 );

		// media.
		return $user_media;
	}

	/**
	 * Calculate the date based on 60 Day Token
	 *
	 * @param int $expires_in The number of seconds until the long-lived token expires.
	 * @return string
	 */
	public function expires( $expires_in = 5184000 ) {
		$days = intval( intval( $expires_in ) / ( 3600 * 24 ) );
	$expires_date = date_i18n( get_option( 'date_format' ), strtotime( "+$days days" ) );
		return $expires_date;
	}

	/**
	 * Refresh Token
	 * convert token object to array
	 * add created and expire date
	 *
	 * @return array
	 */
	public static function refresh_token() {
		$newtoken = self::api()->refreshToken( self::access_token() );
		$user_token = (array) $newtoken;

		/**
		 * Add a expire date and created date
		 * uses Unix timestamp
		 */
		$user_token['expire_date'] = time() + $user_token['expires_in'];
		$user_token['created_at']  = time();
		$user_token['refresh']     = true;
		return $user_token;
	}

	/**
	 * Check if the token has been Refreshed
	 *
	 * @return boolean
	 */
	private static function has_refresh() {
		if ( ! empty( get_option( 'simsf_access_token' ) ) ) {
			if ( get_option( 'simsf_access_token' )['refresh'] ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the token expire date
	 *
	 * @return string $date
	 */
	public static function token_expire_date() {
		if ( self::has_refresh() ) {
			$expire = get_option( 'simsf_access_token' )['expire_date'];
			$date = date_i18n( get_option( 'date_format' ), $expire );
			return $date;
		}
		return 'no expire date was found ! ';
	}

	/**
	 * Get the token created at date
	 *
	 * When was the last token refreshed.
	 *
	 * @return string $date
	 */
	public static function token_created_date() {
		if ( self::has_refresh() ) {
			$created_date = get_option( 'simsf_access_token' )['created_at'];
			$date = date_i18n( get_option( 'date_format' ), $created_date);
			return $date;
		}
		return 'no date was found ! ';
	}

}
