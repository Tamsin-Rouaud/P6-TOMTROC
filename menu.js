document.addEventListener("DOMContentLoaded", function() {
    // Récupère l'élément du menu burger et le conteneur des liens de navigation
    const burger = document.getElementById("burger");
    const navLinks = document.getElementById("nav-links");

    // Vérifie que les éléments existent avant d'ajouter l'écouteur d'événement
    if (burger && navLinks) {
        // Lorsqu'on clique sur l'icône du burger, on bascule la classe "active" sur le conteneur de liens
        burger.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });
    }
});
