<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<h2>Dossier : <?php the_title(); ?></h2>
	</div>
</div>
<div id="global">

	<div class="size-wrapper clearfix">

		<div class="main-container clearfix">

			<!-- #main -->

			<div class="main-left wrapper clearfix">

				<!---------------------- UNIQUE ARTICLE STARTS---------------------->

				<div class="main-left-wrapper">
					<div id="dossier-article-container" class="article-container">
						<div class="clearfix">
							<?php the_content(); ?>
						</div>
						<?php
						$children = get_field('children');
						if(isset($children[0]))
							$first_category_ID = $children[0];
						?>
						<?php if($children) : $first = true;?>
						<div class="clearfix">
							<ul>
								<?php foreach($children as $current) : ?>
								<li><a href="<?php echo get_category_link($current); ?>"><?php $cat_name = (String)get_the_category_by_ID($current); if($cat_name == get_the_title()) : echo 'Actualités'; else : echo $cat_name; endif;?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>

						<h3>Publications</h3>
						<div class="clearfix">
							<?php
							$categories = $children;
							$origArgs = array(
								'category__in'		=>	$categories,
								'post_type'			=>	'publication'
							);
							$origQuery = new WP_Query($origArgs);
							if($origQuery->have_posts()): ?>

							<?php $terms = get_terms('publication_category'); ?>
							<?php foreach ($terms as $term) : ?>
								<?php $args = $origArgs; ?>
								<?php $args['tax_query'] = array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'publication_category',
											'field' => 'term_id',
											'terms' => $term->term_id,
										)
									);
								?>
								<?php $query = new WP_Query($args); ?>

								<?php if($query->have_posts()): ?>
									
									<h4><?php echo $term->name; ?></h4>
									
									<ul>
									<?php while($query->have_posts()): $query->the_post(); ?>
										<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
									</ul>

								<?php endif; ?>

							<?php endforeach; ?>
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						</div>

					</div>
					<!------------------------------------------------ UNIQUE ARTICLE ENDS------------------------------->
				</div>

			</div>
			<?php include "sidemenu.php" ?>
			<!-- #main -->
		</div>

		<!-- #main-container -->
	</div>
<?php get_footer(); ?>
