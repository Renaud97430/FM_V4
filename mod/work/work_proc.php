<?php
   $bdd = new Data();
   if(isset($_GET['add_id_produit']) && !empty($_GET['add_id_produit'])) {
      // L'utilisateur a voulou ajouter un produit au panier

      $gotProduct = false;
      for($i = 0; $i < count($_SESSION[SESSION_NAME]['panier']); $i++) {
         if($_SESSION[SESSION_NAME]['panier'][$i]['id_produit'] == $_GET['add_id_produit']) {
            $_SESSION[SESSION_NAME]['panier'][$i]['qte'] = $_SESSION[SESSION_NAME]['panier'][$i]['qte'] + 1;
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

      header('Location: index.php?page=work');
   }
    // Image du Jour
   $html='<a href="index.php?page=work&add_id_produit=2">Ajouter au Panier</a>';


   $total_price = 0;
   $html .= '<br/>Listing Panier<br/>';
   if(!empty($_SESSION[SESSION_NAME]['panier'])) {
      foreach ($_SESSION[SESSION_NAME]['panier'] as $data_product) {
         $html .= '<ul>';
         $sql = "SELECT titre FROM t_produit_trad WHERE fk_produit=".$data_product['id_produit']." AND fk_langue=".$_SESSION[SESSION_NAME]['id_langue'];
         $html .= '  <li>'.$bdd->squery($sql).' - Quantité : '.$data_product['qte'].'</li>';
         $html .= '</ul>';
         $total_price += ( $bdd->squery("SELECT prixHT FROM t_produit WHERE id=".$data_product['id_produit']) * $data_product['qte']);
      }
      $html .= '<br/>Prix Total de la commande : '.$total_price. ' €';
   }


   dbug($_SESSION[SESSION_NAME]['panier']);
?>
