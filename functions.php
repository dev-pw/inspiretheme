<?php
/**
 * Functions
 * @package WordPress
 * @subpackage inspiretheme
 *
*/

/*--------------------------------------------------------------
ESTILOS E SCRIPTS
--------------------------------------------------------------*/
function enqueue_scripts() {

	//VERSÃO DO TEMA
	$tema_version = time();

	//BOOTSTRAP JS
	wp_enqueue_script( 'bootstrap-poppers', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', array('jquery'), $tema_version, true );
	wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js', array('jquery'), $tema_version, true );

	//SWIPER
	if(is_front_page()) :
	wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), $tema_version, 'all');
	wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), $tema_version, true);
	endif;

	//JQUERY MASK
	wp_enqueue_script('jqueryMask-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js', array('jquery'), $tema_version, true );

	//STYLE THEME
	wp_enqueue_style('theme', get_template_directory_uri().'/assets/css/theme.min.css', array(), $tema_version, 'all');
	wp_enqueue_style('icon', get_template_directory_uri().'/assets/icons/style.css', array(), $tema_version, 'all');

	//CSS DEFAULT
	wp_enqueue_style('default-style', get_stylesheet_uri(), array(), $tema_version, 'all');

	//SCRIPT THEME JS
	wp_enqueue_script( 'theme-js', get_template_directory_uri().'/assets/js/theme.js', array('jquery'), $tema_version, true );

	//SCRIPT FORMS JS
	wp_enqueue_script( 'forms-js', get_template_directory_uri().'/assets/js/forms.js', array('jquery'), $tema_version, true );
	
	// LIGHTGALLERY JS 
	wp_enqueue_style('lightGallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css', array(), $tema_version, 'all');
	wp_enqueue_script( 'lightGallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js', array('jquery'), $tema_version, true );
	
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');


/*--------------------------------------------------------------
CONFIGURACOES DO TEMA
--------------------------------------------------------------*/

function setup_theme() {

	// Adicionar title dinamicamente
	add_theme_support('title-tag');

	// // Esconder barra logada wordpress
	// add_filter('show_admin_bar', '__return_false');

	// Habilitar imagem destacada
	add_theme_support('post-thumbnails');

	// habilitar resumo em páginas
	add_post_type_support( 'page', 'excerpt' );

	// habilitar responsivo em todos os embeds (youtube)
	add_theme_support( 'responsive-embeds' );

	// Registrar menus
	register_nav_menus( array(
		'menu-principal' => 'Menu principal'
	) );
}

add_action( 'after_setup_theme', 'setup_theme' );


/*--------------------------------------------------------------
Default
--------------------------------------------------------------*/
include ('inc/default.php');

/*--------------------------------------------------------------
Pre get posts
--------------------------------------------------------------*/
//include('inc/pre_get_posts.php');

/*--------------------------------------------------------------
Iniciar sessão automaticamente em todas as páginas
--------------------------------------------------------------*/
function register_my_session()
{
		if (!session_id()) {
				session_start();
		}
}

add_action('init', 'register_my_session');

