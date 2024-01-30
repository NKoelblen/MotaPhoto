(function ($) {
    $(document).ready(function () {

        const nonce = $('.js-lightbox').attr('data-nonce');

        // Chargment des photos en Ajax
        $('.js-loadmore-photos').click(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            let data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                query: JSON.stringify($(this).data('query')),
                nextPage: $(this).data('nextpage'),
                maxPage: $(this).data('maxpage'),
            }

            // Requête Ajax en JS natif via Fetch
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
                $('.photos-wrapper').append(body.data); // afficher le HTML

                document.querySelectorAll('.single-photo').forEach(photo => {
                    photoAnimation(photo);
                    document.addEventListener("scroll", () => {
                        photoAnimation(photo);
                    })
                });

                let nextPage = $(this).data('nextpage') + 1;
                if ( data['nextPage'] === data['maxPage'] ) { 
                    $(".js-loadmore-photos").css('display', 'none'); // if last page, remove the button
                }
                $(this).data('nextpage', nextPage);
                let displayedPhotos = $('.single-photo').length;
                let i = 0;
                $(".js-lightbox").each(function () {
                    $(this).attr({
                        'data-nonce': nonce,
                        'data-query': data['query'],
                        'data-postsperpage': displayedPhotos,
                        'data-currentphoto' :i
                    });
                    i++
                })

            })
        })
        
    })
})(jQuery);