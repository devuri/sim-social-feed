<?php
// Save Data
if ( isset( $_POST['refresh_instagram_feed'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    # SOMETHING WENT WRONG WITH THE REQUEST
    if ( ! SimIG\Instagram_Social\SimSocialFeed::is_request_ok() ) :
      echo $this->form()->user_feedback(SimIG\Instagram_Social\SimSocialFeed::error_message(), 'error');
    endif;

    # UPDATE USER MEDIA
    if ( SimIG\Instagram_Social\SimSocialFeed::is_request_ok() ) :
      $ig_user_media = SimIG\Instagram_Social\SimSocialFeed::user_media();
      update_option('simsf_user_media', $ig_user_media->data );
      echo $this->form()->user_feedback('IG Feed Has Been Updated !!!');
    endif;



endif;
?><div id="frmwrap" >
    <h2><?php _e('Get New Instagram Posts'); ?></h2>
    <hr/>
    <div class="description">
      <?php _e('Regfresh Instagram Posts'); ?>
    </div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

    /**
     * get images
     */
    SimIG\Instagram_Social\SimSocialFeed::images('240');
    echo '<hr/>';

  // nonce_field
  $this->form()->nonce();

    /**
     * only show if we have valid user
     */
    if ( is_array(get_option('simsf_user'))) {
      # submit button
      echo $this->form()->submit_button('Refresh Instagram Feed', 'primary large', 'refresh_instagram_feed');
    } else {
      echo $this->form()->user_feedback('Please go to Account Setup and Activate User ID !!!', 'warning');
    }

 ?></form>
<br/>
</div><!--frmwrap-->
