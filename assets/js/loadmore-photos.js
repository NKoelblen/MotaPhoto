(function ($) {
    $(document).ready(function () {

        let currentPage = 1;

        // Chargment des commentaires en Ajax
        $('.js-loadmore-photos').click(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'), 
                nonce:  $(this).data('nonce'),
                currentPage: currentPage++,
                maxPage: $(this).data('max-page'),
            }
            data['currentPage']++

            // Pour vérifier qu'on a bien récupéré les données
            console.log(ajaxurl);
            console.log(data);

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
                console.log(body);

                // En cas d'erreur
                if (!body.success) {
                    alert(response.data);
                    return;
                }

                // Et en cas de réussite
                $('.photos-wrapper').append(body.data); // afficher le HTML
                if ( data['currentPage'] === data['maxPage'] ) { 
                    document.querySelector(".js-loadmore-photos").remove(); // if last page, remove the button
                }
            });
        });
        
    });
})(jQuery);