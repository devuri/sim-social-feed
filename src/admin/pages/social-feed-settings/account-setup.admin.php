<?php


/**
 * Update the Token
 */
if ( isset( $_POST['submit_update_token'] ) ) :

  # lets verify the nonce
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    # set the token value
    if ( ! isset( $_POST['instagram_token'] ) ) {
      echo $this->form()->user_feedback('<strong>No Updates Have Been Set</strong> !!!', 'warning');
    } elseif ( isset( $_POST['instagram_token'] ) ) {

      # Token
      $igtoken = array();
      $igtoken['access_token'] = sanitize_text_field($_POST['instagram_token']);
      $igtoken['reset'] = false;

      # update token
      update_option('wpsf_token', $igtoken );
      echo $this->form()->user_feedback('Token Has Been Updated !!!');
    }
endif;


/**
 * activate with user ID
 */
if ( isset( $_POST['submit_activate_id'] ) ) :

    # lets verify the nonce
    if ( ! $this->form()->verify_nonce()  ) {
      wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
    }

      # update user info
      $igsf_profile =  SimIG\Instagram_Social\SimSocialFeed::user_profile();
      update_option('wpsf_user', $igsf_profile);
      echo $this->form()->user_feedback('IG User Info Has Been Updated !!!');

endif;


/**
 * Reset the Token
 */
if ( isset( $_POST['reset_token'] ) ) :

  # lets verify the nonce
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    # Reset Token Values
    $igtoken = array();
    $igtoken['access_token'] = '';
    $igtoken['reset'] = true;

    # Reset the token and user info
    update_option('wpsf_token', $igtoken);
    update_option('wpsf_user', '');
    update_option('wpsf_user_media', '');
    echo $this->form()->user_feedback('Token has been Removed !!!');
endif;

?><div id="frmwrap" >
    <h2><?php _e('Update Settings'); ?></h2>
    <hr/>
    <div class="description">
      <?php _e('Instagram Token'); ?>
      <br>
    </div>
  <p/>
<form action="" method="POST"	enctype="multipart/form-data"><?php

    /**
     * build out form fields here
     */
    if ( false === get_option('wpsf_token')['reset'] ) {
      echo 'Instagram Token Has Been Set<br>';
    } else {
      echo '<span style="color:#ba315c">';
      _e('Impotant: Requires Long-live Token (60 Days)');
      echo '</span><br>';
      echo $this->form()->input('Instagram Token', 'paste your token here');
    }
    echo '<p/>';


  // generate nonce_field
  $this->form()->nonce();



  /**
   * update token if its not set
   */
  if ( true === get_option('wpsf_token')['reset'] || null === get_option('wpsf_token')['reset'] )  {
    echo $this->form()->submit_button('Save Token', 'primary large', 'submit_update_token');
  }


  /**
   * activate user or reset the token
   */
  if ( ! is_array(get_option('wpsf_user')) && false === get_option('wpsf_token')['reset'] ) {
    echo $this->form()->submit_button('Activate User ID', 'primary large', 'submit_activate_id');
    echo ' | ';
    echo $this->form()->submit_button('Delete Active Token', 'primary large', 'reset_token');
  } elseif ( is_array(get_option('wpsf_user')) ) {
    echo $this->form()->submit_button('Delete Active Token', 'primary large', 'reset_token');
  }
  echo '<p/>';


 ?></form>
 <?php if (is_array(get_option('wpsf_user'))): ?>
   The Following Account is Active:
   <br>
   <strong><?php echo get_option('wpsf_user')['id']; ?></strong>
   <br>
   <strong><?php echo get_option('wpsf_user')['username']; ?></strong>
 <?php endif; ?>
<hr/><?php
echo '<br> <a href="'. esc_url('https://www.youtube.com/watch?v=rWUcb8jXgVA') .'" target="_blank">How To Get Access Token</a>';
echo '<br> <a href="'. esc_url('https://developers.facebook.com/docs/instagram-basic-display-api/getting-started') .'" target="_blank">Get Started</a>';
echo '<br> <a href="'. esc_url('https://developers.facebook.com/docs/instagram-basic-display-api') .'" target="_blank">Instagram Basic Display API</a>';

?></div><!--frmwrap-->
