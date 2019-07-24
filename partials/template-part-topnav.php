<?php

/**
* Top Navigation Partial
*
* This file controls the Top Navigation
*
* @package  Partials
*
*/

if ( has_nav_menu( 'top_menu' ) ) : ?>
	<nav class="top-navigation" role="navigation">

		<?php

			//-----------------------------------
			// Top Menu Args
			//-----------------------------------

			wp_nav_menu( array(
				'theme_location'    => 'top_menu',
				'depth'             => 1,
				'walker'            => new Walker_Nav_Menu())
			);
		?>

	</nav>
<?php endif; ?>