<?php if (!empty($results)): ?>
    <h2>Résultats de recherche pour: <?php echo htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8'); ?></h2>
    <ul>
        <?php foreach ($results as $book): ?>
            <li><?= htmlspecialchars($book['title']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun résultat trouvé pour "<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>"</p>
<?php endif; ?>
