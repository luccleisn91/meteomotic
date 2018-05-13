<?php
require_once 'header.php';


?>
<?php if(isset($_SESSION['auth']) AND isset($_SESSION['auth']['token'])) {

            if(isset($_SESSION['auth']['tokensensor']) AND $_SESSION['auth']['tokensensor'] !== "aucune"){

                include_once 'bddsensor.php';
                $req = $basesensor->prepare('SELECT * FROM stationmeteo WHERE tokensensor = ? ORDER BY date_temperature DESC');
                $req->execute(array($_SESSION['auth']['tokensensor']));
                $donnees_sensor = $req->fetch();
                ?>
                <div id="container2">
    <div id="tableau">
        <div class="formulaire1"><p id="titre1">Données méteorologiques </p></div>
        <form method="POST" action="">

            <div class="formulaire">
                <label for="bas_temperature">Température </label>
                <input type="text" name="bas_temperature" class="focus" value="<?php if(isset($donnees_sensor)){ echo "Il fait " . $donnees_sensor['temperature']." °C " ."dans votre pièce". " à ". $donnees_sensor['date_temperature'];}?>"/>
            </div>
            <div class="formulaire">
                <label for="haut_temperature">Humidité </label>
                <input type="text" name="haut_temperature" class="focus" value="<?php echo $donnees_sensor['temperature'] . " %"?>"/>
            </div>
            <div class="formulaire2">
                </div>
        </form>


    </div>
    <?php
            }
            else
            {
                $erreurs['tokensensor'] = "Veuillez entrer une référence produit pour y accéder";
            }

        ?>

<?php if(!empty($_POST))
    {
        if(empty($_POST['bas_temperature']))
        {
            $erreurs['bas_temperature']="Veuillez remplir le seuil basse température";
        }
        if(empty($_POST['haut_temperature'])){
            $erreurs['haut_temperature']="Veuillez remplir le seuil haute température";
        }
    }

    ?>
    <?php
}
else
{
   $erreurs['connexion']= "Veuillez vous connecter pour pouvoir accéder à cette page.";
}
?>
   <!-- <div id="container2">
        <div id="tableau">
            <div class="formulaire1"><p id="titre1">Notifications </p></div>
            <form method="POST" action="">

                <div class="formulaire">
                    <label for="bas_temperature">Me notifier lorsque la température descend en dessous de </label>
                    <input type="text" name="bas_temperature" class="focus" value="<?php echo $donnees_sensor['temperature']?>"/>
                </div>
                <div class="formulaire">
                    <label for="haut_temperature">Me notifier lorsque la température est au dessus de </label>
                    <input type="text" name="haut_temperature" class="focus" value="<?php echo $donnees_sensor['temperature']?>"/>
                </div>
                <div class="formulaire2">
                    <button type="submit" name="inscription" value="inscription" id="inscription">Me notifier</button></div>
            </form>


        </div>

    </div>
    -->



</div>
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
<?php require 'footer.php';?>





