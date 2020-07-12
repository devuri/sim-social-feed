<?php


// Save Data
if ( isset( $_POST['ig_post_update'] ) ) :

  /**
   * lets verify the nonce
   */
  if ( ! $this->form()->verify_nonce()  ) {
    wp_die($this->form()->user_feedback('Verification Failed !!!' , 'error'));
  }

    /**
     * update the old token
     */
    update_option('wpsf_data', get_igsmedia()->data );
    echo $this->form()->user_feedback('IG Feed Has Been Updated !!!');

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

  // generate nonce_field
  $this->form()->nonce();

 // submit button
 echo $this->form()->submit_button('Refresh Instagram Post List', 'primary large', 'ig_post_update');
 ?></form>
<br/>
</div><!--frmwrap-->
