<?php

class SearchController {
    public function showSearch() {
        // Vérifie si un terme de recherche est passé dans l'URL
        if (isset($_GET['search'])) {
            // Récupère le terme de recherche, ou vide si non défini
            $searchTerm = $_GET['search'] ?? '';
            
            // Appeler le modèle pour obtenir les résultats de la recherche
            $searchManager = new SearchManager();
            $results = $searchManager->searchBooks($searchTerm);
            
            // Passer les résultats et le terme de recherche à la vue
            $view = new View('Résultats de recherche');
            $view->render('search', ['results' => $results, 'searchTerm' => $searchTerm]);
        } else {
            // Si aucune recherche n'est fournie, afficher un message
            echo "Aucun terme de recherche fourni.";
        }
    }
}


