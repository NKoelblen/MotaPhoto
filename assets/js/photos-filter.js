(function ($) {
	$(document).ready(function () {
		const filterForm = $('#js-photos-filter'),
			dropdowns = filterForm.find('.select p'),
			nonce = $('.js-lightbox').attr('data-nonce');

		// Open/Close Dropdowns on click
		let open = [];
		dropdowns.each(function (key, val) {
			open[key] = false;
			$(window).on('click', function (e) {
				if (val.contains(e.target)) {
					isOpen(val, key);
				} else if (open[key]) {
					isOpen(val, key);
				}
			});
		});

		// On change on dropdowns options ...
		let options = filterForm.find('input');
		options.each(function () {
			$(this).on('change', () => {
				let dropdown = $(this).closest('.options').siblings('p');
				// ... Filter photos
				photosFilter();
				/// ... Change dropdown value
				if ($(this).siblings('label').html()) {
					dropdown.find('.checked').html($(this).siblings('label').html());
				} else {
					dropdown.find('.checked').html(dropdown.find('.default').html());
				}
			});
		});

		function isOpen(element, key) {
			// Default : closed
			open[key] = !open[key];

			let options = element.nextElementSibling,
				defaultValue = element.querySelector('.default'),
				checkedValue = element.querySelector('.checked');

			// If open...
			if (open[key]) {
				// ... Display options
				options.classList.remove('close');
				options.classList.add('open');

				options.style.setProperty('--height', options.scrollHeight + 'px');
				options.style.setProperty('height', 'var(--height)');

				// ... Update dropdown style and value
				element.style.setProperty('--chevron', 'url(./assets/images/chevron-up.svg)');
				element.style.setProperty('border-radius', '8px 8px 0 0');
				element.style.setProperty('border-color', '#215AFF');

				defaultValue.style.setProperty('display', 'inline');

				checkedValue.style.setProperty('display', 'none');
			} else {
				// Else...
				// ... Hide options
				options.classList.remove('open');
				options.classList.add('close');

				// ... Uodate dropdown style and value
				element.style.setProperty('--chevron', 'url(./assets/images/chevron-down.svg)');
				element.style.setProperty('border-radius', '8px');
				element.style.setProperty('border-color', '#B8BBC2');

				defaultValue.style.setProperty('display', 'none');

				checkedValue.style.setProperty('display', 'inline');
			}
		}

		function photosFilter() {
			// Get URL that receives Ajax requests
			const ajaxurl = filterForm.attr('action');

			// Get datas to send
			let checkedCategory = filterForm.find('input[name="category"]:checked'),
				checkedFormat = filterForm.find('input[name="format"]:checked'),
				checkedSort = filterForm.find('input[name="sort"]:checked');

			let category = '';
			if (checkedCategory.length) {
				category = checkedCategory.val();
			}

			let format = '';
			if (checkedFormat.length) {
				format = checkedFormat.val();
			}

			let sort = 'ASC';
			if (checkedSort.length) {
				sort = checkedSort.val();
			}

			const data = {
				action: filterForm.find('input[name=action]').val(),
				nonce: filterForm.find('input[name=nonce]').val(),
				category: category,
				format: format,
				sort: sort,
			};

			// Send ajax request
			fetch(ajaxurl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Cache-Control': 'no-cache',
				},
				body: new URLSearchParams(data),
			})
				.then((response) => response.json())
				.then((body) => {
					// If error response : ALERT !
					if (!body.success) {
						alert(response.data);
						return;
					}

					// If success response ...

					// ... Display Photos
					$('.photos-wrapper').html(body.data['photos']);

					// ... Animate Photos
					document.querySelectorAll('.single-photo').forEach((photo) => {
						photoAnimation(photo);
						document.addEventListener('scroll', () => {
							photoAnimation(photo);
						});
					});

					let query = body.data['query'];
					// ... If current page is the last page, remove load more button
					if (body.data['max-page'] < 2) {
						$('.js-loadmore-photos').css('display', 'none');
					} else {
						// ... Else, update load more datas
						$('.js-loadmore-photos').css('display', 'inline-block');
						$('.js-loadmore-photos').data({
							query: query,
							nextpage: 2,
							maxpage: body.data['max-page'],
						});
					}

					// ... Set lightbox datas
					let displayedPhotos = $('.single-photo').length;
					let i = 0;
					$('.js-lightbox').each(function () {
						$(this).data({
							nonce: nonce,
							query: query,
							postsperpage: displayedPhotos,
							currentphoto: i,
						});
						i++;
					});
				});
		}
	});
})(jQuery);
