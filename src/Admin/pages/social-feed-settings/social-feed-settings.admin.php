<?php

	use SimSocialFeed\InstagramData;
	use SimSocialFeed\InstagramFeed;

	// @codingStandardsIgnoreFile TODO fix phpcs

// Save Data
if ( isset( $_POST['refresh_instagram_feed'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    # SOMETHING WENT WRONG WITH THE REQUEST
    if ( ! InstagramData::is_request_ok() ) :
      echo $this->form()->user_feedback( InstagramData::error_message(), 'error');
    endif;

    # UPDATE USER MEDIA
    if ( InstagramData::is_request_ok() ) :
      $ig_user_media = InstagramData::user_media();
      update_option('simsf_user_media', $ig_user_media->data );
      echo $this->form()->user_feedback('IG Feed Has Been Updated !!!');
    endif;



endif;
?><div id="frmwrap" >
    <h2><?php _e('Get New Instagram Posts'); ?></h2>
    <div class="description">
      <?php _e('Regfresh Instagram Posts'); ?>
      <br>
      <?php _e('Use <strong>[igfeed limit="6" links="on" caption="on"]</strong> to Display Instagram Posts'); ?>
    </div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

  // nonce_field
  $this->form()->nonce();

    /**
     * only show if we have valid user
     */
    if ( InstagramData::user_check() ) {
      # submit button
      echo $this->form()->submit_button('Refresh Instagram Feed', 'primary large', 'refresh_instagram_feed');
    } else {
      echo $this->form()->user_feedback('Please go to Account Setup and Activate User ID !!!', 'warning');
    }

    /**
     * get images
     */
    echo '<hr/>';
    	InstagramFeed::admin_view();
    echo '<hr/>';

 ?></form>
<br/>
</div><!--frmwrap-->
