<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<div class="left">
			<p>
				La Fédération des Associations <br/>
				de Familles Monoparentales <br/>
				et Recomposées du Québec <br/>
				(FAFMRQ) lutte pour l’amélioration <br/>
				des conditions de vie des familles <br/>
				monoparentales et recomposées.
			</p>
			<a href="<?php echo get_permalink(8); ?>">En savoir plus ›</a>
		</div>
		<div class="right">
			<h3>Nos actions</h3>
			<?php
			$args = array(
				'category_name'		=>	'actions',
				'posts_per_page'	=>	5
			);
			$query = new WP_Query($args);
			if($query->have_posts()) : ?>
				<ul>
				<?php while($query->have_posts()) : $query->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
				</ul>
			<?php endif;
			wp_reset_postdata();
			?>
			<a href="<?php echo get_category_link(get_category_by_slug('actions')); ?>">Voir toutes nos actions ›</a>
		</div>

	</div>
</div>
<div id="global">

	<div class="size-wrapper clearfix">

		<div class="main-container clearfix">

			<!-- #main -->

			<div class="main-left wrapper clearfix">

				<!---------------------- UNIQUE ARTICLE STARTS---------------------->

				<div class="main-left-wrapper">
					<h2>Résultats de recherche</h2>
					<div id="home-article-container" class="article-container">

						<?php if(have_posts()):?>
							<?php while(have_posts()) : the_post(); ?>
								<?php if( !check_post_access(get_the_ID(), 'membres') && !check_post_access(get_the_ID(), 'ca')) : ?>
								<div class="article">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<div class="infos clearfix">
										<?php $first = true; ?>
										<?php $categories = get_the_category(); ?>
										<p class="type"><?php the_category(' ,'); ?> | </p>
										<p class="date"><?php the_time('d F Y'); ?></p>
									</div>
									<div class="clearfix">
										<?php the_content(); ?>
									</div>
								</div>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>

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
