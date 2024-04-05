(function ($) {
	$(document).ready(function () {
		// Get nonce for later
		const nonce = $('.js-lightbox').attr('data-nonce');

		// On click on load more button...
		$('.js-loadmore-photos').click(function (e) {
			// ... Prevent classic submit form
			e.preventDefault();

			// ... Get URL that receives Ajax requests
			const ajaxurl = $(this).data('ajaxurl');

			// ... Get datas to send
			let data = {
				action: $(this).data('action'),
				nonce: $(this).data('nonce'),
				query: JSON.stringify($(this).data('query')),
				nextPage: $(this).data('nextpage'),
				maxPage: $(this).data('maxpage'),
			};

			// ... Send ajax request
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
					$('.photos-wrapper').append(body.data);

					// ... Animate Photos
					document.querySelectorAll('.single-photo').forEach((photo) => {
						photoAnimation(photo);
						document.addEventListener('scroll', () => {
							photoAnimation(photo);
						});
					});

					// ... If current page is the last page, remove load more button
					console.log('nextPage: ' + data['nextPage'] + 'maxPage:' + data['maxPage']);
					if (data['nextPage'] === data['maxPage']) {
						$('.js-loadmore-photos').css('display', 'none');
					}

					// ... Update nextpage data
					let nextPage = $(this).data('nextpage') + 1;
					$(this).data('nextpage', nextPage);

					// ... Set lightbox datas
					let displayedPhotos = $('.single-photo').length;
					let i = 0;
					$('.js-lightbox').each(function () {
						$(this).attr({
							'data-nonce': nonce,
							'data-query': data['query'],
							'data-postsperpage': displayedPhotos,
							'data-currentphoto': i,
						});
						i++;
					});
				});
		});
	});
})(jQuery);
