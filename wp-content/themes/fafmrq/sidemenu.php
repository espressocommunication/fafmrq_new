<div class="main-right wrapper clearfix">

	<div id="recherche" class="right-column-wrapper odd">
		<form action="">
			<?php get_search_form(); ?>
		</form>
	</div>

	<?php if ( is_active_sidebar( 'after_searchbar_widgets' ) ) : ?>
	<div id="after-searchbar-sidebar" class="widget-area">
		<?php dynamic_sidebar( 'after_searchbar_widgets' ); ?>
	<?php endif; ?>

	<?php
	$args = array(
		'post_type'			=>	'dossier',
		'posts_per_page'	=>	-1
	);
	$query = new WP_Query($args);
	if($query->have_posts()) : ?>
	<div id="dossier" class="right-column-wrapper even">
		<h3>Dossiers</h3>
		<div class="wrapper clearfix">
			<ul class="clearfix">
				<?php while($query->have_posts()) : $query->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php
	endif;
	wp_reset_query();
	?>

	<div id="social-networks" class="right-column-wrapper odd">
		<h3>Réseaux sociaux</h3>

		<p>Rejoignez-nous sur les réseaux sociaux.</p>
		<a class="social-icon facebook" href="https://www.facebook.com/pages/Fafmrq-Quebec/215273325165435" target="_blank">Notre page Faceboook</a>
		<a class="social-icon twitter" href="https://twitter.com/FAFMRQ" target="_blank">Notre compte Twitter</a>
	</div>

	<?php if ( is_active_sidebar( 'login' ) ) : ?>
		<?php dynamic_sidebar( 'login' ); ?>
	<?php endif; ?>

	<?php if (is_user_logged_in()): ?>
		<div id="disconnect" class="right-column-wrapper odd">
			<h3>Se déconnecter</h3>
			<p><a href="<?php echo wp_logout_url(); ?>" title="Se déconnecter">Cliquez ici pour vous déconnecter</a></p>
		</div>
	<?php endif; ?>

</div>
<!-- #main -->

