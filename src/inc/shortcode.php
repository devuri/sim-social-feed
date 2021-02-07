<?php

	use SimSocialFeed\InstagramFeed;

	/**
	 * Shortcode to use [igfeed limit="6" links="on" caption="on"]
	 *
	 * @param  array $atts .
	 *
	 * @return string $output_sfd
	 */
	function simsf_igmedia_feed( $atts ) {

		$args = shortcode_atts(
			array(
				'limit'   => 6,
				'links'   => 'off',
				'caption' => 'off',
			), $atts, 'igfeed'
		);

		/**
		 * Load the grid styles
		 */
		wp_enqueue_style( 'igfeed-grid' );

		ob_start();

			InstagramFeed::view( $args );

		$output_sfd = ob_get_contents();

		ob_end_clean();

		return $output_sfd;
	}
	add_shortcode( 'igfeed', 'simsf_igmedia_feed' );
