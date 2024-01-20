const menuBtn = document.querySelector('#primary-mobile-menu');
const openIcone = document.querySelector('.dropdown-icon.open');
const closeIcone = document.querySelector('.dropdown-icon.close');
const menuUL = document.querySelector('#primary-menu-list');
function closemenu() {
    menuBtn.setAttribute("aria-expanded", "false");
    openIcone.style.setProperty('display', 'inline', 'important');
    closeIcone.style.setProperty('display', 'none', 'important');
    menuUL.style.setProperty('display', 'none', 'important');
}
menuBtn.addEventListener("click", () => {
    if (menuBtn.getAttribute( 'aria-expanded') === 'false' ) {
        menuBtn.setAttribute("aria-expanded", "true");
        openIcone.style.setProperty('display', 'none', "important");
        closeIcone.style.setProperty('display', 'inline', 'important');
        menuUL.style.setProperty('display', 'block', 'important');
    } else {
        closemenu();
    }
})
document.querySelectorAll('#primary-menu-list a').forEach(link => {
    link.addEventListener("click", () => {
        closemenu();
    })
})
window.addEventListener("resize", () => {
    if (window.matchMedia("(min-width: 375px)").matches) {
        menuUL.style.setProperty('display', 'block', 'important');
    } else {
        menuUL.style.setProperty('display', 'none', 'important');
    }
});