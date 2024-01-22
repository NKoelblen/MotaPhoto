(function ($) {
    $(document).ready(function () {

        const photosFilter = document.getElementById( 'js-photos-filter' );
        const category = photosFilter.querySelector( '#category' ) ;
        const format = photosFilter.querySelector( '#format' ) ;
        const sort = photosFilter.querySelector( '#sort' ) ;

        category.addEventListener( 'change', () => {

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = photosFilter.getAttribute('action');

            // Les données de notre formulaire
			// ⚠️ Ne changez pas le nom "action" !
            const data = {
                action: photosFilter.querySelector('input[name=action]').value, 
                nonce:  photosFilter.querySelector('input[name=nonce]').value,
                category: category.value,
                format: format.value,
                sort: sort.value,
            }

            // Pour vérifier qu'on a bien récupéré les données
            console.log(ajaxurl);
            console.log(data);

            // Requête Ajax en JS natif via Fetch
            fetch( ajaxurl, {
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
                $('.photos-wrapper').html(body.data); // Et afficher le HTML
            });
        });

        format.addEventListener( 'change', () => {

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = photosFilter.getAttribute('action');

            // Les données de notre formulaire
			// ⚠️ Ne changez pas le nom "action" !
            const data = {
                action: photosFilter.querySelector('input[name=action]').value, 
                nonce:  photosFilter.querySelector('input[name=nonce]').value,
                category: category.value,
                format: format.value,
                sort: sort.value,
            }

            // Pour vérifier qu'on a bien récupéré les données
            console.log(ajaxurl);
            console.log(data);

            // Requête Ajax en JS natif via Fetch
            fetch( ajaxurl, {
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
                $('.photos-wrapper').html(body.data); // Et afficher le HTML
            });
        });

        sort.addEventListener( 'change', () => {

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = photosFilter.getAttribute('action');

            // Les données de notre formulaire
			// ⚠️ Ne changez pas le nom "action" !
            const data = {
                action: photosFilter.querySelector('input[name=action]').value, 
                nonce:  photosFilter.querySelector('input[name=nonce]').value,
                category: category.value,
                format: format.value,
                sort: sort.value,
            }

            // Pour vérifier qu'on a bien récupéré les données
            console.log(ajaxurl);
            console.log(data);

            // Requête Ajax en JS natif via Fetch
            fetch( ajaxurl, {
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
                $('.photos-wrapper').html(body.data); // Et afficher le HTML
            });
        });
        
    });
})(jQuery);