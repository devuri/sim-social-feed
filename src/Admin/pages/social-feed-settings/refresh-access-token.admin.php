<?php

	use SimSocialFeed\InstagramData;

	// @codingStandardsIgnoreFile TODO fix phpcs

// Save Data
if ( isset( $_POST['ig_token_update'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    # SOMETHING WENT WRONG WITH THE REQUEST
    if ( ! SimSocialFeed\InstagramData::is_request_ok() ) :
      echo $this->form()->user_feedback(SimSocialFeed\InstagramData::error_message(), 'error');
    endif;

    # REQUEST TOKEN UPDATE
    if ( SimSocialFeed\InstagramData::is_request_ok() ) :

      # update the token
       SimSocialFeed\InstagramData::refresh_token();

      echo $this->form()->user_feedback('Instagram Token Has Been Updated !!!');
    endif;

endif;
?><div id="frmwrap" >
    <h2><?php _e('Refresh and Update User Access Token'); ?></h2>
	<?php _e('Token was last updated: '); ?>
	<span style="color: #cc0000;">
	  <?php echo SimSocialFeed\InstagramData::token_created_date(); ?>
  </span> -
    <?php _e('Token will expire: '); ?>
    <span style="color: #cc0000;">
      <?php echo SimSocialFeed\InstagramData::token_expire_date(); ?>
    </span>
	<br>
	<span style="color: #1b8a20;">
      	<?php _e('Access Token will automatically refresh before it expires, if the refresh is not successful you will get a notification to do a manual refresh.'); ?>
    </span>
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
    </div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

  // generate nonce_field
  $this->form()->nonce();

  /**
   * only show if we have valid user
   */
  if ( SimSocialFeed\InstagramData::user_check() ) {
    // submit button
    echo $this->form()->submit_button('Get New Token', 'primary large', 'ig_token_update');
  } else {
    echo $this->form()->user_feedback('Please go to Account Setup and Activate User ID !!!', 'warning');
  }

 ?></form>
</div><!--frmwrap-->
<br/><hr/>
<a href="https://developers.facebook.com/docs/instagram-basic-display-api/reference/refresh_access_token" target="_blank"><?php _e('User Access Tokens'); ?></a>
