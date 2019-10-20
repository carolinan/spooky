<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Spooky
 */

get_header();
?>
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Hello! I can&rsquo;t find the page you are looking for. Maybe try a search?', 'spooky' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				get_search_form();
				?>
				<br>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/skeleton.svg' ); ?>" alt="<?php esc_attr_e( 'A friendly skeleton.', 'spooky' ); ?>" width="250px">
				<br>
				<br>
				<span class="page-title"><?php esc_html_e( 'Thank you for visiting!', 'spooky' ); ?></span>
			</section><!-- .error-404 -->

		</main><!-- #main -->

<?php
get_footer();
