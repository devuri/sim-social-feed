<?php

namespace SimSocialFeed;

use SimSocialFeed\View\Display;

class InstagramFeed
{
	/**
	 * Get the Display
	 */
	public static function get() {
		return new Display();
	}

	/**
	 * Get the Feed items
	 *
	 * @param array $args .
	 */
	public static function view( $args ) {
		return self::get()->igfeed( $args );
	}

	/**
	 * Get the Admin list of Feed items
	 */
	public static function admin_view() {
		return self::get()->admin_view();
	}
}
