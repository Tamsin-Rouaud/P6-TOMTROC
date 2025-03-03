<section class="profileDetailsBlock">
<div class="boxProfile ownerBox">
            <div class="profileOwner">
                <div class="profileBlock" >
                    <img 
                        class="BlockProfilePicture"
                        id="profileImagePreview"                    
                        src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?> "
                        alt="Photo de profil"
                        >

                </p>

 
                    <input type="file" id="addProfileImage" name="addProfileImage" enctype="multipart/form-data" accept="image/*" style="display:none;">

                </div>
                <div class="underline">

                </div>
                <div class="profileText">
                   
               
                    <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <p id="firstP">Membre depuis <?= htmlspecialchars($membershipDuration ?? 'inconnu'); ?></p>
                    <p id="secondP">BIBLIOTHEQUE</p>
                    <p ><img class="iconBook" src="./images/bookIcon.png" alt="icône de livre"><?php 
                        $bookCount = BookManager::getUserBookCount($user->getIdUser());
                        echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : ''); 
                        ?></p>
                    <button class="button writeMessage"><a href="index.php?action=messaging&contact_id=<?= htmlspecialchars($user->getIdUser()) ?>">Écrire un message</a></button>
                </div>
            </div>
        </div>

<!-- Tableau  -->
<div class="myBookBlock ownerTable">
    <table>
        <thead>
            <tr>
                <th class="photo">PHOTO</th>
                <th class="title">TITRE</th>
                <th class="author">AUTEUR</th>
                <th class="description">DESCRIPTION</th>
                
                
            </tr>
        </thead>
        
        <tbody>
    <?php foreach ($books as $book): ?>
        <tr>
            <td class="photo">
                <img src="<?= htmlspecialchars($book->getImagePath(), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
            </td>
            <td class="title">
                <?= htmlspecialchars($book->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="author">
                <?= htmlspecialchars($book->getAuthorName(), ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="description">
                <span class="tooltip" data-tooltip="<?= htmlspecialchars($book->getDescription(), ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars(substr($book->getDescription(), 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                </span>
            </td>
            

        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    
</div>


</section>
