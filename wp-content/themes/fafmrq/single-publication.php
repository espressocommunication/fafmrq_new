<?php include "file_redirect.php"; ?>
<?php get_header(); ?>
<div id="introduction">
	<div class="wrapper clearfix">
		<h2>Publications › <?php global $post; $terms = array_values(get_the_terms($post->id, 'publication_category')); echo $terms[0]->name; ?></h2>
	</div>
</div>
<div id="global">

    <div class="size-wrapper clearfix">



        <div class="main-container clearfix">

            <!-- #main -->

            <div class="main-left wrapper clearfix">

                <!---------------------- UNIQUE ARTICLE STARTS---------------------->

                <div class="main-left-wrapper">
					<div id="publications-article-container" class="article-container">
						<div class="article">
							<h3><?php the_title(); ?></h3>

							<div class="clearfix">
								<?php the_content(); ?>
							</div>
						</div>
						<?php include "file_zone.php"; ?>
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
