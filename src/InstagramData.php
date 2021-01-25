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
	 * lets only refresh after 24 hours.
	 */
	public static function is_24_hours_since() {

		if ( self::has_refresh() ) {

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh_can = strtotime('+1 day', $created_date );

			// check time since last refresh.
			if ( time() >= $next_refresh_can ) {
				return true;
			}
			return false;
		}
	}

	/**
	 * lets only refresh after 48 hours.
	 */
	public static function is_48_hours_since() {

		if ( self::has_refresh() ) {

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh_can = strtotime('+2 day', $created_date );

			// check time since last refresh.
			if ( time() >= $next_refresh_can ) {
				return true;
			}
			return false;
		}
	}

	/**
	 * 30 Days since last refresh.
	 */
	public static function is_30_days_since() {

		if ( self::has_refresh() ) {

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh = strtotime('+30 day', $created_date );

			// check time since last refresh.
			if ( time() >= $next_refresh ) {
				return true;
			}
			return false;
		}
	}

	/**
	 * 40 Days since last refresh.
	 */
	public static function is_40_days_since() {

		if ( self::has_refresh() ) {

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh = $created_date + 40 * 24 * 3600;

			// check time since last refresh.
			if ( time() >= $next_refresh ) {
				return true;
			}
			return false;
		}
	}

	/**
	 * 45 Days since last refresh.
	 */
	public static function is_45_days_since() {

		if ( self::has_refresh() ) {

			$created_date = get_option( 'simsf_access_token' )['created_at'];

			$next_refresh = strtotime('+45 day', $created_date );

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

		if ( self::is_45_days_since() ) {

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

		$newtoken = self::api()->refreshToken( self::access_token() );
		$user_token = (array) $newtoken;

		/**
		 * Add a expire date and created date
		 * uses Unix timestamp
		 */
		$user_token['expire_date'] = time() + $user_token['expires_in'];
		$user_token['created_at']  = time();
		$user_token['refresh']     = true;

		/**
		 * Notify admin.
		 */
		$admin_user = get_option( 'admin_email' );
		$subject = 'New: '. $user_token['created_at'] . ' Access Token Update ' . wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		// email message.
		$message = __(
		'Hi,

		This notification confirms that your Instagram User Access Token Has Been Updated on ###SITENAME###.

		Token was updated: ###CREATED###, Token will expire: ###EXPIRES###.

		Refreshed tokens are valid for 60 days from the date at which they are refreshed.
		The Sim Social Feed plugin will automatically refresh your Access Token before it expires.

		This email has been sent to ###ADMIN_EMAIL###.

		Regards,
		[Sim Social Feed] plugin Notification.

		You have received this email notification to update you about your ###SITENAME### website.'
		);

		// message vars.
		$blog_name         = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$token_created     = date_i18n( get_option( 'date_format' ), $user_token['created_at'] );
		$token_will_expire = date_i18n( get_option( 'date_format' ), $user_token['expire_date'] );

		// message.
		$message = str_replace( '###SITENAME###', $blog_name, $message );
		$message = str_replace( '###CREATED###', $token_created, $message );
		$message = str_replace( '###EXPIRES###', $token_will_expire, $message );
		$message = str_replace( '###ADMIN_EMAIL###', get_option( 'admin_email' ), $message );

		// update token option.
		update_option('simsf_access_token', $user_token );

		// send email.
		wp_mail( $admin_user, $subject, $message );

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
