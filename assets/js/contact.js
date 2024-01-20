const contactContainer = document.querySelector('#contact-container');

document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener("click", () => {        
        contactContainer.classList.add("open");
        contactContainer.style.setProperty('display', 'block', 'important');
    })
}) 
document.addEventListener("click", function(event) {
    if (!event.target.closest("#contact-container, .contact-btn")) {
        contactContainer.classList.remove("open");
        contactContainer.style.setProperty('display', 'none', 'important');
    }
})