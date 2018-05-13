<?php

function str_random($longueur){
	 $suite = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($suite, $longueur)), 0, $longueur);

}
function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';
}
function reconnexion()
{
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if (isset($_COOKIE['remember']) AND !isset($_SESSION['auth'])) {
        require_once 'bdd.php';

        if(!isset($base)) {
            global $base;
        }

        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $base->prepare('SELECT * FROM membres WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if ($user) {
            $expected = $user['id'] . '==' . $user['remember_token'] . sha1($user['id'] . 'motaleatoire');
            if ($expected == $remember_token) {
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token,  time()+ 60*60*24*7);
            }
            else {

                setcookie('remember', NULL, -1);

            }
        }
        else
        {
            setcookie('remember', NULL, -1);

        }
    }
}