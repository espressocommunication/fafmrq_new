<?php

include "breadcrumb.php";

function theme_url($file=null){
	$return = '';
	$theme_url = get_bloginfo('template_url');
	$return .= $theme_url;
	$return .= '/';
	$return .= $file;
	return $return;
}


add_action( 'init', 'create_posts_types' );
function create_posts_types() {
	register_post_type( 'publication',
		array(
			'labels' => array(
				'name' => __( 'Publications' ),
				'all_items' => __( 'Toutes les publications', 'text_domain' ),
				'singular_name' => __( 'Publication' )
			),
			'supports'=> array('title', 'editor', /*'page-attributes',*/ ),
			'hierarchical' => false,
			'public' => true,
			'has_archive' => true,
			'menu_position' => 20,
			//'menu_icon' => theme_url('img/menu-icon.png'),
			'capability_type' => 'post',
			'rewrite' => array('slug' => 'publications'),
			'taxonomies' => array( 'category', 'publication_category' )
		)
	);
	register_taxonomy( 'publication_category', 'publication', array(
		'show_ui'		=>	true,
		'hierarchical'	=> true,
		'labels'		=>	array(
			'name'							=>	__( 'Catégories de publication' ),
			'singular_name'					=>	__( 'Catégorie du publication' ),
			'search_items'					=>	__( 'Rechercher une catégorie' ),
			'popular_items'					=>	__( 'Catégories populaires' ),
			'all_items'						=>	__( 'Toutes les catégories' ),
			'parent_item'					=>	null,
			'parent_item_colon'				=>	null,
			'edit_item'						=>	__( 'Éditer catégorie' ),
			'update_item'					=>	__( 'Mettre à jour catégorie' ),
			'add_new_item'					=>	__( 'Ajouter nouvelle catégorie de publications' ),
			'new_item_name'					=>	__( 'Nouvelle catégorie' ),
			'separate_items_with_commas'	=>	__( 'Séparer les catégories par des virgules' ),
			'add_or_remove_items'			=>	__( 'Ajouter ou supprimer une catégorie' ),
			'choose_from_most_used'			=>	__( 'Choisir parmi les catégories les plus utilisées' ),
			'not_found'						=>	__( 'Aucune catégorie trouvée' ),
			'menu_name'						=>	__( 'Catégories de publication' ),
		)
	));
	/*register_post_type( 'bulletin-de-liaison',
		array(
			'labels' => array(
				'name' => __( 'Bulletins de liaison' ),
				'all_items' => __( 'Tous les bulletins de liaison', 'text_domain' ),
				'singular_name' => __( 'Bulletin de liaison' )
			),
			'supports'=> array('title', 'editor', 'page-attributes', ),
			'hierarchical' => false,
			'public' => true,
			'has_archive' => false,
			'menu_position' => 20,
			//'menu_icon' => theme_url('img/menu-icon.png'),
			'capability_type' => 'post',
			'rewrite' => array('slug' => 'bulletins-de-liaison'),
			'taxonomies' => array( 'category', 'post_tag' )
		)
	);*/
	register_post_type( 'dossier',
		array(
			'labels' => array(
				'name' => __( 'Dossiers' ),
				'all_items' => __( 'Tous les dossiers', 'text_domain' ),
				'singular_name' => __( 'Dossier' )
			),
			'supports'=> array('title', 'editor', 'page-attributes', ),
			'hierarchical' => false,
			'public' => true,
			'has_archive' => false,
			'menu_position' => 20,
			//'menu_icon' => theme_url('img/menu-icon.png'),
			'capability_type' => 'post',
			'rewrite' => array('slug' => 'dossiers'),
			//'taxonomies' => array( 'category', 'post_tag' )
		)
	);
}

function register_my_menu() {
	register_nav_menu('main-menu',__( 'Menu principal' ));
	register_nav_menu('member-menu',__( 'Menu membre' ));
	register_nav_menu('ca-menu',__( 'Menu ca' ));
}
add_action( 'init', 'register_my_menu' );

function arphabet_widgets_init() {

	register_sidebar( array(
		'name' => 'Module login',
		'id' => 'login',
		'before_widget' => '<div id="membres" class="right-column-wrapper even">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );



function check_post_access($id, $type){
	$meta_members = get_post_meta($id, '_members_access_role');
	return in_array($type, $meta_members);
}

function after_searchbar_widgets_init() {

	register_sidebar( array(
		'name' => 'Widgets après barre de recherche',
		'id' => 'after_searchbar_widgets',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		// 'before_title' => '<h2 class="rounded">',
		// 'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'after_searchbar_widgets_init' );