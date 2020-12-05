<?php

	use SimSocialFeed\InstagramData;

	/**
	 * Run the sim social feed update
	 */
	function sim_social_igfeed_update() {
		/**
		 * Update user media
		 */
		if ( InstagramData::is_request_ok() ) :
			$ig_user_media = InstagramData::user_media();
			update_option( 'simsf_user_media', $ig_user_media->data );
		endif;
	}
	add_action( 'sim_social_feed_cron', 'sim_social_igfeed_update' );
