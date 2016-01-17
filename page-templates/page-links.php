<?php
/**
 * Template Name: Links Page Template
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">

            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                        <ul class="bookmarks">
                            <?php wp_list_bookmarks( array(
                                'title_li' => false,
                                'title_before' => '<h2>',
                                'title_after' => '</h2>',
                                'category_before' => '<li id=%id class=%class>',
                                'category_after' => '</li>',
                                'categorize' => true,
                                'show_description' => true,
                                'between' => '<br />',
                                'show_images' => false,
                                'show_rating' => false ) );
                            ?>
                        </ul>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
                    </div><!-- .entry-content -->
                    <footer class="entry-meta">
                        <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer><!-- .entry-meta -->
                </article><!-- #post -->
                <?php comments_template( '', true ); ?>
            <?php endwhile; // end of the loop. ?>

        </div><!-- #content -->
    </div><!-- #primary -->

    <div id="secondary" class="widget-area" role="complementary">
        <div class="first widgets">
            <h3 class="widget-area-title">Aktuelles</h3>
            <?php
                global $wp_query;
                $postid = $wp_query->post->ID;
                $sidebar_cat = get_post_meta($postid, 'sidebar_cat', true);
                wp_reset_query();
            ?>
            <?php $myquery = new WP_Query( array( 'showposts' => 3, 'category_name' => $sidebar_cat ) );
            while ($myquery->have_posts()) : $myquery->the_post(); ?>
                <aside id="post-<?php the_ID(); ?>" class="widget widget_recent-sv">            
                    <h3 class="widget-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

                    <div class="entry-content">
                        <?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
                    </div><!-- .entry-content -->
                </aside><!-- #post -->
            <?php endwhile; ?>
        </div><!-- .first -->
    </div><!-- #secondary -->

    <?php get_footer(); ?>