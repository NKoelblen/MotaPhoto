function photoAnimation(element) {
    let elementRect = element.getBoundingClientRect();
    if(elementRect.top < window.innerHeight) {
        element.classList.add('animated');
    }
}
document.querySelectorAll('.single-photo').forEach(photo => {
    photoAnimation(photo);
    document.addEventListener('scroll', () => {
        photoAnimation(photo);
    });
});