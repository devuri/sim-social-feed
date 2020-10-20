<?php

namespace SimSocialFeed;

class InstagramSocialFeed
{

	/**
	 * Lets make sure all is well
	 *
	 * @return boolean
	 */
	public static function is_request_ok() {
		try {
			simsocial()->getUserProfile();
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
	 * convert user data object to array
	 *
	 * @return array
	 */
	public static function user_profile() {
		$user = simsocial()->getUserProfile();
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
		$user_media = simsocial()->getUserMedia( $id, 49 );

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
		$newtoken = simsocial()->refreshToken( get_option( 'simsf_token' )['access_token'] );
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
	 * Get the token epire date
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
	 * List images
	 *
	 * @param string $w   .
	 * @param string $css .
	 */
	public static function images( $w = '250', $css = '' ) {
		echo '<div class="row" style="display: inline-flex; flex-wrap: wrap; ' . $css . '">'; // @codingStandardsIgnoreLine
			if ( is_array( get_option( 'simsf_user_media' ) ) ) {
				foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {
					if ( isset( $media->caption ) ) {
						$caption = $media->caption;
					} else {
						$caption = '';
					}
					if ( 'VIDEO' === $media->media_type ) continue;
					echo '<div class="ig-image" style="margin:2px;"><a href="' . esc_url( $media->permalink ) . '" target="_blank"><img class="img-responsive" width="' . esc_attr( $w ) . '" src="' . esc_url( $media->media_url ) . '" alt="' . esc_attr( $caption ) . '"></a></div>';
				}
			}
		echo '</div>';
	}

	/**
	 * The feed igfeed()
	 *
	 * @param  integer $limit .
	 */
	public static function igfeed( $limit = 6 ) {
		?>
			<div class="ig-photo-container">
				<div class="ig-photo-feed">
					<?php
						if ( is_array( get_option( 'simsf_user_media' ) ) ) {

							/**
							 * Get IG list
							 * limit the return values
							 */
							$i = 0;
							foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {

								if ( isset( $media->caption ) ) {
									$caption = $media->caption;
								} else {
									$caption = '';
								}

								if ( 'VIDEO' === $media->media_type ) continue;
									echo '<img src="' . esc_url( $media->media_url ) . '" alt="' . esc_attr( $caption ) . '">';
								if ( ++$i === $limit ) break;

							}
						}
					?>
				</div>
			</div>
		<?php
	}
}
