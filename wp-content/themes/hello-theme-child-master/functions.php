<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

add_post_type_support( 'page', 'excerpt' );

/* login page */ 
function esp_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'esp_login_logo_url' );

function esp_login_logo_url_title() {
    return get_bloginfo('title');
}
add_filter( 'login_headertext', 'esp_login_logo_url_title' );

function esp_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/esp-login/css/login.css' );
    wp_enqueue_style( 'adobe-fonts', 'https://use.typekit.net/xia4gtu.css', false );
}
add_action( 'login_enqueue_scripts', 'esp_login_stylesheet' );

add_filter('gettext', 'mycustom_func', 10, 3);
function mycustom_func($translated_text, $text, $domain){
  
        if($text == 'Remember Me'){
            $translated_text = 'Se souvenir de moi';
        }
        elseif($text == 'You are Logged in as'){
            $translated_text = 'Vous êtes connecté en tant que';
        }
        elseif($text == 'Logout'){
            $translated_text = 'Se déconnecter';
        }
        elseif($text == 'Lost your password?'){
            $translated_text = 'Mot de passe perdu?';
        }
        return $translated_text;
       }