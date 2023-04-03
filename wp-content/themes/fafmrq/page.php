<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<h2><?php the_breadcrumb(); ?></h2>
	</div>
</div>
<div id="global">

	<div class="size-wrapper clearfix">


		<div class="main-container clearfix">

			<!-- #main -->

			<div class="main-left wrapper clearfix">

				<div class="main-left-wrapper">
					<div id="actions-article-container" class="article-container">
						<?php the_content(); ?>
					</div>
				</div>

			</div>
			<?php include "sidemenu.php"; ?>
			<!-- #main -->
		</div>

		<!-- #main-container -->
	</div>
<?php get_footer(); ?>
