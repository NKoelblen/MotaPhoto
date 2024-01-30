(function ($) {
    $(document).ready(function () {

        const filterForm = $( '#js-photos-filter' );
        const dropdowns = filterForm.find(".select p");
        const nonce = $('.js-lightbox').attr('data-nonce');

        let open = [];

        dropdowns.each(function (key, val) {
            open[key] = false;
            $(window).on('click', function(e){
                if (val.contains(e.target)){
                    isOpen(val, key);
                } else if(open[key]) {
                    isOpen(val, key);
                }
            });
        });

        let options = filterForm.find("input");
            options.each(function() {
                $(this).on("change", () => {
                    let dropdown = $(this).closest('.options').siblings('p');
                    photosFilter();
                    if($(this).siblings('label').html()) {
                        dropdown.find('.checked').html($(this).siblings('label').html());
                    } else {
                        dropdown.find('.checked').html(dropdown.find('.default').html());
                    }
                });
            });
        
        function isOpen(element, key) {
            open[key] = !open[key];
            let options = element.nextElementSibling;
            let defaultValue = element.querySelector('.default');
            let checkedValue = element.querySelector('.checked');
            if(open[key]) {
                options.classList.remove("close");
                options.classList.add("open");
                options.style.setProperty('--height', options.scrollHeight + "px");
                options.style.setProperty('height', 'var(--height)');
                element.style.setProperty('--chevron', 'url(./assets/images/chevron-up.svg)');
                element.style.setProperty('border-radius', '8px 8px 0 0');
                element.style.setProperty('border-color', '#215AFF');
                defaultValue.style.setProperty('display', 'inline');
                checkedValue.style.setProperty('display', 'none');
            } else {
                options.classList.remove("open");
                options.classList.add("close");
                element.style.setProperty('--chevron', 'url(./assets/images/chevron-down.svg)');
                element.style.setProperty('border-radius', '8px');
                element.style.setProperty('border-color', '#B8BBC2');
                defaultValue.style.setProperty('display', 'none');
                checkedValue.style.setProperty('display', 'inline');
            }
        }

        function photosFilter() {

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = filterForm.attr('action');

            // Les données de notre formulaire
            
            let checkedCategory = filterForm.find('input[name="category"]:checked');
            let checkedFormat = filterForm.find( 'input[name="format"]:checked' );
            let checkedSort = filterForm.find('input[name="sort"]:checked');

            let category = "";
            if(checkedCategory.length) {
                category = checkedCategory.val();
            }
            let format = "";
            if(checkedFormat.length) {
                format = checkedFormat.val();
            }
            let sort = "ASC";
            if(checkedSort.length) {
                sort = checkedSort.val();
            }
            const data = {
                action: filterForm.find('input[name=action]').val(), 
                nonce:  filterForm.find('input[name=nonce]').val(),
                category: category,
                format: format,
                sort: sort,
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

                // En cas d'erreur
                if (!body.success) {
                    alert(response.data);
                    return;
                }

                let query = body.data['query'];

                // Et en cas de réussite
                $('.photos-wrapper').html(body.data['photos']); // Afficher le HTML

                document.querySelectorAll('.single-photo').forEach(photo => {
                    photoAnimation(photo);
                    document.addEventListener("scroll", () => {
                        photoAnimation(photo);
                    })
                });

                if ( body.data['max-page'] < 2 ) {
                    $(".js-loadmore-photos").css('display', 'none');
                } else {
                    $(".js-loadmore-photos").css('display', 'inline-block');
                    $('.js-loadmore-photos').data({
                        'query': query,
                        'nextpage': 2,
                        'maxpage': body.data['max-page']
                    });
                }
                let displayedPhotos = $('.single-photo').length;
                let i = 0;
                $(".js-lightbox").each(function() {
                    $(this).data({
                        'nonce': nonce,
                        'query': query,
                        'postsperpage': displayedPhotos,
                        'currentphoto': i
                    });
                    i++
                })
            });
        }
    });
})(jQuery);