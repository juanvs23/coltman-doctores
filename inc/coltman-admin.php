<?php
function coltman_doctor_metabox() {
    add_meta_box( 'coltman_doctor_metabox', 'Información del  especialista', 'coltman_doctores_info', 'doctores', 'normal', 'high' );
  }
  add_action( 'add_meta_boxes', 'coltman_doctor_metabox' );


  function coltman_doctores_info($post) {
    //si existen se recuperan los valores de los metadatos
    $doctor_profesion = get_post_meta( $post->ID, 'doctor_profesion', true );
    $doctor_especialidad = get_post_meta( $post->ID, 'doctor_especialidad', true );
    $doctor_calendario = get_post_meta( $post->ID, 'doctor_calendario', true );
  
    // Se añade un campo nonce para probarlo más adelante cuando validemos
    wp_nonce_field( 'coltman_doctor_metabox', 'coltman_doctor_metabox_nonce' );?>
  
    <table width="100%" cellpadding="1" cellspacing="1" border="0">
      <tr>
        <td width="20%"><strong>Profesión</strong><br /><small>Area médica que labora</small></td>
        <td width="80%"><input type="text" name="doctor_profesion" value="<?php echo sanitize_text_field($doctor_profesion);?>" class="large-text" placeholder="Profesion" /></td>
      </tr>
      <tr>
        <td width="20%"><strong>Especialidad</strong><br /><small>area medica en que se especializa</small></td>
        <td width="80%"><input type="text" name="doctor_especialidad" value="<?php echo sanitize_text_field($doctor_especialidad);?>" class="large-text" placeholder="Especialidad" /></td>
      </tr>
      
      <tr>
        <td width="20%"><strong>Calendario</strong><br /><small>Agregar short_code del calendario</small></td>
        <td width="80%"><input type="text" name="doctor_calendario" value="<?php echo sanitize_text_field($doctor_calendario);?>" class="large-text" placeholder="shortcode aqui" /></td>
      </tr>
    </table>
  <?php }
  function coltman_doctor_save($post_id){
         // Comprobamos si se ha definido el nonce.
  if ( ! isset( $_POST['coltman_doctor_metabox_nonce'] ) ) {
    return $post_id;
  }
  $nonce = $_POST['coltman_doctor_metabox_nonce'];

  // Verificamos que el nonce es válido.
  if ( !wp_verify_nonce( $nonce, 'coltman_doctor_metabox' ) ) {
    return $post_id;
  }

  // Si es un autoguardado nuestro formulario no se enviará, ya que aún no queremos hacer nada.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
    return $post_id;
  }

  // Comprobamos los permisos de usuario.
  if ( $_POST['post_type'] == 'page' ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // Vale, ya es seguro que guardemos los datos.

  // Si existen entradas antiguas las recuperamos
  $old_doctor_profesion = get_post_meta( $post_id, 'doctor_profesion', true );
  $old_doctor_especialidad = get_post_meta( $post_id, 'doctor_especialidad', true );
  $old_doctor_calendario = get_post_meta( $post_id, 'doctor_calendario', true );


  // Saneamos lo introducido por el usuario.
  $doctor_profesion = sanitize_text_field( $_POST['doctor_profesion'] );
  $doctor_especialidad = sanitize_text_field( $_POST['doctor_especialidad'] );
  $doctor_calendario=$_POST['doctor_calendario'];

  // Actualizamos el campo meta en la base de datos.
  update_post_meta( $post_id, 'doctor_profesion', $doctor_profesion, $old_doctor_profesion );
  update_post_meta( $post_id, 'doctor_especialidad', $doctor_especialidad, $old_doctor_especialidad );
  update_post_meta( $post_id, 'doctor_calendario', $doctor_calendario, $old_doctor_calendario );
  
  }
  add_action('save_post', 'coltman_doctor_save');