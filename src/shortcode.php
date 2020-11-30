<?php

	use SimSocialFeed\InstagramSocialFeed;

	/**
	 * Shortcode to use [ig_socialfeed limit="6" linked="yes"]
	 *
	 * @param  array $atts .
	 *
	 * @return string $output_sfd
	 */
	function simsf_igmedia_feed( $atts ) {

		$a = shortcode_atts(
			array(
				'limit'  => 6,
				'linked' => 'no',
			),
			$atts
		);

		// params .
		$limit = absint( $a['limit'] );
		$linked = strtolower( $a['linked'] );

		/**
		 * Load the grid styles
		 */
		wp_enqueue_style( 'sim-social-feed-grid' );

		ob_start();

		if ( 'yes' === $linked ) {
			InstagramSocialFeed::igfeedlinked( $limit );
		} else {
			InstagramSocialFeed::igfeed( $limit );
		}

		$output_sfd = ob_get_contents();

		ob_end_clean();

		return $output_sfd;
	}
	add_shortcode( 'ig_socialfeed', 'simsf_igmedia_feed' );
