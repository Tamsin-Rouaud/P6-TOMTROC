<?php
// Récupération de l'ID du contact (uniquement si non vide)
$contactId = !empty($_GET['contact_id']) ? $_GET['contact_id'] : null;
?>
<section class="mailing">

  <!-- Liste des contacts -->
  <!-- Si un contact est sélectionné, on masque la liste en mobile -->
  <div class="mailingContainer <?php echo $contactId ? 'hide-mobile' : 'show-mobile'; ?>">
    <div class="mailingTitle">
      <h1>Messagerie</h1>
    </div>
    <?php if (!empty($contacts)): ?>
      <?php foreach ($contacts as $contact): ?>
        <a href="?action=messaging&contact_id=<?= htmlspecialchars($contact['id_user']) ?>">
          <div class="contact <?= (isset($_GET['contact_id']) && $_GET['contact_id'] == $contact['id_user']) ? 'activeContact' : '' ?>">
            <div class="contactImg">
              <img src="<?= htmlspecialchars($contact['image_path'] ?? 'uploads/defaultAvatar.png') ?>" alt="Image contact">
            </div>
            <div class="contactText">
              <p class="contactName"><?= htmlspecialchars($contact['username'] ?? 'Inconnu') ?></p>
              <p class="contactLastMessage">
                <?= !empty($contact['message_text']) 
                  ? htmlspecialchars(mb_strimwidth($contact['message_text'], 0, 30, "...")) 
                  : "Aucun message" ?>
              </p>
            </div>
            <div class="contactTime">
  <!-- Affichage de la date du dernier message (format jour/mois/année) -->
  <small><?= isset($contact['created_at']) ? date('d.m', strtotime($contact['created_at'])) : '' ?></small>
</div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun contact trouvé.</p>
    <?php endif; ?>
  </div>

  <!-- Colonne des messages -->
  <!-- Si aucun contact n'est sélectionné, on masque la conversation en mobile -->
  <div class="containerMessage <?php echo !$contactId ? 'hide-mobile' : 'show-mobile'; ?>">
    <div class="messageContainerTitle">
      <?php if (!empty($activeContact)): ?>
        <p class="arrowText">
        <a  href="index.php?action=messaging"><img class="arrow" src="./images/arrow.png" alt="Retour">retour</a>
    </p>
        <h3>
          <img src="<?= htmlspecialchars($activeContact['image_path'] ?? 'uploads/defaultAvatar.png') ?>" alt="Image contact">
          <?= htmlspecialchars($activeContact['username'] ?? 'Contact') ?>
        </h3>
      <?php else: ?>
        <h3>Sélectionnez un contact</h3>
      <?php endif; ?>
    </div>

    <div class="blockMessage">
      <div class="messagesContainer">
        <?php if (!empty($messages)): ?>
          <?php foreach ($messages as $message): ?>
            <?php $isSent = ($message->getFromUser() == $_SESSION['user']['id']); ?>
            <div class="messageWrapper <?= $isSent ? 'sent' : 'received' ?>">
              <?php if (!$isSent): ?>
                <!-- Affiche l'avatar et l'heure pour les messages reçus -->
                <div class="messageMeta">
                  <div class="messageAvatar">
                    <img src="<?= htmlspecialchars($message->getContactImage()) ?>" alt="Avatar">
                  </div>
                  <small class="messageTime">
                    <?= htmlspecialchars(date('d.m H:i', strtotime($message->getCreatedAt()))) ?>
                  </small>
                </div>
              <?php else: ?>
                <!-- Affiche uniquement l'heure pour les messages envoyés -->
                <small class="messageTime sentTime">
                  <?= htmlspecialchars(date('d.m H:i', strtotime($message->getCreatedAt()))) ?>
                </small>
              <?php endif; ?>

              <div class="messageBody">
                <div class="messageContent">
                  <p><?= htmlspecialchars($message->getMessageText()) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Formulaire pour envoyer un message -->
      <?php if (!empty($activeContact)): ?>
        <div class="formMessage">
          <form action="?action=sendMessage&contact_id=<?= htmlspecialchars($activeContact['id_user']) ?>" method="POST">
            <textarea name="message" rows="3" placeholder="Tapez votre message ici"></textarea>
            <button class="buttonMessage" type="submit">Envoyer</button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
