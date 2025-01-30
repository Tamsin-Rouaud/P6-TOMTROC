<section class="mailing">
    <!-- Contacts -->
    <div class="mailingContainer">
        <div class="mailingTitle">
        <h1>Messagerie</h1>
        </div>
        <?php if (!empty($lastMessages)): ?>
            <?php foreach ($lastMessages as $message): ?>
                <div class="contact">
                    <div class="contactImg">
                    <img src="<?= htmlspecialchars($message['image_path'] ?? 'uploads/defaultAvatar.png') ?>" alt="Image contact">
                    </div>
                    <div class="contactText">
                    <p><?= htmlspecialchars($message['username'] ?? 'Inconnu') ?></p>
                    <p><?= htmlspecialchars($message['message_text'] ?? 'Aucun message') ?></p>
                    </div>
                    <div class="contactTime">
                    <small><?= date('H:i', strtotime($message['created_at'])) ?></small>
                    
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun contact trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Colonne des messages -->
     <div class="containerMessage">
        <div class="blockMessage">
            <!-- <div class="messageContainerTitle"> -->
                <h3>
                    <img src="<?= htmlspecialchars($userImage ?? 'uploads/defaultAvatar.png') ?>" alt="Votre image">
                    <?= htmlspecialchars($userPseudo ?? 'Utilisateur') ?>
                </h3>
            <!-- </div> -->
            <div class="messagesContainer">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <small><?= htmlspecialchars($message->getCreatedAt()) ?></small>
                        <div class="messageUsername">
                        
                            <div>
                                <p><?= htmlspecialchars($message->getContactUsername() ?? 'Inconnu') ?>:</p>
                                <p><?= htmlspecialchars($message->getMessageText()) ?></p>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Sélectionnez un contact pour afficher la conversation.</p>
                <?php endif; ?>
            </div>
        </div>    
            <!-- Formulaire pour envoyer un message -->
            <form action="?action=sendMessage&contact_id=<?= htmlspecialchars($toUser) ?>" method="POST">
                <textarea name="message" rows="3" placeholder="Tapez votre message ici"></textarea>
                <button type="submit">Envoyer</button>
            </form>
    
    </div>
</section>
