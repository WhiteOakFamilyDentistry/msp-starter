<?php


////////////////////////////////////////////////////////////////////
//Add Custom Author Image Functionality
////////////////////////////////////////////////////////////////////


function shr_add_admin_scripts(){

  wp_enqueue_media();
  wp_enqueue_script('shr-uploader', get_template_directory_uri().'/js/src/uploader.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'shr_add_admin_scripts');



function shr_extra_profile_fields( $user ) {

  $profile_pic = ($user!=='add-new-user') ? get_user_meta($user->ID, 'shr_pic', true): false;

  if( !empty($profile_pic) ){
    $image = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

  } ?>

  <table class="form-table fh-profile-upload-options">
    <tr>
      <th>
        <label for="image"><?php _e('Main Profile Image', 'whiteoak') ?></label>
      </th>

      <td>
        <input type="button" data-id="shr_image_id" data-src="shr-img" class="button shr-image" name="shr_image" id="shr-image" value="Upload" />
        <input type="hidden" class="button" name="shr_image_id" id="shr_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
        <img id="shr-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> max-width: 100px; max-height: 100px;" />
      </td>
    </tr>
  </table><?php

}
add_action( 'show_user_profile', 'shr_extra_profile_fields' );
add_action( 'edit_user_profile', 'shr_extra_profile_fields' );
add_action( 'user_new_form', 'shr_extra_profile_fields' );




function shr_profile_update($user_id){

  if( current_user_can('edit_users') ){
    $profile_pic = empty($_POST['shr_image_id']) ? '' : $_POST['shr_image_id'];
    update_user_meta($user_id, 'shr_pic', $profile_pic);
  }

}
add_action('profile_update', 'shr_profile_update');
add_action('user_register', 'shr_profile_update');


function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ){
  
  $get_user_by  = '';
  
  if( is_numeric($id_or_email) ){
    
    $user_by_field  = (int)$id_or_email;
    $get_user_by  = 'id';

  }elseif(is_object($id_or_email)){
    
    if ( ! empty( $id_or_email->user_id ) ) {
      
      $user_by_field  = (int)$id_or_email;
      $get_user_by  = 'id';
    }
    
  }else{
    
    $user_by_field  = $id_or_email;
    $get_user_by  = 'email';
  }

  $user = get_user_by($get_user_by, $user_by_field);

  if($user){
    
    $custom_avatar  = get_user_meta( $user->data->ID, 'shr_pic', true );

    if( !empty($custom_avatar) ){
      
      $image  = wp_get_attachment_image_src($custom_avatar, 'full');
      if( $image ){
        $safe_alt = esc_attr($alt);
        $avatar = "<img alt='{$safe_alt}' src='{$image[0]}' class='avatar photo' height='{$image[2]}' width='{$image[1]}' />";
      }
    }
  }

  return $avatar;
  
}
add_filter('get_avatar', 'my_custom_avatar', 10, 5 );

?>