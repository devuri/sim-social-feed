<?php

	use SimIG\Instagram_Social\SimSocialFeed;

	/**
	 * run the sim social feed update
	 */
	add_action( 'sim_social_feed_twicedaily', 'sim_social_igfeed_update' );
	function sim_social_igfeed_update(){
		/**
		 * update user media
		 */
		$ig_user_media = SimSocialFeed::user_media();
		update_option('wpsf_data', $ig_user_media->data );
	}
