<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<h2><?php the_title(); ?></h2>
	</div>
</div>
<div id="global">

	<div class="size-wrapper clearfix">

		<div class="main-container clearfix">

			<!-- #main -->

			<div class="main-left wrapper clearfix">

				<div class="main-left-wrapper">
					<?php if ( current_user_can( 'member_zone' ) ) : ?>
						<h2>Articles</h2>
						<div id="home-article-container" class="article-container">
						<? $query = new WP_Query('post_type=post&posts_per_page=-1'); ?>
							<?php if($query->have_posts()):?>
								<?php while($query->have_posts()) : $query->the_post(); ?>
									<?php if( check_post_access(get_the_ID(), 'membres') ) : ?>
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
					<?php else : ?>
						<div id="home-article-container" class="article-container">
							<div class="article">
								<p>Veuillez vous identifier</p>
							</div>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php include "sidemenu.php" ?>
			<!-- #main -->
		</div>

		<!-- #main-container -->
	</div>
	<?php get_footer(); ?>
