(function ($) {
    $(document).ready(function () {

        // Chargement des photos en Ajax
        $(".photos-wrapper").on("click", ".js-lightbox", function( e ) {

            $('#lightbox').removeClass('close');
            $('#lightbox').addClass('open');
            $('#lightbox .close-btn').click( function() {
                $('#lightbox').addClass('close');
                $('#lightbox').removeClass('open');
            });

            let slides = $('.photos-wrapper .single-photo').map(function(){
                return {
                    photo: $(this).find('.wp-post-image'),
                    title: $(this).find('.informations .entry-title').text(),
                    category: $(this).find('.informations p').text(),
                    currentPhoto: $(this).find('.js-lightbox').data('currentphoto')
                };
            }).get();

            if($(this).has(e.target).length > 0) {
                let nbSlides = slides.length;
                let i = $(this).data('currentphoto');
                $('#lightbox .photo').html(slides[i]['photo'].clone());
                $('#lightbox .entry-title').html(slides[i]['title']);
                $('#lightbox .category').html(slides[i]['category']);

                $("#lightbox .nav-link").on("click", function() {
                	if ($(this).html() === $("#lightbox .nav-previous").html()) {
                		if (i === 0) {
                			i = nbSlides - 1;
                		}
                		else {
                		i--;
                		}
                	}
                	else if ($(this).html() === $("#lightbox .nav-next").html()) {
                		if (i === nbSlides - 1) {
                			i = 0;
                		} else {
                		i++;
                		}
                	}
                    $('#lightbox .photo').html(slides[i]['photo'].clone());
                    $('#lightbox .photo-container').removeClass('animated');
                    window.requestAnimationFrame(function() {
                        $('#lightbox .photo-container').addClass('animated');
                      });
                    $('#lightbox .entry-title').html(slides[i]['title']);
                    $('#lightbox .category').html(slides[i]['category']);
                });

            }
        });
    });
})(jQuery);