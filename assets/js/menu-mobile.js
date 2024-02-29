const menuBtn = document.querySelector('#primary-mobile-menu'),
	openIcone = document.querySelector('.dropdown-icon.open'),
	closeIcone = document.querySelector('.dropdown-icon.close'),
	menuUL = document.querySelector('#primary-menu-list');

// On click on menu button...
menuBtn.addEventListener('click', () => {
	// ... If the menu is closed...
	if (menuBtn.getAttribute('aria-expanded') === 'false') {
		// ... Update attribute
		menuBtn.setAttribute('aria-expanded', 'true');

		// ... Update the button icone
		openIcone.style.setProperty('display', 'none', 'important');
		closeIcone.style.setProperty('display', 'inline', 'important');

		// ... Open the menu
		menuUL.classList.remove('close');
		menuUL.classList.add('open');
	} else {
		// ... Else, close the menu
		closemenu();
	}
});

// Close the mobile menu on click on menu links
document.querySelectorAll('#primary-menu-list li').forEach((link) => {
	link.addEventListener('click', () => {
		if (window.matchMedia('(max-width: 430px)').matches) {
			closemenu();
		}
	});
});

// Close the menu :
function closemenu() {
	// Update attribute
	menuBtn.setAttribute('aria-expanded', 'false');

	// Update the button icone
	openIcone.style.setProperty('display', 'inline', 'important');
	closeIcone.style.setProperty('display', 'none', 'important');

	// Close the menu
	menuUL.classList.remove('open');
	menuUL.classList.add('close');
}
