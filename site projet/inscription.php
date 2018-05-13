<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once 'fonction.php';

if(!empty($_POST))
{
	$erreurs = array();
	require_once 'bdd.php';

	if(empty($_POST['nom']))
		{
			$erreurs['nom'] = "Veuillez entrer un nom";
		}

	if(empty($_POST['prenom']))
		{
			$erreurs['prenom'] = "Veuillez entrer un prénom";
		}

	if(empty($_POST['email']) AND (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
		{
			$erreurs['email'] = "Veuillez entrer une adresse e-mail";
		}
		else 
			{
				require_once 'bdd.php';
				$reqemail = $base->prepare("SELECT * FROM membres WHERE email = ?");
				$reqemail->execute(array($_POST['email']));
				$cherchemail=$reqemail->rowCount();

				if($cherchemail!=0)
					{	
						$erreurs['email'] = "Cette adresse e-mail est déjà utilisée.";
					}

			}
	if(empty($_POST['email2']) AND (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
		{
			$erreurs['email2'] = "Veuillez confirmer votre e-mail";
		}

	if($_POST['email']!=$_POST['email2'])
		{
			$erreurs['email2']= "La confirmation de l'email est différente de celle rentrée précedemment";
		}

	if(empty($_POST['mdp']))
		{
			$erreurs['mdp']= "Veuillez entrer un mot de passe";
		}

	if($_POST['mdp']!==$_POST['mdp2'])
		{
			$erreurs['mdp2']= "La confirmation du mot de passe est différente de celui rentré précedemment";
		}
	if(empty($_POST['ville']))
		{
			$erreurs['ville']= "Veuillez indiquer votre ville";
		}


	if(empty($erreurs))
		{
			$mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
			$req = $base->prepare("INSERT INTO membres SET email = ?, mdp = ?, prenom = ?, nom = ?, ville = ?, validation_token = ?");
			$token = str_random(60);
			$req->execute([htmlspecialchars($_POST['email']), htmlspecialchars($mdp), htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['ville']), htmlspecialchars($token)]);
			$id_user = $base->lastInsertId();
			mail($_POST['email'], 'Confirmation de votre compte', "Pour confirmer votre compte, veuillez cliquer sur le lien qui vous redigera sur notre site. \n\n http://localhost/site%20projet/inscription/validation.php?id=$id_user&token=$token");
			$_SESSION['flash']['succes'] = "Un email de confirmation vous a été envoyé";
			header('Location: connexion.php');
			exit();
		}
}

require 'header3.php';
?>

<section class="sect section1">
	<div id="container2">
		<div id="tableau">
		<div class="formulaire1"><p id="titre1">S'inscrire</p></div>
		<form method="POST" action="">
				
			<div class="formulaire">
				<label for="prenom">Prénom</label>
				<input type="text" name="prenom" class="focus"/>
				
			</div>
			<div class="formulaire">
				<label for="nom">Nom</label>
				<input type="text" name="nom" class="focus"/>
			</div>
			<div class="formulaire">
				<label for="email">Adresse email</label>
				<input type="email" name="email" class="focus"/>
			</div>
			<div class="formulaire">
				<label for="email2">Confirmation de l'adresse email </label>
				<input type="email" class="focus" name="email2"/>
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
				<label for="ville">Votre ville</label>
				<input type="text" name="ville" class="focus"/>
			</div>		
			<div class="formulaire2">
			<button type="submit" name="inscription" value="inscription" id="inscription">M'inscrire</button></div>
		</form>

		
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
<?php require 'footer.php';?>