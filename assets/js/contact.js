// Get contact form modal
const contactOuter = document.querySelector('#contact-outer');

// Open contact form modal on click on contact buttons
document.querySelectorAll('.contact-btn').forEach((button) => {
	button.addEventListener('click', () => {
		contactOuter.classList.remove('close');
		contactOuter.classList.add('open');
	});
});

// Close contact form modal on click outside the modal
contactOuter.addEventListener('click', function (event) {
	if (!event.target.closest('#contact-inner')) {
		contactOuter.classList.remove('open');
		contactOuter.classList.add('close');
	}
});

// Set reference value to your-photo input on single photo post
if (document.querySelector('#reference')) {
	document.getElementsByName('your-photo').forEach((input) => {
		input.setAttribute('value', document.querySelector('#reference').innerHTML);
	});
}
