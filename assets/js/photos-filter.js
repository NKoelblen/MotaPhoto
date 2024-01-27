(function ($) {
    $(document).ready(function () {

        const filterForm = document.getElementById( 'js-photos-filter' );
        const dropdowns = filterForm.querySelectorAll(".select p");
        const nonce = document.querySelector('.js-lightbox').getAttribute('data-nonce');

        let open = [];
        Object.entries(dropdowns).forEach(dropdown => {
            const [key, value] = dropdown;
            open[key] = false;
            window.addEventListener('click', function(e){
                if (value.contains(e.target)){
                    isOpen(value, key);
                } else if(open[key]) {
                    isOpen(value, key);
                }
            });
        });
        filterForm.querySelectorAll("input").forEach(option => {
            let dropdown = option.parentNode.parentNode.parentNode.querySelector("p");
            option.addEventListener("change", () => {
                photosFilter();
                if(option.previousElementSibling.innerHTML) {
                    dropdown.querySelector('.checked').innerHTML = option.previousElementSibling.innerHTML;
                } else {
                    dropdown.querySelector('.checked').innerHTML = dropdown.querySelector('.default').innerHTML;
                }
            });
        });

        function isOpen(element, key) {
            open[key] = !open[key];
            let options = element.nextElementSibling;
            let defaultValue = element.querySelector('.default');
            let checkedValue = element.querySelector('.checked');
            console.log(checkedValue);
            if(open[key]) {
                options.style.setProperty('display', 'block');
                element.style.setProperty('--chevron', 'url(./assets/images/chevron-up.svg)');
                element.style.setProperty('border-radius', '8px 8px 0 0');
                element.style.setProperty('border-color', '#215AFF');
                defaultValue.style.setProperty('display', 'inline');
                checkedValue.style.setProperty('display', 'none');
            } else {
                options.style.setProperty('display', 'none');
                element.style.setProperty('--chevron', 'url(./assets/images/chevron-down.svg)');
                element.style.setProperty('border-radius', '8px');
                element.style.setProperty('border-color', '#B8BBC2');
                defaultValue.style.setProperty('display', 'none');
                checkedValue.style.setProperty('display', 'inline');
            }
        }

        function photosFilter() {

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = filterForm.getAttribute('action');

            // Les données de notre formulaire
            let category = "";
            let checkedCategory = filterForm.querySelector('input[name="category"]:checked');
            let format = "";
            let checkedFormat = filterForm.querySelector( 'input[name="format"]:checked' );
            let sort = "ASC";
            let checkedSort = filterForm.querySelector('input[name="sort"]:checked');
            if(checkedCategory) {
                category = checkedCategory.value;
            }
            if(checkedFormat) {
                format = checkedFormat.value;
            }
            if(checkedSort) {
                sort = checkedSort.value;
            }
            const data = {
                action: filterForm.querySelector('input[name=action]').value, 
                nonce:  filterForm.querySelector('input[name=nonce]').value,
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



    });
})(jQuery);