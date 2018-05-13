<?php
require_once 'header.php';


?>
<?php if(isset($_SESSION['auth']) AND isset($_SESSION['auth']['ville'])) { ?>
    <section class="sect section5">
        <section class="background">

            <a href="https://www.prevision-meteo.ch/meteo/localite/<?php if (isset($_SESSION['auth'])) {
                echo $_SESSION['auth']['ville'];
            } ?>">
                <img src="https://www.prevision-meteo.ch/uploads/widget/<?php if (isset($_SESSION['auth'])) {
                    echo $_SESSION['auth']['ville'];
                } ?>_0.png" width="650" height="250"/></a>
            <a href="https://www.prevision-meteo.ch/meteo/localite/<?php if (isset($_SESSION['auth'])) {
                echo $_SESSION['auth']['ville'];
            } ?>">
                <img src="https://www.prevision-meteo.ch/uploads/widget/<?php if (isset($_SESSION['auth'])) {
                    echo $_SESSION['auth']['ville'];
                } ?>_1.png" width="650" height="250"/></a>
            <a href="https://www.prevision-meteo.ch/meteo/localite/<?php if (isset($_SESSION['auth'])) {
                echo $_SESSION['auth']['ville'];
            } ?>">
                <img src="https://www.prevision-meteo.ch/uploads/widget/<?php if (isset($_SESSION['auth'])) {
                    echo $_SESSION['auth']['ville'];
                } ?>_2.png" width="650" height="250"/></a>

        </section>
    </section>

    <?php
}
else
{
   $erreurs['connexion']= "Veuillez vous connecter pour pouvoir accéder à cette page.";
}
?>
<?php if(!empty($erreurs)): ?>
<div class="background3" style ="height:850px; width:100%; display:flex;">
    <div class="formulaire3" style="margin:auto; padding: 5%;">
        <p>Veuillez bien lire les erreurs suivantes</p>
        <ul>
            <?php foreach($erreurs as $erreur): ?>
                <li><?= $erreur; ?></li>

            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
    </section>
<?php require 'footer.php';?>?>


    <?php
require_once 'footer.php';

    ?>