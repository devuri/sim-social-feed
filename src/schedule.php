<?php

	/**
	 * run the sim social feed update
	 */
	add_action( 'sim_social_feed_cron', 'sim_social_igfeed_update' );
	function sim_social_igfeed_update(){
		/**
		 * update user media
		 */
		if ( SimIG\Instagram_Social\SimSocialFeed::is_request_ok() ) :
			$ig_user_media = SimIG\Instagram_Social\SimSocialFeed::user_media();
			update_option('simsf_user_media', $ig_user_media->data );
		endif;
	}
