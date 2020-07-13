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
			// check if we get back error
			if ( isset( simsocial()->getUserProfile()->error->code )  ) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * list images
		 * @return
		 */
		public static function images($w = '250',$css=''){
			echo '<div class="row" style="display: inline-flex; flex-wrap: wrap; '.$css.'">';
			if(is_array(get_option('wpsf_data'))){
				foreach (get_option('wpsf_data') as $mkey => $media) {
					echo '<div class="ig-image" style="margin: 12px;"><a href="'.$media->permalink.'" target="_blank"><img class="img-responsive" width="'.$w.'" src="'.$media->media_url.'" alt="'.$media->caption.'"></a></div>';
				}
			}
		  echo '</div>';
		}

		/**
		 * igfeed()
		 *
		 * @return
		 */
		public static function igfeed(){ ?>
			<div class="container-fluid">
			<div class="row">
				<?php
				if(is_array(get_option('wpsf_data'))){
					foreach (get_option('wpsf_data') as $mkey => $media) {
						echo '<div class="ig-image col-md-2"><a href="'.$media->permalink.'" target="_blank"><img class="img-responsive" src="'.$media->media_url.'" alt="'.$media->caption.'"></a></div>';
					}
				}
				 ?>
			</div>
			</div><?php }
	}
