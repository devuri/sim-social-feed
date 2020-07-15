<?php

namespace SimIG\Instagram_Social;

	/**
	 *
	 */
	class SimSocialFeed
	{

		/**
		 * lets make sure all is well
		 * @return boolean
		 */
		public static function is_request_ok(){
			try {
			    simsocial()->getUserProfile();
			} catch (\Exception $e) {
			  return false;
			}
			return true;
		}
		
		/**
		 * error_message()
		 *
		 * give the user some feedback for request error
		 * @return string
		 */
		public static function error_message(){
			return 'Error: The Request Failed. <br> Configuration data is missing or incorrect <br> Please check the Account Settings !!!';
		}

		/**
		 * user_profile()
		 *
		 * convert user data object to array
		 * @return array
		 */
		public static function user_profile(){
			$user = simsocial()->getUserProfile();
			$user_data = (array) $user;
			return $user_data;
		}

		/**
		 * user_media()
		 * @return object
		 */
		public static function user_media(){
			/**
			 * Get the users profile
			 */
			$id = get_option('wpsf_user')['id'];

			/**
			 * $user_media
			 *
			 * get user data
			 * @var [type]
			 */
			$user_media = simsocial()->getUserMedia($id,6);

			/**
			 * get media
			 */
			return $user_media;
		}

		/**
		 * refresh_token()
		 *
		 * convert token object to array
		 * @return array
		 */
		public static function refresh_token(){
			$newtoken = simsocial()->refreshToken(get_option('wpsf_token')['access_token']);
			$user_token = (array) $newtoken;
			return $user_token;
		}

		/**
		 * list images
		 * @return
		 */
		public static function images($w = '250',$css=''){
			echo '<div class="row" style="display: inline-flex; flex-wrap: wrap; '.$css.'">';
			if(is_array(get_option('wpsf_user_media'))){
				foreach (get_option('wpsf_user_media') as $mkey => $media) {
					echo '<div class="ig-image" style="margin:2px;"><a href="'.$media->permalink.'" target="_blank"><img class="img-responsive" width="'.$w.'" src="'.$media->media_url.'" alt="'.$media->caption.'"></a></div>';
				}
			}
		  echo '</div>';
		}

		/**
		 * igfeed()
		 *
		 * @return
		 */
		public static function igfeed(){
			?><div class="ig-photo-container">
				<div class="ig-photo-feed"><?php
					if(is_array(get_option('wpsf_user_media'))){
						foreach (get_option('wpsf_user_media') as $mkey => $media) {
							echo '<img src="'.$media->media_url.'" alt="'.$media->caption.'">';
						}
					} ?></div>
			</div><?php
		}
	}
