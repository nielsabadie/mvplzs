<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package techmarket
 */

get_header(); ?>
	
	<?php
		$user = wp_get_current_user();
		$user_id = get_current_user_id();
		$user_firstname = $user->user_firstname;
	?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main">

			<div class="error-404 not-found">

				<div class="page-content">

					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'techmarket' ); ?></h1>
					</header><!-- .page-header -->
					
					<h2>
						<?php if ( is_user_logged_in() && $user_firstname !== NULL ) {
							echo 'Hello <span style="color:#3ab5e7">' . $user_firstname . '</span>, vous êtes perdu(e) ?!';
						} else {
							echo 'Hello, vous vous êtes perdu(e) ?!';
						}?>
					</h2>
					
					<p><?php esc_html_e( 'Nothing was found at this location. Try searching, or check out the links below.', 'techmarket' ); ?></p>
					
					<img src="https://media.giphy.com/media/xT9IguCmdC3TD3z9CM/giphy-downsized.gif" width="200px" title="Oups je suis perdu(e)"/>

					<?php
					echo '<section aria-label="Search">';

					if ( techmarket_is_woocommerce_activated() ) {
						the_widget( 'WC_Widget_Product_Search' );
					} else {
						get_search_form();
					}

					echo '</section>';

					if ( techmarket_is_woocommerce_activated() ) {

						echo '<div class="fourohfour-columns-2">';

							echo '<section class="fourohfour-products" aria-label="Promoted Products">';

								techmarket_promoted_products();

							echo '</section>';

							echo '<nav class="fourohfour-categories" aria-label="Product Categories">';

							echo '<h2>' . esc_html__( 'Product Categories', 'techmarket' ) . '</h2>';

							the_widget( 'WC_Widget_Product_Categories', array(
																			'count'		=> 1,
							) );
							echo '</nav>';

							echo '</div>';

							echo '<section aria-label="Popular Products" >';

							echo '<h2>' . esc_html__( 'Popular Products', 'techmarket' ) . '</h2>';

							echo techmarket_do_shortcode( 'best_selling_products', array(
								'per_page'  => 6,
								'columns'   => 6,
							) );

							echo '</section>';
					}
					?>

				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
