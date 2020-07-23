<?php

	use SimIG\Instagram_Social\SimSocialFeed;

	/**
	 * shortcode to use [ig_socialfeed limit="6"]
	 */
	add_shortcode('ig_socialfeed', 'simsf_igmedia_feed');
	function simsf_igmedia_feed($atts) {

		$a = shortcode_atts(array(
				'limit' => 6,
		), $atts);

		// params
		$limit = $a['limit'];

		/**
		 * load the grid styles
		 */
		wp_enqueue_style('sim-social-feed-grid');

		ob_start();
		SimSocialFeed::igfeed($limit);
		$output_sfd = ob_get_contents();
		ob_end_clean();
		return $output_sfd;
	}
