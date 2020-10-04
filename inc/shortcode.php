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
// Add Shortcode

add_action('init', 'create_post_type_html5');
function doctores_displays($atts){
    	// Attributes
	$atts = shortcode_atts(
		array(
            'slider' => 'slider',
            'col'=>3
		),
		$atts,
		'doctores_shortcode'
    );
    if($atts['slider']=='grid'){
        ob_start();
?>
<div class="container_doctores">
    <div class="row">
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
        <div class="col-md-<?php echo $atts['col'] ;?> doctor-<?php echo  get_the_ID();?> ">
            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title();?>" class="doctor-img">
            <div class="info-content">
                <h4 class="info-name"><i class="fa fa-user-md"></i> <?php the_title();?></h4>
                <h5 class="info-cargo">
                    <?php echo get_post_meta( $post_id, 'doctor_profesion', true ); ?>
                </h5>
                <h5 class="info-speciality">
                <?php echo get_post_meta( $post_id, 'doctor_especialidad', true ); ?>
                </h5>
            </div>
            
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        ?>
            
    </div>
</div>
<?php
return ob_get_clean();
    }else{

    }
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