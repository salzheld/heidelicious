/**
 * Süßes für die Augen für die Lönsschule
 *
 * Use jQuery to slide through images.
 * 
 * $('.slide').simplestSlideShow({'timeOut': 5000, 'speed': 1500});
 */
(function($) {
    // Alle <img>-Elemente (Bilder) bei :hover aufhellen.
    $('img').hover(
        function() {
            $(this).stop().animate({ opacity: '0.9' }, 'slow' );
        },
        function() {
            $(this).stop().animate({ opacity: '1.0' }, 'slow' );
        }
    );

    //remove emtpty asides
   $( 'aside' ).filter( function() {
        $( 'div:empty' ).remove();
        return $.trim($(this).html()) == '';
    }).remove();

/*
    $( 'div' ).filter( function() {
        return $.trim($(this).html()) == '';
    }).remove();

    $( 'div,aside' ).each( function() {
        if ($.trim ($(this).html()) == "") {
            $(this).remove();
        }
    });
*/
    
    // Elemente innherhalb .slide überblenden (jQuery-Plugin: jquery.simplestslideshow)
    $('.slide').simplestSlideShow({'timeOut': 5000, 'speed': 1500});
    
    // Initialize the Lightbox for any links with the 'fancybox' class
    $(".fancybox").fancybox();
    // Initialize the Lightbox automatically for any links to images with extensions .jpg, .jpeg, .png or .gif
    $("a[href$='.jpg'], a[href$='.png'], a[href$='.jpeg'], a[href$='.gif']").fancybox();
    // Initialize the Lightbox and add rel="gallery" to all gallery images when the gallery is set up using  so that a Lightbox Gallery exists
    $(".gallery a[href$='.jpg'], .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").attr('rel','gallery').fancybox();

})( jQuery );

// Form Validation
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#commentform").validate({
                rules: {
                    author: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    comment: {
                        required: true,
                        minlength: 20
                    }
                },
                messages: {
                    author: "Wir benötigen Ihren Namen.",
                    email: "Geben Sie bitte eine Ihre gültige E-Mail-Adresse an.",
                    comment: {
                        required: "Ohne Kommentar - kein Kommentar",
                        minlength: "Ein paar Wörter sollten Sie schon schreiben, oder?"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);