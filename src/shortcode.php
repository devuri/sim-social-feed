<?php

	use SimIG\Instagram_Social\SimSocialFeed;

	/**
	 * shortcode to use [ig_socialfeed]
	 */
	add_shortcode('ig_socialfeed', 'sfeed_data');
	function sfeed_data() {
		ob_start();
		SimSocialFeed::igfeed();
		$output_sfd = ob_get_contents();
		ob_end_clean();
		return $output_sfd;
	}
