<?php
register_default_headers( array (
    'loens' => array (
        'url' => get_stylesheet_directory_uri() .'/images/headers/header_loens.jpg',
        'thumbnail_url' => get_stylesheet_directory_uri() .'/images/headers/header_loens-thumbnail.jpg',
        'description' => 'Neues Headerbild' )
    )
);

function heidelicious_add_favicon() {
    echo '<link rel="shortcut icon" href="http://loensschule.de/wp-content/themes/heidelicious/images/favicon.ico">';
}
add_action( 'wp_head', 'heidelicious_add_favicon' );

function heidelicious_body_class( $classes ) {
    $background_color = get_background_color();

    if ( is_page_template( 'page-templates/start-page.php' ) ) {
        $classes[] = 'template-start-page';
        if ( has_post_thumbnail() )
            $classes[] = 'has-post-thumbnail';
    }

    if ( is_page_template( 'page-templates/page-sv.php' ) ) {
        $classes[] = 'template-page-sv';
        if ( has_post_thumbnail() )
            $classes[] = 'has-post-thumbnail';
    }

    if ( is_page_template( 'page-templates/page-vertretung.php' ) ) {
        $classes[] = 'full-width';
    }

    return $classes;
}
add_filter( 'body_class', 'heidelicious_body_class' );

function heidelicious_footer_text() {

    $out = '<a class="childtheme-link" href="http://wordpress.org/extend/themes/twentytwelve" title="Heidelicious basiert auf dem WordPress-Theme TwentyTwelve">Heidelicious</a> | ';

    if ( is_user_logged_in() )
        $out .= sprintf('<a class="login-link" href="%1$s">%2$s</a>', admin_url(), 'angemeldet' );
    else 
        $out .= sprintf('<a class="login-link" href="%1$s">%2$s</a>', wp_login_url( esc_url( $_SERVER['HTTP_REFERER'] ) ), 'anmelden' );

    echo $out;

}
add_action( 'twentytwelve_credits', 'heidelicious_footer_text' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link, but
 * with a custom text.
 * 
 * @param array $args The argument array.
 * @return array The modified arguments array.
 */
function heidelicious_page_menu_args($args) {
  $args['show_home'] = 'Aktuell';
  return $args;
}
add_filter('wp_page_menu_args', 'heidelicious_page_menu_args', 11);

// Shortcodes in Widgets parsen
add_filter('widget_text', 'do_shortcode');

// Shortcode: [slide id="" orderby=""]
function heidelicious_slide($atts, $content = null) {
    global $post;
    if ( is_home() ) return;
    
    extract(shortcode_atts(array(
      "id" => $post->ID,
      "orderby" => 'rand'
    ), $atts));
    
    $attachments = get_posts( array(
        'orderby'  => $orderby,
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $id,
         'exclude'     => get_post_thumbnail_id()
    ) );

    if ( $attachments ) {

        $out = '<div class="slide">';
        foreach ( $attachments as $attachment ) {
            $out .= wp_get_attachment_link( $attachment->ID, 'medium' );
        }
        $out .= '</div>';
        
        return $out;
    }
}
add_shortcode('slide', 'heidelicious_slide');

// Shortcode [links category=""]
function heidelicious_links($atts){

    $out = '<div class="bookmarks">';

    extract(shortcode_atts(array(
            'limit' => '-1',
            'category' => '',
            'show_description' => true,
            'orderby' => 'name'), $atts));

    if ( $limit != '-1' ) $orderby = 'rand';
        
    $cat = explode(",", $category);

    foreach ( $cat as $id=>$category ) {

    $out .= wp_list_bookmarks(array(
                'limit' => $limit,
                'show_images' => false, 'show_description' => $show_description,
                'show_name' => true,
                'category_name' => $category,
                'orderby' => $orderby, 'order' => 'ASC',
                'title_li' => 'Related Links',
                'echo' => false
            ));
    }

    $out    .= '</div>';

    return $out;

}
add_shortcode('links', 'heidelicious_links');

// EMAIL ENCODE SHORTCODE
function email_encode_function( $atts, $content ) {
    extract(shortcode_atts(array(
      "url" => $content
    ), $atts));
	return '<a href="'.antispambot("mailto:".$url).'">'.$content.'</a>';
}
add_shortcode( 'email', 'email_encode_function' );

// Shortcode: [filelink file=""]
function heidelicious_filelink($attr) {
    return '<iframe src="http://docs.google.com/viewer?url=http%3A%2F%2Floensschule.de%2Fwp-content%2Fuploads%2F' . $attr['file'] . '&embedded=true" width="960" height="780"></iframe>';
}
add_shortcode('filelink', 'heidelicious_filelink');

// Shortcode: Zeige den Google Kalendar [calendar stil="Liste"]
function heidelicious_calendar($atts){

    $out = '<div class="calendar">';

    extract(shortcode_atts(array(
            'stil' => 'Monat' ), $atts));

    if ( $stil == 'Liste' ) {
        $out .= '<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=100&amp;wkst=2&amp;hl=de&amp;bgcolor=%23FFFFFF&amp;src=claudiamiehe%40googlemail.com&amp;color=%2329527A&amp;ctz=Europe%2FBerlin" style=" border-width:0 " height="300" frameborder="0" scrolling="no"></iframe>';
    }
    else {
        $out .= '<iframe style="border-width: 0;" src="https://www.google.com/calendar/embed??showTitle=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;hl=de&amp;bgcolor=%23FFFFFF&amp;src=claudiamiehe%40googlemail.com&amp;color=%23A32929&amp;ctz=Europe%2FBerlin" height="700" width="950" frameborder="0" scrolling="no"></iframe>';
    }
        
    $out .= '</div>';

    return $out;

}
add_shortcode('calendar', 'heidelicious_calendar');

// Bilder immer mit der url verknüpfen
add_action('pre_option_image_default_link_type', 'always_link_images_to_file');
function always_link_images_to_file() {
	return 'file';
}

/**
 * Function to remove the comment section from all attachment pages
 * 
 * @param  $open
 * @param  $post_id
 */
function remove_comments_from_attachments( $open, $post_id ){
    return ( 'attachment' == get_post_type( $post_id )  ) ? false : $open;
}
add_action( 'pre_comment_on_post', 'remove_comments_from_attachments', 10, 2 );

// Enqueue Scripts/Styles für den Lightbox-Effekt
function heidelicious_add_lightbox() {
    wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri() . '/fancybox/js/jquery.fancybox.pack.js', array( 'jquery' ), false, true );
    wp_enqueue_style( 'lightbox-style', get_stylesheet_directory_uri() . '/fancybox/css/jquery.fancybox.css' );
}
add_action( 'wp_enqueue_scripts', 'heidelicious_add_lightbox' );


// Enqueue Scripts/Styles
function heidelicious_enque_scripts() {
    wp_enqueue_script( 'simplestslideshow', get_stylesheet_directory_uri() .'/js/jquery.simplestslideshow.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'eyecandy', get_stylesheet_directory_uri() .'/js/eyecandy.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'validate', get_stylesheet_directory_uri() .'/js/jquery.validate.min.js', array( 'jquery' ), '1.10.0', true );
}
add_action( 'wp_enqueue_scripts', 'heidelicious_enque_scripts' );
?>