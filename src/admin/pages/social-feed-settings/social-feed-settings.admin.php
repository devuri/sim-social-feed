<?php
/**
 * get data
 */
$wpsf_token = get_option('wpsf_token', 0);
$wpsf_user = get_option('wpsf_user');

// Save Data
if ( isset( $_POST['submit_settings_update'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    /**
     * set the token value
     * @var [type]
     */
    if ( ! isset( $_POST['instagram_token'] ) ) {
      echo $this->form()->user_feedback('<strong>No Updates Have Been Set</strong> !!!', 'warning');
    } elseif ( isset( $_POST['instagram_token'] ) ) {
      // update and provide feedback
      $sfig_token = $_POST['instagram_token'];
      update_option('wpsf_token', $sfig_token );
      echo $this->form()->user_feedback('IG Token Has Been Updated !!!');
    }
endif;

/**
 * activate with user ID
 * @var [type]
 */
if ( isset( $_POST['submit_activate_id'] ) ) :
  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    // update user info
    $igsf_profile =  SimIG\Instagram_Social\SimSocialFeed::user_profile();
    update_option('wpsf_user', $igsf_profile);
endif;


?><div id="frmwrap" >
    <h2><?php _e('Update Settings'); ?></h2>
    <hr/>
    <div class="description"> <?php
      _e('Enter Instagram Token');
      ?></div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

    /**
     * build out form fields here
     */
    if (get_option('wpsf_token')) {
      echo 'Instagram Token <input type="password" value="' . get_option('wpsf_token') . '" name="instagram_token" id="instagram_token"> <br>';
    } else {
      echo $this->form()->input('Instagram Token', 'paste your token here');
    }
    echo '<p/>';


  // generate nonce_field
  $this->form()->nonce();

 // submit button
 echo $this->form()->submit_button('Save Token', 'primary large', 'submit_settings_update');
 echo ' | ';
 echo $this->form()->submit_button('Activate User ID', 'primary large', 'submit_activate_id');
 ?></form>
 <?php if (is_array(get_option('wpsf_user'))): ?>
   The Following Account is Connected:
   <br>
   <strong><?php echo $wpsf_user['id'] ?></strong>
   <br>
   <strong><?php echo $wpsf_user['username'] ?></strong>
 <?php endif; ?>
<hr/><?php
echo '<br> <a href="'. esc_url('https://www.youtube.com/watch?v=rWUcb8jXgVA') .'" target="_blank">How To Get Access Token</a>';
echo '<br> <a href="'. esc_url('https://developers.facebook.com/docs/instagram-basic-display-api/getting-started') .'" target="_blank">Get Started</a>';
echo '<br> <a href="'. esc_url('https://developers.facebook.com/docs/instagram-basic-display-api') .'" target="_blank">Instagram Basic Display API</a>';

?></div><!--frmwrap-->
