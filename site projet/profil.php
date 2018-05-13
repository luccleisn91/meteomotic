<?php
session_start();

require_once 'fonction.php';
require_once 'bdd.php';

if(isset($_SESSION['auth'])) {
    include_once 'header.php';
    ?>


<div id="title_container"><p id="title">Mon compte</p></div>

    <section class="sect section6">

    <div class="subsection">
        <a href="profil.php" class="test3">Mon profil</a>
        <a href="profiledit.php" class="test4">Éditer</a>
        <a href="temperature.php" class="test4">Température</a>
        <a href="graphique.php" class="test4">Graphique</a>
    </div class="subsection">

    <div class="formulaire5">
        <img src="image/img_avatar.png" alt="profil" class="profile-image"/>


        <h2>Bienvenue <?php echo $_SESSION['auth']['prenom']; ?></h2>
        <span id="span_txt" style="display:none;">

            <p>Nom : <?php echo $_SESSION['auth']['nom']; ?></p>

            <p>Adresse e-mail : <?php echo $_SESSION['auth']['email']; ?></p>

            <p>Ville : <?php echo $_SESSION['auth']['ville']; ?></p>

                <p>Référence produit : <?php if(isset($_SESSION['auth']['tokensensor'])){if ($_SESSION['auth']['tokensensor'] !== "aucune") {echo "ENTRÉE";} else{echo "AUCUNE";}} else {echo "AUCUNE";} ?></p>
        </span>
        <button type="button" id="boutoninfo" onclick="toggle_text();">Voir mes infos</button>


        <?php if (!empty($erreurs)): ?>

            <div class="formulaire3">
                <p>Veuillez remplir le formulaire</p>
                <ul>
                    <?php foreach ($erreurs as $erreur): ?>
                        <li><?= $erreur; ?></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </section>
<div class="formulaire7">
    <?php
    if (isset($_SESSION['auth'])) {
        ?>
        <a href="deconnexion.php" class="test5">Se déconnecter</a>




    </div>
        <?php require 'footer.php'; ?>

        <?php
    }
}
else {
    $_SESSION['flash']['attention'] = "Accès refusé, veuillez vous connecter.";
    header('Location: connexion.php');
    exit();
}?>




