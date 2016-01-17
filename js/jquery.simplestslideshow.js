/**
 * jQuery Plugin - Simplest Slideshow.
 *
 * Use jQuery to slide through images.
 * 
 * $('.slide').simplestSlideShow({'timeOut': 5000, 'speed': 1500});
 */
 ( function( $ ) {
    $.fn.simplestSlideShow = function( settings ) {
        var config = {
            'timeOut': 3000,
            'speed': 'normal'
        };
        
        if ( settings ) $.extend( config, settings );
        
        this.each( function() {
            var $elem = $( this );
            $elem.children( ':gt(0)' ).hide();
            setInterval( function() {
                $elem.children().eq( 0 ).fadeOut( config[ 'speed' ] )
                .next().fadeIn( config[ 'speed' ] )
                .end().appendTo( $elem );
            }, config[ 'timeOut' ] );
        } );
        return this;
    };
} )(jQuery);