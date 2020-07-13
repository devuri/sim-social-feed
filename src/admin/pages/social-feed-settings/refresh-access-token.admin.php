<?php


// Save Data
if ( isset( $_POST['ig_token_update'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    /**
     * Refresh access token for another 60 days before it expires
     */
    $new_ig_token = SimIG\Instagram_Social\SimSocialFeed::refresh_token();

    /**
     * update the old token
     */
    update_option('wpsf_access_token', $new_ig_token );
    echo $this->form()->user_feedback('Token Has Been Updated !!!');

endif;
?><div id="frmwrap" >
    <h2><?php _e('Update New Token Settings'); ?></h2>
    <hr/>
    <div class="description">
      <?php _e('Get new Instagram Token'); ?>
      <?php _e('Refresh access token for another 60 days before it expires'); ?>
      <?php _e('Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.'); ?>
    </div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

  /**
   * Token
   */
  echo '<pre><input type="password" value="' . get_option('wpsf_token') . '" id="IGToken"></pre>';

  // generate nonce_field
  $this->form()->nonce();

 // submit button
 echo $this->form()->submit_button('Get New Token', 'primary large', 'ig_token_update');
 ?></form>
<br/>
</div><!--frmwrap-->
