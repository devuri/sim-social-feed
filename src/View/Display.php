<?php

namespace SimSocialFeed\View;

class Display
{

	/**
	 * List images
	 *
	 * @param string $limit   .
	 * @param string $w   .
	 * @param string $css .
	 */
	public function admin_view( $limit = 12, $w = '240', $css = '' ) {
		echo '<div class="row" style="display: inline-flex; flex-wrap: wrap; ' . $css . '">'; // @codingStandardsIgnoreLine
			if ( is_array( get_option( 'simsf_user_media' ) ) ) {
				/**
				 * Get IG list
				 * limit the return values
				 */
				$i = 0;
				foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {
					if ( isset( $media->caption ) ) {
						$caption = $media->caption;
					} else {
						$caption = '';
					}
					if ( 'VIDEO' === $media->media_type ) continue;
					echo '<div class="ig-image" style="margin:2px;"><a href="' . esc_url( $media->permalink ) . '" target="_blank"><img class="img-responsive" height="230" width="' . esc_attr( $w ) . '" src="' . esc_url( $media->media_url ) . '" alt="' . esc_attr( $caption ) . '"></a></div>';
				if ( ++$i === $limit ) break;
				}
			}
		echo '</div>';
	}

	/**
	 * The feed igfeed()
	 *
	 * Shortcode to display the instagram feed [igfeed limit="6" links="on" caption="on"].
	 *
	 * @param  array $args .
	 */
	public function igfeed( $args = array() ) {

		$defaults = array(
		  	'limit'   => 6,
		  	'links'   => 'off',
		  	'caption' => 'off',
		);
		$args = wp_parse_args( $args, $defaults );

		// make sure these are lowercase strings.
		$args = array_map( 'strtolower', $args );

		// make sure limit is integer.
		$args['limit'] = absint( $args['limit'] );

		// caption and linked.
		if ( 'on' === $args['links'] && 'on' === $args['caption'] ) {
			return $this->view_linked_caption( $args['limit'] );
		}

		// without caption no link.
		if ( 'on' === $args['caption'] ) {
			return $this->view_with_caption( $args['limit'] );
		}

		// linked without caption.
		if ( 'on' === $args['links'] ) {
			return $this->view_linked( $args['limit'] );
		}

		return $this->view( $args['limit'] );

	}

	/**
	 * Display View
	 *
	 * Get the Images
	 *
	 * @param  integer $limit .
	 *
	 * @return void
	 */
	public function view_linked_caption( $limit = 6 ) {
	?>
		<div class="igfeed-container">
			<div class="igfeed">
				<?php
					if ( is_array( get_option( 'simsf_user_media' ) ) ) {

						/**
						 * Get IG list
						 * limit the return values
						 */
						$i = 0;
						foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {

							if ( isset( $media->caption ) ) {
								$caption = $media->caption;
							} else {
								$caption = '';
							}

							if ( 'VIDEO' === $media->media_type ) continue;
							?>
							<div class="igfeed-item" tabindex="0">
								<img style="min-height:200px;" src="<?php echo  esc_url( $media->media_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
									<a href="<?php echo esc_url( $media->permalink ); ?>" target="_blank">
										<div class="igfeed-item-info">
											<p>
												<?php echo esc_attr( $caption ); ?>
											</p>
										</div>
									</a>
							</div>
							<?php
							if ( ++$i === $limit ) break;
						}
					}
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Display View
	 *
	 * Get the Images
	 *
	 * @param  integer $limit .
	 *
	 * @return void
	 */
	public function view_with_caption( $limit = 6 ) {
	?>
		<div class="igfeed-container">
			<div class="igfeed">
				<?php
					if ( is_array( get_option( 'simsf_user_media' ) ) ) {

						/**
						 * Get IG list
						 * limit the return values
						 */
						$i = 0;
						foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {

							if ( isset( $media->caption ) ) {
								$caption = $media->caption;
							} else {
								$caption = '';
							}

							if ( 'VIDEO' === $media->media_type ) continue;
							?>
							<div class="igfeed-item" tabindex="0">
								<img style="min-height:200px;" src="<?php echo  esc_url( $media->media_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
										<div class="igfeed-item-info">
											<p>
												<?php echo esc_attr( $caption ); ?>
											</p>
										</div>
							</div>
							<?php
							if ( ++$i === $limit ) break;
						}
					}
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Display View
	 *
	 * Get the Images
	 *
	 * @param  integer $limit .
	 *
	 * @return void
	 */
	public function view_linked( $limit = 6 ) {
	?>
		<div class="igfeed-container">
			<div class="igfeed">
				<?php
					if ( is_array( get_option( 'simsf_user_media' ) ) ) {

						/**
						 * Get IG list
						 * limit the return values
						 */
						$i = 0;
						foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {

							if ( isset( $media->caption ) ) {
								$caption = $media->caption;
							} else {
								$caption = '';
							}

							if ( 'VIDEO' === $media->media_type ) continue;
							?>
							<div class="igfeed-item" tabindex="0">
								<a href="<?php echo esc_url( $media->permalink ); ?>" target="_blank">
									<img style="min-height:200px;" src="<?php echo  esc_url( $media->media_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
								</a>
							</div>
							<?php
							if ( ++$i === $limit ) break;
						}
					}
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Display View
	 *
	 * Get the Images
	 *
	 * @param  integer $limit .
	 *
	 * @return void
	 */
	public function view( $limit = 6 ) {
	?>
		<div class="igfeed-container">
			<div class="igfeed">
				<?php
					if ( is_array( get_option( 'simsf_user_media' ) ) ) {

						/**
						 * Get IG list
						 * limit the return values
						 */
						$i = 0;
						foreach ( get_option( 'simsf_user_media' ) as $mkey => $media ) {

							if ( isset( $media->caption ) ) {
								$caption = $media->caption;
							} else {
								$caption = '';
							}

							if ( 'VIDEO' === $media->media_type ) continue;
							?>
							<div class="igfeed-item" tabindex="0">
								<img style="min-height:200px;" src="<?php echo  esc_url( $media->media_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
							</div>
							<?php
							if ( ++$i === $limit ) break;
						}
					}
				?>
			</div>
		</div>
	<?php
	}

}
