<h2>Historique des Conversations</h2>

<?php if (!empty($conversations)) : ?>
    <ul>
        <?php foreach ($conversations as $message): ?>
            <div class="message-entry">
                <!-- Image de l'expéditeur -->
                <img src="<?= htmlspecialchars($message['sender_image']) ?>" alt="Image expéditeur" />
                <strong><?= htmlspecialchars($message['sender_username']) ?></strong> :

                <!-- Texte du message -->
                <?= htmlspecialchars($message['message_text']) ?>

                <!-- Date et heure d'envoi -->
                (<?= htmlspecialchars($message['created_at']) ?>)

                <br>

                <!-- Image du destinataire -->
                <img src="<?= htmlspecialchars($message['recipient_image']) ?>" alt="Image destinataire" />
                <strong><?= htmlspecialchars($message['recipient_username']) ?></strong>
            </div>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucune conversation disponible.</p>
<?php endif; ?>

