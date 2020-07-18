<?php


// Save Data
if ( isset( $_POST['ig_token_update'] ) ) :

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

    # REQUEST TOKEN UPDATE
    if ( SimIG\Instagram_Social\SimSocialFeed::is_request_ok() ) :
      # get new token
      $newtoken = SimIG\Instagram_Social\SimSocialFeed::refresh_token();

      # update the token
      update_option('simsf_access_token', $newtoken );

      # new token array
      $igtoken = array();
      $igtoken['access_token'] = get_option('simsf_access_token')['access_token'];
      $igtoken['reset'] = false;

      # set new token value
      update_option('simsf_token', $igtoken );
      echo $this->form()->user_feedback('Instagram Token Has Been Updated !!!');
    endif;

endif;
?><div id="frmwrap" >
    <h2><?php _e('Refresh and Update User Access Token'); ?></h2>
    <hr/>
    <div class="description">
      <?php _e('Get new Instagram Token'); ?>
      <br>
      <strong>
        <?php _e('Refresh access token for 60 days before it expires'); ?>
      </strong>
      <br>
      <?php _e('Refresh a long-lived Instagram User Access Token.'); ?>
      <br>
      <?php _e('Token must be at least 24 hours old but has not expired.'); ?>
      <br>
      <?php _e('Refreshed tokens are valid for 60 days from the date at which they are refreshed.'); ?>
      <br>
      <a href="https://developers.facebook.com/docs/instagram-basic-display-api/reference/refresh_access_token" target="_blank"><?php _e('User Access Tokens'); ?></a>
    </div>
  <p/>
  <hr/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

  // generate nonce_field
  $this->form()->nonce();

  /**
   * only show if we have valid user
   */
  if ( SimIG\Instagram_Social\SimSocialFeed::user_check() ) {
    // submit button
    echo $this->form()->submit_button('Get New Token', 'primary large', 'ig_token_update');
  } else {
    echo $this->form()->user_feedback('Please go to Account Setup and Activate User ID !!!', 'warning');
  }

 ?></form>
<br/>
</div><!--frmwrap-->
