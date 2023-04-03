<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<h2>Publications</h2>
	</div>
</div>
<div id="global">

	<div class="size-wrapper clearfix">


		<div class="main-container clearfix">

			<!-- #main -->

			<div class="main-left wrapper clearfix">

				<div class="main-left-wrapper">
					<div id="actions-article-container" class="article-container">
						<?php
						$tax = get_taxonomies(array(
							'name'	=>	'publication_category'
						));
						//print_r($tax);
						$args = array(
							'tax_query'	=>	array(
								'taxonomy'	=>	'publication_category',
								'field'		=>	'id',
								'terms'		=>	1
							)
						);
						$query = new WP_Query($args);
						wp_reset_postdata();


						//
						$terms = get_terms(array(
							'publication_category'
						),array(
							'orderby'	=>	'menu_order',
							'hide_empty'=>	false
						));

						//$categories = array();

						// This puts "autres-documents" at the end of the array.
						foreach ($terms as $key => $current) {
							if($current->slug == "autres-documents"){
								$v = $terms[$key];
								unset($terms[$key]);
								$terms[$key] = $v;
							}
						}

						foreach($terms as $current){
							//array_push($categories, $current->term_id);
							echo '<h3>' . $current->name . '</h3>';
							$args = array(
								'post_type'	=>	'publication',
								'posts_per_page'	=>	-1,
								'tax_query'	=>	array(
									array(
										'taxonomy'			=>	'publication_category',
										'field'				=>	'id',
										'terms'				=>	$current->term_id
									)
								)
							);
							$query = new WP_Query($args);
							if($query->have_posts()) : ?>
								<div class="article">
									<ul>
									<?php while($query->have_posts()) : $query->the_post(); ?>
										<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
									</ul>
								</div>
							<?php endif;
							wp_reset_postdata();
						}



						?>
						<p>Des <a href="http://catalogue.cdeacf.ca/Record.htm?Record=19125191157919433739&idlist=4" target="_blank">publications moins récentes</a> sont accessibles sur le site du CDÉACF.</p>
					</div>
				</div>

			</div>
			<?php include "sidemenu.php"; ?>
			<!-- #main -->
		</div>

		<!-- #main-container -->
	</div>
<?php get_footer(); ?>
