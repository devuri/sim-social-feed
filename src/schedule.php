<?php

	use SimSocialFeed\InstagramSocialFeed;

	/**
	 * Run the sim social feed update
	 */
	add_action( 'sim_social_feed_cron', 'sim_social_igfeed_update' );
	function sim_social_igfeed_update() {
		/**
		 * Update user media
		 */
		if ( InstagramSocialFeed::is_request_ok() ) :
			$ig_user_media = InstagramSocialFeed::user_media();
			update_option( 'simsf_user_media', $ig_user_media->data );
		endif;
	}
