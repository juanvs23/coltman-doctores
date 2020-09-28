<?php 
/*
*
*	***** Nuestro equipo *****
*
*	Shortcodes
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
/*
*
*  Build The Custom Plugin Form
*
*  Display Anywhere Using Shortcode: [doctores_shortcode]
*
*/
add_action('init', 'create_post_type_html5');
function doctores_displays(){
    ob_start();
    ?>
    <div class="splide">
    <div class="contenedor-doctores splide__track">
    <ul class="splide__list">
    <?php
   					$args = array(  
				       'post_type' => 'doctores',
				       'post_status' => 'publish',
				       'posts_per_page' => -1,
				       'orderby' => 'ID',
				       'order' => 'ASC',
				   );
				
				   $loop = new WP_Query( $args );
				   $i = 0;  	
				   while ( $loop->have_posts() ) : $loop->the_post(); 
                        $i++; 
                        $post_id = get_the_ID();
                           ?>
                           
    <li class="doctor-perfil splide__slide"  >
        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="" >
        <div class="data-container">
            <h4 class="perfil-name">
                <?php the_title();?>
            </h4>
            <p class="perfil-profesion">
                <?php echo get_post_meta( $post_id, 'doctor_profesion', true ); ?>
            </p>
            <p class="perfil-especialidad">
                <?php echo get_post_meta( $post_id, 'doctor_especialidad', true ); ?>
            </p>
        </div>
    </li>
                
    <?php
    endwhile;
    wp_reset_postdata();?>
    </ul>
                </div>
    </div>
    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '.splide',{
                    type   : 'loop',
                    perPage: 4,
                    perMove:1,
                    autoplay:true,
                    breakpoints: {
		                            640: {
			                    perPage:1,
                                },
                                767: {
			                    perPage:2,
                                },
                                991: {
			                    perPage:3,
		                        },
	}
                } ).mount();
} );
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('doctores_shortcode','doctores_displays');