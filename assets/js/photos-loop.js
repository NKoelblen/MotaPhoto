// Translate photos...
function photoAnimation(element) {
	let elementRect = element.getBoundingClientRect();
	if (elementRect.top < window.innerHeight) {
		element.classList.add('animated');
	}
}
document.querySelectorAll('.single-photo').forEach((photo) => {
	// ... on load
	photoAnimation(photo);

	// ... on scroll
	document.addEventListener('scroll', () => {
		photoAnimation(photo);
	});
});
