document.addEventListener("DOMContentLoaded", function() {
    const burger = document.getElementById("burger");
    const navLinks = document.getElementById("nav-links");

    if (burger && navLinks) { // Vérifier que les éléments existent avant d'ajouter un event listener
        burger.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });
    }
});
