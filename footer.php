<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spooky
 */

?>

	</div><!-- #content -->

	<div id="colophon" class="site-footer">
		<?php
		get_sidebar();
		?>
		<footer class="site-info" role="contentinfo">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'spooky' ) ); ?>">
			<?php
			/* translators: %s: CMS name, i.e. WordPress. */
			printf( esc_html__( 'Proudly powered by %s', 'spooky' ), 'WordPress' );
			?></a>
			<span class="sep"> | </span>
			<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Theme: %1$s by %2$s.', 'spooky' ), 'Spooky', '<a href="https://themesbycarolina.com" rel="nofollow">Carolina</a>' );
			?>
		</footer><!-- .site-info -->
</div><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
