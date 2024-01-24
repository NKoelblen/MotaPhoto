(function ($) {
    $(document).ready(function () {

        let currentPage = 1;
        const nonce = document.querySelector('.js-lightbox').getAttribute('data-nonce');

        // Chargment des photos en Ajax
        $('.js-loadmore-photos').click(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                query: JSON.stringify($(this).data('query-args')),
                currentPage: currentPage++,
                maxPage: $(this).data('max-page'),
            }
            data['currentPage']++

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
                if ( data['currentPage'] === data['maxPage'] ) { 
                    document.querySelector(".js-loadmore-photos").style.setProperty('display', 'none'); // if last page, remove the button
                }
                let displayedPhotos = document.querySelectorAll('.single-photo').length;
                let i = 0;
                document.querySelectorAll(".js-lightbox").forEach(button => {
                    button.setAttribute('data-nonce', nonce);
                    button.setAttribute('data-query-args', data['query']);
                    button.setAttribute('data-posts-per-page', displayedPhotos);
                    button.setAttribute('data-current-photo', i);
                    i++
                })

            })
        })
        
    })
})(jQuery);