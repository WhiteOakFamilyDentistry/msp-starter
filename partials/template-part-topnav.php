<?php if ( has_nav_menu( 'top_menu' ) ) : ?>
	<nav class="top-navigation" role="navigation">
		<?php
			wp_nav_menu( array(
				'theme_location'    => 'top_menu',
				'depth'             => 1,
				'walker'            => new Walker_Nav_Menu())
			);
		?>
	</nav>
<?php endif; ?>