<?php
$bdd = new Data();

if(isset($_GET['add_id_produit']) && !empty($_GET['add_id_produit'])) {
    // L'utilisateur a voulou ajouter un produit au panier

    $gotProduct = false;
    foreach ($_SESSION[SESSION_NAME]['panier'] as $key => $data_produit) {
        if($_SESSION[SESSION_NAME]['panier'][$key]['id_produit'] == $_GET['add_id_produit']) {
            $_SESSION[SESSION_NAME]['panier'][$key]['qte'] = $_SESSION[SESSION_NAME]['panier'][$key]['qte'] + 1;
            $gotProduct = true;
        }
    }

    if(!$gotProduct) {
        $data_produit = array(
            'id_produit' => $_GET['add_id_produit'],
            'qte' => 1
        );
        $_SESSION[SESSION_NAME]['panier'][] = $data_produit;
    }

    header('Location: index.php?page=fo_home');
}

$sql  = " SELECT ";
$sql .= "    p.id AS id_produit, ";
$sql .= "    pt.titre AS titre, ";
$sql .= "    pt.description_courte AS description, ";
$sql .= "    (p.prixHT + (p.prixHT / 100 * t.value)) AS prixTTC, ";
$sql .= "    pr.reduction AS reduction,";
$sql .= "    GROUP_CONCAT(pi.nom_fichier SEPARATOR '#') AS fichier_image, ";
$sql .= "    (SELECT SUM(qte) FROM t_produit_stock WHERE fk_produit=p.id) AS qte ";
$sql .= "  FROM ";
$sql .= "    t_produit p ";
$sql .= "    LEFT JOIN t_produit_trad pt ON pt.fk_produit=p.id ";
$sql .= "    LEFT JOIN t_produit_image pi ON pi.fk_produit=p.id ";
$sql .= "    LEFT JOIN t_promotion pr ON pr.id=p.fk_promotion ";
$sql .= "    LEFT JOIN t_tva t ON t.id=p.fk_tva ";
$sql .= "    LEFT JOIN t_produit_rayon pra ON pra.fk_produit=p.id ";
$sql .= "  WHERE pt.fk_langue=".$_SESSION[SESSION_NAME]['id_langue'];


if(isset($_GET['id_rayon'])) {
    $sql .= " AND pra.fk_rayon=".$_GET['id_rayon'];
}

$sql .= "  GROUP BY p.id ";
$datas_produit = $bdd->getData($sql);

$html = '<div class="main_shop">';
$html.= '   <div class="header_shop">';
$html.= '       <div class="recherche_rayon">';
$html.= '           Nos Rayons : <br/>';

$sql = "SELECT r.id, rt.nom FROM t_rayon r LEFT JOIN t_rayon_trad rt ON rt.fk_rayon=r.id WHERE rt.fk_langue=".$_SESSION[SESSION_NAME]['id_langue'];
$datas_rayon = $bdd->getData($sql);
$link = array();
$link[] = '<a href="index.php?page=fo_home">Tous</a>';
if($datas_rayon) {
    foreach ($datas_rayon as $data_rayon) {
        $link[] = '<a href="index.php?page=fo_home&id_rayon='.$data_rayon['id'].'">'.$data_rayon['nom'].'</a>';
    }
}
$html.= '           '.implode(' / ',$link);
$html.= '       </div>';
$html.= '   </div>';

$html.= '   <div class="listing_shop" id="listing_shop">';






// Gestion affichage des vignettes pour les produits
if($datas_produit) {
    foreach($datas_produit as $data_produit) {
        $html.= '<div class="one_product">';

        // Gestion image produit
        if(!empty($data_produit['fichier_image'])) {
            // On a une ou plusieurs images.. (au hazard si plusieurs)
            $tab_image = explode('#', $data_produit['fichier_image']);
            // Si on veut de l'aléatoire, on peut melanger le tableau avant...
            // shuffle($tab_image);
            $image = 'images/produit/' . $tab_image[0];
        } else {
            // image par defaut => le produit n'a pas d'image...
            $image = 'images/interface/default_product.png';
        }
        $html.= '   <div class="product_image">';
        $html.= '       <img src="'.$image.'" alt="'.$data_produit['titre'].'" />';
        $html.= '   </div>';
        $html.= '   <div class="product_information">';
        $html.= '       <div class="product_link">';
        $html.= '           <a href="index.php?page=fo_produit&id_produit='.$data_produit['id_produit'].'">';
        $html.= '               Voir le produit';
        $html.= '           </a>';
        $html.= '       </div>';
        $html.= '       <div class="product_link_add_cart" '.(($data_produit['qte']>0)? '' : ' style="visibility: hidden;" ' ).'>';
        $html.= '           <a href="index.php?page=fo_home&add_id_produit='.$data_produit['id_produit'].'">';
        $html.= '               <img src="images/interface/cart.png" />';
        $html.= '           </a>';
        $html.= '       </div>';
        $html.= '       <div class="product_title">';
        $html.= '           '.$data_produit['titre'];

        // Lien direct vers edition du produit (uniquement si Administrateur. cf nouveau champs dans la table t_user)
        if($_SESSION[SESSION_NAME]['isAdmin']) {
            $html.= '<a href="index.php?page=manage_produit&id_produit='.$data_produit['id_produit'].'">';
            $html.= '    <img src="images/interface/edit.png" />';
            $html.= '</a>';
        }

        $html.= '       </div>';
        $html.= '       <div class="product_description">';
        $html.= '           '.substr($data_produit['description'],0,50).'...';
        $html.= '       </div>';

        if($data_produit['reduction']>0) {
            $html .= '       <div class="product_price">';
            $html .= '           '.number_format($data_produit['prixTTC'] - ($data_produit['prixTTC'] / 100 * $data_produit['reduction']),2).' €';
            $html .= '           <span>' . number_format($data_produit['prixTTC'], 2) . ' € </span>';
            $html .= '       </div>';
        } else {
            $html .= '       <div class="product_price">';
            $html .= '           ' . number_format($data_produit['prixTTC'], 2) . ' €';
            $html .= '       </div>';
        }
        if($data_produit['qte']>0) {
            $html .= '       <div class="product_dispo_ok">';
            $html .= '           Produit Disponible en stock';
            $html .= '       </div>';
        } else {
            $html .= '       <div class="product_dispo_ko">';
            $html .= '           Produit indisponible';
            $html .= '       </div>';
        }


        $html.= '   </div>';
        $html.= '</div>';
    }
}

$html.= '   </div>';
$html.= '</div>';