<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once 'header.php';
?>

<section class="sect section1">
<p id="adapter">S'adapte à votre habitat</p>
<a href="decouvrir.html" id="decouvrir">Découvrir</a>

</section>
<section class="sect section2">
	<p id="meteo">Indique la météo dans votre ville</p>
		<a href="meteo.php" id="meteo1">Voir la météo de votre ville</a>

</section>

<?php
require_once 'footer.php';
		?>