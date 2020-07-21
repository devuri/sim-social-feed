<?php

	use SimIG\Instagram_Social\SimSocialFeed;

	/**
	 * shortcode to use [ig_socialfeed]
	 */
	add_shortcode('ig_socialfeed', 'simsf_igmedia_feed');
	function simsf_igmedia_feed() {

		/**
		 * load the grid styles
		 */
		wp_enqueue_style('sim-social-feed-grid');

		ob_start();
		SimSocialFeed::igfeed();
		$output_sfd = ob_get_contents();
		ob_end_clean();
		return $output_sfd;
	}
