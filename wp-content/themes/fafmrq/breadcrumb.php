<?php

function the_breadcrumb() {

	global $post;

	if (!is_home()) {
		/*if(isset($_GET['categorie'])){
			$cat = $_GET['categorie'];
			$cat_name = null;
			$output = '';
			if($cat == 'all'){
				$cat_name = 'Toutes les catégories';
			}
			else{
				$terms = get_term_by('slug', $cat, 'category-publication');
				$cat_name = $terms->name;
			}

			$output .= '<span class="has-child">';
			$output .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
			$output .= '</span>';
			$output .= ' ' . $cat_name;
			echo $output;
		}*/
		/*elseif(get_post_type( get_the_ID() ) == 'secondary_page'){
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$anc_link = get_page_link( $post->post_parent );

				foreach ( $anc as $ancestor ) {
					$output = "";
					//$output .= " > ";
					$output .= '<span class="has-child"><a href='.$anc_link.'>'.get_the_title($ancestor).'</a></span> ';
					//$output .= "> ";
				}

				echo $output;
				the_title();

			} else {
				$output = '<span>';
				$output .= get_the_title();
				$output .= '</span>';
				echo $output;
			}
		}
		else*/if (is_category() || is_single()) {
			echo '<span>';
			if (is_single()) {
				the_title();
			}
			echo '</span>';
		} elseif (is_page()) {

			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$anc_link = get_page_link( $post->post_parent );

				$j = 1;
				$length = count( $anc );
				while ( $length-- && $j++ ) {
					$ancestor = $anc[ $length ];
					$output = "";
					//$output .= " > ";
					$output .= '<span class="has-child"><a href='.$anc_link.'>'.get_the_title($ancestor).'</a></span> ';
					$output .= " › ";
				}

				echo $output;
				the_title();

			} else {
				$output = '<span>';
				$output .= get_the_title();
				$output .= '</span>';
				echo $output;
			}
		}
	}
	elseif (is_tag()) {single_tag_title();}
	elseif (is_day()) {echo"Archive: "; the_time('F jS, Y'); echo'</li>';}
	elseif (is_month()) {echo"Archive: "; the_time('F, Y'); echo'</li>';}
	elseif (is_year()) {echo"Archive: "; the_time('Y'); echo'</li>';}
	elseif (is_author()) {echo"Author's archive: "; echo'</li>';}
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blogarchive: "; echo'';}
	elseif (is_search()) {echo"Search results: "; }

	wp_reset_query();
}