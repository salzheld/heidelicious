<?php
/**
 * Template Name: Vertretungsplan Page Template, No Sidebar
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
					<section id="substitutions">
						<iframe src="../../../../vertretung/PH_heute.htm" width="100%" height="1500" name="aktueller Vertretungsplan">
								<p>Ihr Browser kann leider keine eingebetteten Frames anzeigen:
							  Sie k&ouml;nnen die eingebettete Seite &uuml;ber den folgenden Verweis
							  aufrufen: <a href="../../../index.htm">SELFHTML</a></p>
						</iframe>
					</section>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>