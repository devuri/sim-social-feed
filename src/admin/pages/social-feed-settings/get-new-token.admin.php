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
    $sfig_token = simsocial()->refreshToken(sifeed_info('token'), true);

    /**
     * update the old token
     */
    update_option('wpsf_token', $sfig_token );
    echo $this->form()->user_feedback('IG Token Has Been Updated !!!');

endif;
?><div id="frmwrap" >
    <h2><?php _e('Update New Token Settings'); ?></h2>
    <hr/>
    <div class="description">
      <?php _e('Get new Instagram Token'); ?>
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
