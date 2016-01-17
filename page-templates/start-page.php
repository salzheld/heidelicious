<?php
/**
 * Template Name: Start Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">
            <?php $myquery = new WP_Query('showposts=1');
            while ($myquery->have_posts()) : $myquery->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('start-article'); ?>>
                    <header class="entry-header">
                        <?php the_post_thumbnail(); ?>
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-meta">
                    </footer><!-- .entry-meta -->
                </article><!-- #post -->
            <?php endwhile; ?>
            <aside id="recent" class="widget widget_recent">
                <h3 class="widget-title"><a href="http://loensschule.de/aktuell/">Weitere Artikel</a></h3>
                <?php $myquery = new WP_Query('showposts=5&offset=1'); ?>
                <ul>
                    <?php while ($myquery->have_posts()) : $myquery->the_post();?>
                    <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>
                    <?php endwhile; ?>
                </ul>    
            </aside>

        </div><!-- #content -->
    </div><!-- #primary -->

    <div id="secondary" class="widget-area" role="complementary">
        <div class="first front-widgets">
            <aside id="zertifizierungen" class="widget widget_zertifizierungen">
                <?php echo do_shortcode('[slide id="7283"]'); ?>
            </aside>            
            <aside id="calendar" class="widget">
                <?php echo do_shortcode('[calendar stil="Liste"]'); ?>
            </aside>
        </div><!-- .first -->
    </div><!-- #secondary -->

    <div id="tertiary" class="widget-area" role="complementary">
        <div class="second front-widgets">
            <?php dynamic_sidebar( 'sidebar-2' ); ?>
        </div><!-- .second -->

        <div class="third front-widgets">
            <?php dynamic_sidebar( 'sidebar-3' ); ?>
        </div><!-- .third -->
    </div><!-- #tertiary -->

<?php get_footer(); ?>