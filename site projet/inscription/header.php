<?php
	if(session_status() == PHP_SESSION_NONE){
session_start();
}
?>
<!doctype HTML>
<html lang="fr">
<head>
	<meta charset="utf-8"> <!--Encodage UTF8 + Favicon + mise en page CSS-->
<title>Mete'O'Motic</title>
<link rel="stylesheet" href="css.css"/>
</head>
<body>

<nav id="test"> 
	<a href="../index.html" class="accueil">ACCUEIL</a>
	<a href="../nosproduits.html" class="nosproduits">NOS PRODUITS</a>
	<a href="../index.html" class="logo">Mete'O'Motic</a>
	<a href="../informations.html" class="informations">INFORMATIONS</a>
	<?php if (isset($_SESSION['auth'])): ?>
		<a href="../deconnexion/deconnexion.php">DECONNEXION</a>
	<?php else: ?>
	<a href="../connexion/connexion.php">CONNEXION</a>
	<?php endif; ?>
</nav>
<div class="contain">
<?php if(isset($_SESSION['flash'])): ?>
	<?php foreach($_SESSION['flash'] as $type => $message): ?>

	<div class="alert alert-<?= $type; ?>">
		<?= $message; ?>
	</div>

<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>
<?php endif; ?>
</div>