<?php
/**
 * Plugin Name:       Doctores CENED
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Listado de personal medico
 * Version:           1.2.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Juan Carlos Avila
 * Author URI:        http://coltman-desing.tk/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       doctor-cened
 * Domain Path:       /languages
 * */
//Define
define('COLTMAN_VERSION','1.2.0');
define('COLTMAN_PLUGIN','Doctores');
define('COLTMAN_DIRECTION',plugin_dir_path( __FILE__ ));
define('COLTMAN_INC',dirname( __FILE__ ).'/inc/');
define('COLTMAN_CSS',plugins_url( 'css/', __FILE__ ));
define('COLTMAN_JS',plugins_url( 'js/', __FILE__ ));
define('COLTMAN_LIB',plugins_url( 'lib/', __FILE__ ));


//assets
function coltman_register_css_js(){
    wp_enqueue_style( 'coltman-splide-core',COLTMAN_LIB . '/splide/css/splide-core.min.css' , array(), COLTMAN_VERSION );
    wp_enqueue_style( 'coltman-splide-theme',COLTMAN_LIB . '/splide/css/themes/splide-sea-green.min.css' , array('coltman-splide-core'), COLTMAN_VERSION );
    wp_enqueue_style( 'fontAwesome',COLTMAN_LIB . '/fontawesome/css/font-awesome.min.css' , array('coltman-splide-core'), COLTMAN_VERSION );
    wp_enqueue_style('coltman-style',COLTMAN_CSS . 'style.css', array('coltman-splide-core','coltman-splide-theme') ,COLTMAN_VERSION);
    
    wp_enqueue_script( 'splide', COLTMAN_LIB . '/splide/js/splide.min.js', array('jquery'), COLTMAN_VERSION, true );
    wp_enqueue_script( 'coltman-js', COLTMAN_JS .'custom.js', array('splide','jquery'), COLTMAN_VERSION, true );
};
add_action( 'wp_enqueue_scripts', 'coltman_register_css_js' );

add_action('init', 'create_post_type_html5');

//load custom post-type
if ( file_exists( COLTMAN_INC. 'coltman-admin.php' ) ) {
	require_once COLTMAN_INC . 'coltman-admin.php';
}

//// Load the Shortcodes
if ( file_exists( COLTMAN_INC. 'shortcode.php' ) ) {
	require_once COLTMAN_INC . 'shortcode.php';
}


if ( ! function_exists('cened_doctores_list') ) {

    // Register Custom Post Type
    function cened_doctores_list() {

        $labels = array(
            'name'                  => _x( 'Doctores', 'Post Type General Name', 'doctor-cened' ),
            'singular_name'         => _x( 'Doctor', 'Post Type Singular Name', 'doctor-cened' ),
            'menu_name'             => __( 'Doctores', 'doctor-cened' ),
            'name_admin_bar'        => __( 'Doctores', 'doctor-cened' ),
            'archives'              => __( 'Item Archives', 'doctor-cened' ),
            'attributes'            => __( 'Item Attributes', 'doctor-cened' ),
            'parent_item_colon'     => __( 'Parent Item:', 'doctor-cened' ),
            'all_items'             => __( 'Todos los doctores', 'doctor-cened' ),
            'add_new_item'          => __( 'Añadir nuevo doctor', 'doctor-cened' ),
            'add_new'               => __( 'Añadir nuevo', 'doctor-cened' ),
            'new_item'              => __( 'Nuevo doctor', 'doctor-cened' ),
            'edit_item'             => __( 'Editar doctor', 'doctor-cened' ),
            'update_item'           => __( 'Actualizar doctor', 'doctor-cened' ),
            'view_item'             => __( 'Ver doctor', 'doctor-cened' ),
            'view_items'            => __( 'Ver Doctores', 'doctor-cened' ),
            'search_items'          => __( 'Buscar doctor', 'doctor-cened' ),
            'not_found'             => __( 'No encontrado', 'doctor-cened' ),
            'not_found_in_trash'    => __( 'No encontrado en la papelera', 'doctor-cened' ),
            'featured_image'        => __( 'Imagen destacada', 'doctor-cened' ),
            'set_featured_image'    => __( 'Configura imagen', 'doctor-cened' ),
            'remove_featured_image' => __( 'Remover imagen destacada', 'doctor-cened' ),
            'use_featured_image'    => __( 'Usar como imagen destacada', 'doctor-cened' ),
            'insert_into_item'      => __( 'insertar en doctore', 'doctor-cened' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'doctor-cened' ),
            'items_list'            => __( 'lista de doctores', 'doctor-cened' ),
            'items_list_navigation' => __( 'Navegación de lista de doctores', 'doctor-cened' ),
            'filter_items_list'     => __( 'Filtrar listado de doctores', 'doctor-cened' ),
        );
        $rewrite = array(
            'slug'                  => 'doctores',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __( 'Doctor', 'doctor-cened' ),
            'description'           => __( 'Despliegue de doctores de CENED', 'doctor-cened' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', 'post-formats' ),
            'taxonomies'            => array( 'category' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-businessperson',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'doctores',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'doctores', $args );

    }
    add_action( 'init', 'cened_doctores_list', 0 );

};
/**Registrar al inicio el cpt */
function coltman_initial_plugin (){
    cened_doctores_list();
    flush_rewrite_rules(); 

};

register_activation_hook( __FILE__, 'coltman_initial_plugin' );

//quitar plugin
function coltman_ending_plugin(){
    unregister_post_type('doctores');
    flush_rewrite_rules(); 
}
register_deactivation_hook( __FILE__, 'coltman_ending_plugin' );