<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); // Include the header.php template part.

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<p><?php the_date(); ?> by <?php the_author(); ?></p>
			</footer><!-- .entry-footer -->
		</article><!-- #post-<?php the_ID(); ?> -->

		<?php
	endwhile;

else :
	?>

	<article class="no-posts">
		<h2><?php esc_html_e( 'No Posts Found', 'textdomain' ); ?></h2>
		<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'textdomain' ); ?></p>
	</article>

	<?php
endif;

get_footer(); // Include the footer.php template part.
