(function ($) {
    $(document).ready(function () {

        // Chargment des photos en Ajax
        $(".photos-wrapper").on("click", ".js-lightbox", function( e ) {

            console.log($(this))

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            $('#lightbox').css('display', 'flex');
            $('#lightbox .close-btn').click( function() {
                $('#lightbox').css('display', 'none');
            })

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                query: JSON.stringify($(this).data('query')),
                currentPhoto: $(this).data('currentphoto'),
                postsPerPage: $(this).data('postsperpage'),
            }

            console.log(data);

            // Requête Ajax
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {

                // En cas d'erreur
                if (!body.success) {
                    alert(response.data);
                    return;
                }

                // Et en cas de réussite
                let slides = body.data['photos'];
                let nbSlides = slides.length;
                let i = body.data['current-photo'];

                $('#lightbox .photo').html(slides[i]['photo']);
                $('#lightbox .informations').replaceWith(slides[i]['informations']);
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
                    $('#lightbox .photo').html(slides[i]['photo']);
                    $('#lightbox .informations').replaceWith(slides[i]['informations']);
                });
            });
        });
    });
})(jQuery);