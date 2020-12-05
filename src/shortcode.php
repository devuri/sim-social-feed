<?php

	use SimSocialFeed\InstagramFeed;

	/**
	 * Shortcode to use [igfeed limit="6" linked="yes"]
	 *
	 * @param  array $atts .
	 *
	 * @return string $output_sfd
	 */
	function simsf_igmedia_feed( $atts ) {

		$a = shortcode_atts(
			array(
				'limit'   => 6,
				'linked'  => 'no',
				'caption' => 'off',
			),
			$atts
		);

		/**
		 * Load the grid styles
		 */
		wp_enqueue_style( 'igfeed-grid' );

		ob_start();

			InstagramFeed::view( $a );

		$output_sfd = ob_get_contents();

		ob_end_clean();

		return $output_sfd;
	}
	add_shortcode( 'igfeed', 'simsf_igmedia_feed' );
