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
    <script type="text/javascript">
        function toggle_text() {
            var span = document.getElementById("span_txt");
            if(span.style.display == "none") {
                span.style.display = "inline";
            } else {
                span.style.display = "none";
            }
        }
    </script>

</head>
<body>

<nav id="test"> 
	<a href="index.php" class="accueil">ACCUEIL</a>
	<a href="nosproduits.php" class="nosproduits">NOS PRODUITS</a>
	<a href="index.php" class="logo">Mete'O'Motic</a>
    <?php if(isset($_SESSION['auth'])): ?>
	<a href="profil.php">MON COMPTE</a>
    <?php else: ?>
    <a href="inscription.php">INSCRIPTION</a>
    <?php endif; ?>
	<?php if (isset($_SESSION['auth'])): ?>
		<a href="deconnexion.php">DECONNEXION</a>
	<?php else: ?>
	<a href="connexion.php">CONNEXION</a>
	<?php endif; ?>
</nav>

<?php if(isset($_SESSION['flash'])): ?>
	<div class="contain">
	<?php foreach($_SESSION['flash'] as $type => $message): ?>

	<div class="alert alert-<?= $type; ?>">
		<?= $message; ?>
	</div>

<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>
</div>
<?php endif; ?>
