<?php


// Initialisation des Sessions ($_SESSION)
session_name(SESSION_NAME);
session_start();
require('inc/framework.php');

// Gestion des routes !
if (isset($_SESSION[SESSION_NAME]['id_user']) && !empty($_SESSION[SESSION_NAME]['id_user'])) {
    // L'utilisateur est connecté !
    if (isset($_GET['page']) && isset($page[$_GET['page']])) {
        // La page demandé existe => on va pouvoir l'afficher !
        $url_php = $page[$_GET['page']];
    } else {
        // Forcer l'affichage de la page d'accueil
        $url_php = $page['home'];
    }
} else {
    // On force le login !
    $url_php = $page['login'];
}

// Gestion de la procedure
$url_php_proc = str_replace('.php', '_proc.php', $url_php);
if (is_file($url_php_proc)) {
    include $url_php_proc;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <!-- Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Style CSS Responsive -->
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <!-- Inclusion Police TTF -->
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    <?php
    $url_php_head = str_replace('.php', '_head.php', $url_php);
    if (is_file($url_php_head)) {
        include $url_php_head;
    } else {
        echo "<title>Formation IFR</title>";
    }
    ?>
</head>

<?php
include $url_php;
?>

</html>