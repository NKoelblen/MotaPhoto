(function ($) {
    $(document).ready(function () {

        // Chargment des photos en Ajax
        $( ".photos-wrapper" ).on( "click", ".js-lightbox", function( e ) { // Event propagation

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            document.querySelector('#lightbox').style.setProperty('display', 'block');
            $('#lightbox .close-btn').click( function() {
                document.querySelector('#lightbox').style.setProperty('display', 'none');
            })

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                query: JSON.stringify($(this).data('query-args')),
                currentPhoto: $(this).data('current-photo'),
                postsPerPage: $(this).data('posts-per-page'),
            }

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
                $('#lightbox .informations').html(slides[i]['informations']);
                document.querySelectorAll("#lightbox .nav-link").forEach(navLink => {
                	navLink.addEventListener("click", () => {
                		if (navLink === document.querySelector("#lightbox .nav-previous")) {
                			if (i === 0) {
                				i = nbSlides - 1;
                			}
                			else {
                			i--;
                			}
                		}
                		else if (navLink === document.querySelector("#lightbox .nav-next")) {
                			if (i === nbSlides - 1) {
                				i = 0;
                			} else {
                			i++;
                			}
                		}
                        $('#lightbox .photo').html(slides[i]['photo']);
                        $('#lightbox .informations').html(slides[i]['informations']);
                	});
                });

            });
        });
        
    });
})(jQuery);