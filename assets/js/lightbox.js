(function ($) {
	$(document).ready(function () {
		// On click on lightbox icon...
		$('.photos-wrapper').on('click', '.js-lightbox', function (e) {
			// ... Open lightbox
			$('#lightbox').removeClass('close');
			$('#lightbox').addClass('open');

			// Close lightbox on click on close button
			$('#lightbox .close-btn').click(function () {
				$('#lightbox').addClass('close');
				$('#lightbox').removeClass('open');
			});

			// ... Get photos and informations from the loop
			let slides = $('.photos-wrapper .single-photo')
				.map(function () {
					return {
						photo: $(this).find('.wp-post-image'),
						title: $(this).find('.informations .entry-title').text(),
						category: $(this).find('.informations p').text(),
						currentPhoto: $(this).find('.js-lightbox').data('currentphoto'),
					};
				})
				.get();

			if ($(this).has(e.target).length > 0) {
				let nbSlides = slides.length;
				let i = $(this).data('currentphoto');

				// ... Display current photo and informations
				$('#lightbox .photo').html(slides[i]['photo'].clone());
				$('#lightbox .entry-title').html(slides[i]['title']);
				$('#lightbox .category').html(slides[i]['category']);

				// On click on navigation links...
				$('#lightbox .nav-link').on('click', function () {
					// ... Navigate to the previous photo
					if ($(this).html() === $('#lightbox .nav-previous').html()) {
						if (i !== 0) {
							i = nbSlides - 1;
						} else {
							i--;
						}
					}

					// ... Navigate to the next photo
					else if ($(this).html() === $('#lightbox .nav-next').html()) {
						if (i === nbSlides - 1) {
							i = 0;
						} else {
							i++;
						}
					}

					// ... Display new photo
					$('#lightbox .photo').html(slides[i]['photo'].clone());

					// Reset photo fade in
					$('#lightbox .photo-container').removeClass('animated');
					window.requestAnimationFrame(function () {
						$('#lightbox .photo-container').addClass('animated');
					});

					//... Display new photo informations
					$('#lightbox .entry-title').html(slides[i]['title']);
					$('#lightbox .category').html(slides[i]['category']);
				});
			}
		});
	});
})(jQuery);
