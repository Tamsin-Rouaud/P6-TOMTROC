<?php
// Récupère l'ID du contact depuis l'URL, ou le définit à null s'il n'est pas fourni
$contactId = !empty($_GET['contact_id']) ? $_GET['contact_id'] : null;
?>
<section class="mailing">

  <!-- Bloc Liste des contacts -->
  <!-- La classe CSS change en fonction de la sélection d'un contact pour gérer l'affichage en mobile -->
  <div class="mailingContainer <?= $contactId ? 'hideMobile' : 'show-mobile'; ?>">
    <div class="mailingTitle">
      <h1>Messagerie</h1>
    </div>

    <?php if (!empty($contacts)): ?>
      <?php foreach ($contacts as $contact): ?>
        <!-- Lien pour sélectionner un contact et afficher la conversation -->
        <a href="?action=messaging&contact_id=<?= htmlspecialchars($contact['id_user']) ?>">
          <div class="contact <?= (isset($_GET['contact_id']) && $_GET['contact_id'] == $contact['id_user']) ? 'activeContact' : '' ?>">
            <div class="contactImg">
              <!-- Affiche l'avatar du contact ou une image par défaut -->
              <img src="<?= htmlspecialchars($contact['image_path'] ?? 'uploads/defaultAvatar.png') ?>" alt="Image contact">
            </div>
            <div class="contactText">
              <!-- Affiche le nom du contact -->
              <p class="contactName"><?= htmlspecialchars($contact['username'] ?? 'Inconnu') ?></p>
              <!-- Affiche le dernier message (limité à 30 caractères) ou un message par défaut -->
              <p class="contactLastMessage">
                <?= !empty($contact['message_text']) 
                      ? htmlspecialchars(mb_strimwidth($contact['message_text'], 0, 30, "...")) 
                      : "Aucun message" ?>
              </p>
            </div>
            <div class="contactTime">
              <!-- Affiche la date du dernier message au format jour.mois -->
              <small><?= isset($contact['created_at']) ? date('d.m', strtotime($contact['created_at'])) : '' ?></small>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun contact trouvé.</p>
    <?php endif; ?>
  </div>

  <!-- Bloc Colonne des messages -->
  <!-- La conversation s'affiche en fonction de la sélection d'un contact et est masquée en mobile si aucun contact n'est choisi -->
  <div class="containerMessage <?= !$contactId ? 'hideMobile' : 'showMobile'; ?>">
    <div class="messageContainerTitle">
      <?php if (!empty($activeContact)): ?>
        <!-- Lien retour pour revenir à la liste des contacts (visible en mobile) -->
        <p class="arrowText">
          <a href="index.php?action=messaging">
            <img class="arrow" src="./images/arrow.png" alt="Retour">retour
          </a>
        </p>
        <!-- Affiche le nom et l'image du contact actif -->
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
            <?php 
              // Détermine si le message a été envoyé par l'utilisateur connecté
              $isSent = ($message->getFromUser() == $_SESSION['user']['id']);
            ?>
            <div class="messageWrapper <?= $isSent ? 'sent' : 'received' ?>">
              <?php if (!$isSent): ?>
                <!-- Pour les messages reçus, affiche l'avatar du contact et l'heure -->
                <div class="messageMeta">
                  <div class="messageAvatar">
                    <img src="<?= htmlspecialchars($message->getContactImage()) ?>" alt="Avatar">
                  </div>
                  <small class="messageTime">
                    <?= htmlspecialchars(date('d.m H:i', strtotime($message->getCreatedAt()))) ?>
                  </small>
                </div>
              <?php else: ?>
                <!-- Pour les messages envoyés, affiche uniquement l'heure -->
                <small class="messageTime sentTime">
                  <?= htmlspecialchars(date('d.m H:i', strtotime($message->getCreatedAt()))) ?>
                </small>
              <?php endif; ?>

              <!-- Corps du message -->
              <div class="messageBody">
                <div class="messageContent">
                  <p><?= htmlspecialchars($message->getMessageText()) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Formulaire d'envoi d'un message, affiché uniquement si un contact est actif -->
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
