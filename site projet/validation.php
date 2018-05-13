<?php
$id_user = $_GET['id'];
$token = $_GET['token'];

require 'bdd.php';
$req = $base->prepare('SELECT * FROM membres WHERE id = ?');
$req->execute([$id_user]);
$user = $req->fetch();
session_start();

if($user AND $user->validation_token == $token) {
	
	$req = $base->prepare('UPDATE membres SET validation_token = NULL, validated_date = NOW() WHERE id = ?')->execute([$id_user]);
	$_SESSION['flash']['succes'] = "Votre compte a été validé.";
	$_SESSION['auth'] = $user;
	header('Location: connexion.php');
	exit();
}

else
{
	
	$_SESSION['flash']['attention'] = "L'email de vérification est erronée";
	header('Location: connexion.php');
    exit();

}