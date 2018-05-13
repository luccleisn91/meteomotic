<?php
session_start();

require_once 'fonction.php';
require_once 'bdd.php';

if(isset($_SESSION['auth'])) {
    if(!empty($_POST)) {
        $erreurs = array();

        if (empty($_POST['prenom'])) {
            $erreurs['prenom'] = "Veuillez entrez votre prénom";
        }
        if (empty($_POST['nom'])) {
            $erreurs['nom'] = "Veuillez entrez votre nom";
        }
        if (empty($_POST['email'])) {
            $erreurs['email'] = "Veuillez entrez votre adresse email";
        }


        if (empty($_POST['mdp'])) {
            $erreurs['mdp'] = "Veuillez entrez votre mot de passe";
        }
        if ($_POST['mdp'] !== $_POST['mdp2']) {
            $erreurs['mdp2'] = "La confirmation du mot de passe est différente de celui rentré précedemment";
        }
        if (empty($_POST['ville'])) {
            $erreurs['ville'] = "Veuillez indiquer votre ville";
        }
        if (empty($_POST['tokensensor'])) {
            $erreurs['tokensensor'] = "Veuillez entrez une référence produit (0 si aucune)";
        }
        if (empty($erreurs)) {

            include_once 'bddsensor.php ';
            include_once 'bdd.php';
            $reqsensor = $basesensor->prepare('SELECT * FROM stationmeteo WHERE tokensensor= ?');
            $reqsensor->execute(array(htmlspecialchars($_POST['tokensensor'])));
            $reqsensor->closeCursor();

            $tokenexist = $reqsensor->rowCount();
            $user_id = $_SESSION['auth']['id'];

            if(htmlspecialchars($_POST['tokensensor'])== "aucune") {
                $mdp = password_hash(htmlspecialchars($_POST['mdp']), PASSWORD_BCRYPT);
                $req = $base->prepare('UPDATE membres SET prenom = ?, nom = ?, ville = ?, mdp = ?, email = ?, tokensensor = NULL WHERE id= ?');
                $req->execute([$_POST['prenom'], $_POST['nom'], $_POST['ville'], $mdp, $_POST['email'], $user_id]);
                $req->closeCursor();
                $_SESSION['flash']['succes'] = "Vous avez bien modifié vos informations";
                $_SESSION['auth']['tokensensor'] = "aucune";
                unset($_SESSION['auth']);
                header('Location: connexion.php');
                exit();
            }

            else {
                if($tokenexist >= 1)
                {
                    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
                    $req = $base->prepare('UPDATE membres SET tokensensor = ?, prenom = ?, nom = ?, ville = ?, mdp = ?, email = ? WHERE id= ?');
                    $req->execute([$_POST['tokensensor'], $_POST['prenom'], $_POST['nom'], $_POST['ville'], $mdp, $_POST['email'], $user_id]);
                    $_SESSION['flash']['succes'] = "Vous avez bien modifié vos informations";
                    $_SESSION['auth']['tokensensor']= $_POST['tokensensor'];
                    $req->closeCursor();
                    unset($_SESSION['auth']);
                    header('Location: connexion.php');
                    exit();

                }
                else {
                    $_SESSION['flash']['attention']= "Renseignements incorrects";

                }
            }


            }
            }









    include_once 'header3.php';
    ?>


    <section class="sect section1">


    <div id="container2">
		<div id="tableau">
            <div class="formulaire1"><p id="titre1">Mes infos</p></div>
		<form method="POST" action="">

			<div class="formulaire">
				<label for="prenom">Prénom</label>
				<input type="text" name="prenom" class="focus" value="<?php echo $_SESSION['auth']['prenom']?>"/>

			</div>
			<div class="formulaire">
				<label for="nom">Nom</label>
				<input type="text" name="nom" class="focus" value="<?php echo $_SESSION['auth']['nom']?>"/>
			</div>
			<div class="formulaire">
				<label for="email">Adresse email</label>
				<input type="email" name="email" class="focus" value="<?php echo $_SESSION['auth']['email']?>"/>
			</div>
			<div class="formulaire">
				<label for="mdp">Mot de passe </label>
				<input type="password" name="mdp" class="focus"/>
			</div>

			<div class="formulaire">
				<label for="mdp">Confirmation du mot de passe </label>
				<input type="password" class="focus" name="mdp2"/>
			</div>
            <div class="formulaire">
                <label for="tokensensor">Référence produit ("aucune" si aucune)</label>
                <input type="text" name="tokensensor" class="focus" value="<?php if(isset($_SESSION['auth']['tokensensor'])){echo $_SESSION['auth']['tokensensor'];}else{echo "aucune";} ?>"/>
            </div>
			<div class="formulaire">
				<label for="ville">Votre ville</label>
				<input type="text" name="ville" class="focus" value="<?php echo $_SESSION['auth']['ville']?>"/>
			</div>
			<div class="formulaire2">
			<button type="submit" name="inscription" value="inscription" id="inscription">Mettre à jour</button></div>
		</form>


</div>

</div>

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

        <?php require 'footer.php'; ?>

        <?php

}
else {
    $_SESSION['flash']['attention'] = "Accès refusé, veuillez vous connecter.";
    header('Location: connexion.php');
    exit();
}?>




