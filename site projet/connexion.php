<?php
include_once 'fonction.php';
reconnexion();
if(isset($_SESSION['auth']))
{
    header('Location: profil.php');
    exit();
}
if(!empty($_POST)){
    require_once 'bdd.php';
    $erreurs = array();
    if (empty($_POST['email'])) {
        $erreurs['email'] = "Veuillez entrer votre adresse e-mail";

    }
    if (empty($_POST['mdp'])) {
        $erreurs['mdp'] = "Veuillez entrer un mot de passe";
        }

    if (empty ($erreurs)) {


        $req = $base->prepare('SELECT * FROM membres WHERE email = :email');
        $req->execute(array('email' => htmlspecialchars($_POST['email'])));
        $user = $req->fetch();
        $mdp_verif = password_verify(htmlspecialchars($_POST['mdp']), $user['mdp']);

            if ($mdp_verif) {
                session_start();
                $_SESSION['auth'] = $user;
                $_SESSION['flash']['succes'] = "Vous êtes désormais connecté";
                if($_POST['remember'])
                {
                    $remember_token = str_random(250);
                    $req3 = $base->prepare('UPDATE membres SET remember_token=? WHERE id = ?');
                    $req3->execute(array($remember_token, $user['id']));
                    setcookie('remember', $user['id'] .'==' . $remember_token . sha1($user['id'] . 'motaleatoire'), time()+ 60*60*24*7);
                }
                header('Location: profil.php');
                exit();
        } else {
            $_SESSION['flash']['attention'] = "E-mail ou/et mot de passe invalides";
        }
    }
}

require_once 'header2.php';
?>


<section class="sect section1">
	<div id="container2">
	<div id="tableau">
	<div class="formulaire1"><h1>Connexion</h1></div>
<form method="POST" action="">
		<div class="formulaire">
				<label for="email">Adresse email</label>
				<input type="email" name="email" class="focus"/>

		</div>
		
		<div class="formulaire">
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" class="focus"/>

		</div>
    <div class="formulaire2">
        <label class="test">
            <input type="checkbox" name="remember" value="1" id="checkbox">Se souvenir de moi</input>
        </label>
    </div>

	<div class="formulaire2">
		<button type="submit" name="connexion" value="connexion" id="connexion">Connexion</button></div>

</form>
<div class="formulaire2">
	<a href="inscription.php" id="sinscrire">Ou s'inscrire</a>
	</div>
</div>
</div>
    <?php if(!empty($erreurs)): ?>

        <div class="formulaire3">
            <p>Veuillez remplir le formulaire</p>
            <ul>
                <?php foreach($erreurs as $erreur): ?>
                    <li><?= $erreur; ?></li>

                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</section>

<?php require_once 'footer.php'; ?>