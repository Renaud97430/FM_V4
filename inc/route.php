<?php
$page = array();

// == A ==

// == B ==

// == C ==

// == D ==

// == E ==

// == F ==
$page['fo_home'] = 'mod/fo/home/home.php';
$page['fo_produit'] = 'mod/fo/produit/produit.php';
$page['fo_panier'] = 'mod/fo/panier/panier.php';
$page['fo_commande'] = 'mod/fo/commande/commande.php';
$page['fo_commandeAR'] = 'mod/fo/commande/commandeAR.php';

// == G ==

// == H ==
$page['home'] = 'mod/admin/home/home.php';

// == I ==

// == J ==

// == K ==

// == L ==
$page['login'] = 'mod/admin/login/login.php';
$page['logout'] = 'mod/admin/logout/logout.php';

if ($_SESSION[SESSION_NAME]['isAdmin'] == 1) {
    $page['listing_langue'] = 'mod/admin/langue/listing_langue.php';
    $page['listing_menu'] = 'mod/admin/menu/listing_menu.php';
    $page['listing_pays'] = 'mod/admin/pays/listing_pays.php';
    $page['listing_photo'] = 'mod/admin/listing_photo/listing_photo.php';
    $page['listing_produit'] = 'mod/admin/shop/produit/listing_produit.php';
    $page['listing_promotion'] = 'mod/admin/shop/promotion/listing_promotion.php';
    $page['listing_rayon'] = 'mod/admin/shop/rayon/listing_rayon.php';
    $page['listing_statut_cmd'] = 'mod/admin/shop/statut_commande/listing_statut_commande.php';
    $page['listing_stock'] = 'mod/admin/shop/stock/listing_stock.php';
    $page['listing_tva'] = 'mod/admin/shop/tva/listing_tva.php';
    $page['listing_commande'] = 'mod/admin/shop/commande/listing_commande.php';
    $page['listing_user'] = 'mod/admin/user/listing_user.php';
    $page['listing_ville'] = 'mod/admin/ville/listing_ville.php';

    // == M ==
    $page['manage_langue'] = 'mod/admin/langue/manage_langue.php';
    $page['manage_menu'] = 'mod/admin/menu/manage_menu.php';
    $page['manage_pays'] = 'mod/admin/pays/manage_pays.php';
    $page['manage_produit'] = 'mod/admin/shop/produit/manage_produit.php';
    $page['manage_promotion'] = 'mod/admin/shop/promotion/manage_promotion.php';
    $page['manage_rayon'] = 'mod/admin/shop/rayon/manage_rayon.php';
    $page['manage_commande'] = 'mod/admin/shop/commande/manage_commande.php';
    $page['manage_statut_cmd'] = 'mod/admin/shop/statut_commande/manage_statut_commande.php';
    $page['manage_stock'] = 'mod/admin/shop/stock/manage_stock.php';
    $page['manage_tva'] = 'mod/admin/shop/tva/manage_tva.php';
    $page['manage_user'] = 'mod/admin/user/manage_user.php';
    $page['manage_ville'] = 'mod/admin/ville/manage_ville.php';
    $page['maze'] = 'mod/admin/maze/maze.php';
}
// == N ==

// == O ==

// == P ==
$page['panier'] = 'mod/fo/panier/panier.php';

// == Q ==

// == R ==

// == S ==
$page['shop'] = 'mod/admin/shop/home_shop/home_shop.php';

// == T ==

// == U ==

// == V ==

// == W ==
$page['work'] = 'mod/work/work.php';

    // == X ==

    // == Y ==

    // == Z ==
