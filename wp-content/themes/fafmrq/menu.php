<div id="menu-principal">
	<div class="wrapper">
		<div id="nav">
			<?php if(current_user_can( 'member_zone' ) && current_user_can( 'ca_zone' ) ): ?>
				<ul>
					<li<?php if(is_home()) : ?> class="current_page_item"<?php endif; ?>><a href="<?php echo get_home_url(); ?>">Actualités</a></li>
					<?php wp_list_pages(array(
						'title_li'	=> '',
						'depth'		=> '1'
					)); ?>
				</ul>
			<?php elseif ( current_user_can( 'member_zone' ) ) : ?>
				<?php wp_nav_menu(array( 'theme_location' => 'member-menu')); ?>
			<?php elseif( current_user_can( 'ca_zone' ) ) : ?>
				<?php wp_nav_menu(array( 'theme_location' => 'ca-menu')); ?>
			<?php else : ?>
				<?php wp_nav_menu(array( 'theme_location' => 'main-menu')); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

