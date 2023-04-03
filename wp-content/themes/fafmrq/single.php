<?php include "file_redirect.php"; ?>
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

				<!---------------------- UNIQUE ARTICLE STARTS---------------------->

				<div class="main-left-wrapper">
					<h2>Articles</h2>
					<div id="home-article-container" class="article-container">

						<?php if(have_posts()):?>
							<?php while(have_posts()) : the_post(); ?>
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
								<?php include "file_zone.php"; ?>
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