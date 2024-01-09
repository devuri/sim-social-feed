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

		if ( isset( get_option('simsf_access_token')['access_token'] ) ) {
			return get_option('simsf_access_token')['access_token'];
		}

		if ( ! isset( get_option( 'simsf_token' )['access_token'] ) ) {
			return false;
		}

		if ( is_null( get_option( 'simsf_token' )['access_token'] ) ) {
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
		return (array) self::api()->getUserProfile();
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
	 * Token Update schedule.
	 *
	 * Number of days set for token auto update.
	 * this returns 40 days by default if not set.
	 *
	 * @return int .
	 */
	public static function token_update_schedule() {
		return absint(  get_option( 'simsf_update_schedule', 40 ) );
	}

	/**
	 * Days since last refresh.
	 */
	public static function days_since() {

		if ( self::has_refresh() ) {

			$ds = self::token_update_schedule();

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh = strtotime("+$ds day", $created_date );

			// check time since last refresh.
			if ( time() >= $next_refresh ) {
				return true;
			}
			return false;
		}
	}

	/**
	 * Automatic token refresh.
	 */
	public static function maybe_refresh_token() {

		if ( self::days_since() ) {

			self::refresh_token();

		}
	}

	/**
	 * Refresh Token
	 * convert token object to array
	 * add created and expire date
	 *
	 * @return array
	 */
	public static function refresh_token() {

		/* get previous update date */
		$previously = date_i18n( get_option( 'date_format' ), $user_token['created_at'] );

		/* setup api */
		$newtoken = self::api()->refreshToken( self::access_token() );
		$user_token = (array) $newtoken;

		/**
		 * Add a expire date and created date
		 * uses Unix timestamp
		 */
		$user_token['expire_date'] = time() + $user_token['expires_in'];
		$user_token['created_at']  = time();
		$user_token['refresh']     = true;

		// update token option.
		update_option('simsf_access_token', $user_token );

		// message vars.
  		$blog_name         = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
  		$token_created     = date_i18n( get_option( 'date_format' ), $user_token['created_at'] );
  		$token_will_expire = date_i18n( get_option( 'date_format' ), $user_token['expire_date'] );
 		$admin_user        = get_option( 'admin_email' );
 		$subject           = 'New: '. $token_created . ' Access Token Update ' . wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		// email message.
		$message = __(
		'Hey there!

		This notification confirms that your Instagram User Access Token Has Been Updated on ###SITENAME###.

		Token was updated: ###CREATED###, Token will expire: ###EXPIRES###.

		Refreshed tokens are valid for 60 days from the date at which they are refreshed.
		The Sim Social Feed plugin will automatically refresh your Access Token before it expires.

		Token was last Updated: ###PREVIOUS###

		This email has been sent to ###ADMIN_EMAIL###.

		Regards,
		[Sim Social Feed] plugin Notification.

		You have received this email notification to update you about your ###SITENAME### website.'
		);

		// message.
		$message = str_replace( '###SITENAME###', $blog_name, $message );
		$message = str_replace( '###CREATED###', $token_created, $message );
		$message = str_replace( '###EXPIRES###', $token_will_expire, $message );
		$message = str_replace( '###PREVIOUS###', $previously, $message );
		//$message = str_replace( '###ADMIN_EMAIL###', get_option( 'admin_email' ), $message );
		$message = str_replace( '###ADMIN_EMAIL###', self::notification_email(), $message );

		// new token array
		$igtoken = array();
		$igtoken['access_token'] = get_option('simsf_access_token')['access_token'];
		$igtoken['reset'] = false;

		// set new token value
		update_option('simsf_token', $igtoken );

		// send email.
		wp_mail( $admin_user, $subject, $message );

		return $user_token;
	}

	/**
	 * Notification about auto updates.
	 *
	 * @return string .
	 */
	public static function notification_email() {
		if ( get_option( 'simsf_notification_email', false ) ) {
			return get_option( 'simsf_notification_email' );
		}
		get_option( 'admin_email' );
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
			return date_i18n( get_option( 'date_format' ), $created_date);
		}
		return 'no date was found ! ';
	}
}
