(function ($) {
    $(document).ready(function () {

        const filterForm = document.getElementById( 'js-photos-filter' );
        const category = filterForm.querySelector( '#category' ) ;
        const format = filterForm.querySelector( '#format' ) ;
        const sort = filterForm.querySelector( '#sort' ) ;
        const nonce = document.querySelector('.js-lightbox').getAttribute('data-nonce');

        function photosFilter() {
            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = filterForm.getAttribute('action');

            // Les données de notre formulaire
            const data = {
                action: filterForm.querySelector('input[name=action]').value, 
                nonce:  filterForm.querySelector('input[name=nonce]').value,
                category: category.value,
                format: format.value,
                sort: sort.value,
            }
            
            // Requête Ajax
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

                let queryArgs = JSON.stringify(body.data[2])

                // Et en cas de réussite
                $('.photos-wrapper').html(body.data[0]); // Afficher le HTML
                if ( body.data[1] < 2 ) {
                    document.querySelector(".js-loadmore-photos").style.setProperty('display', 'none'); // if last page, remove the button
                } else {
                    document.querySelector(".js-loadmore-photos").style.setProperty('display', 'inline-block');
                    document.querySelector(".js-loadmore-photos").setAttribute('data-query-args', queryArgs);
                }
                let displayedPhotos = document.querySelectorAll('.single-photo').length;
                let i = 0;
                document.querySelectorAll(".js-lightbox").forEach(button => {
                    button.setAttribute('data-nonce', nonce);
                    button.setAttribute('data-query-args', queryArgs);
                    button.setAttribute('data-posts-per-page', displayedPhotos);
                    button.setAttribute('data-current-photo', i);
                    i++
                })
            });
        }

        category.addEventListener( 'change', () => {
            photosFilter();
        });

        format.addEventListener( 'change', () => {
            photosFilter();
        });

        sort.addEventListener( 'change', () => {
            photosFilter();
        });

    });
})(jQuery);