const contactOuter = document.querySelector('#contact-outer');

document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener("click", () => {        
        contactOuter.classList.add("open");
        contactOuter.style.setProperty('display', 'flex', 'important');
    })
}) 
contactOuter.addEventListener("click", function(event) {
    if (!event.target.closest("#contact-inner")) {
        contactOuter.classList.remove("open");
        contactOuter.style.setProperty('display', 'none', 'important');
    }
})

if (document.querySelector('#reference')) {
    document.getElementsByName("your-photo").forEach(input => {
        input.setAttribute('value', document.querySelector('#reference').innerHTML);
    })
}