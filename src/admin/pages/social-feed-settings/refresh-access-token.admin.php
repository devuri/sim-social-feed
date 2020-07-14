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
     * get new token
     * @var [type]
     */
    $sfig_token = simsocial()->refreshToken(get_option('wpsf_token'));

    /**
     * update the old token
     */
    update_option('wpsf_token', $sfig_token );
    echo $this->form()->user_feedback('Instagram Token Has Been Updated !!!');

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
<form action="" method="POST"	enctype="multipart/form-data"><?php

  // generate nonce_field
  $this->form()->nonce();

 // submit button
 echo $this->form()->submit_button('Get New Token', 'primary large', 'ig_token_update');
 ?></form>
<br/>
</div><!--frmwrap-->
