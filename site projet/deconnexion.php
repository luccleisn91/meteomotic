<?php
include_once 'header.php';
session_start();
setcookie('remember', NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['succes']= "Vous êtes bien déconnecté.";
header("Location: connexion.php");
?>


<section class="sect section1">




</section>
<?php include_once 'footer.php';
