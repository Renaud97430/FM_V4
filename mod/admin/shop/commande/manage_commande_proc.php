<?php
   $bdd = new Data();

   if(isset($_POST) && !empty($_POST)) {
      // Update statut Commande
      $id_commande = $_POST['id_commande'];

      $h = array();
      $h['fk_statut'] = $_POST['id_statut'];
      $bdd->sql_update('t_commande',$id_commande, $h);

      header('Location: index.php?page=manage_commande&id_commande='.$id_commande);
      exit();
   }

   if(isset($_GET['id_commande']) && !empty($_GET['id_commande'])) {
      $id_commande = $_GET['id_commande'];
   } else {
      // Pas d'ID => Soucis
      header('Location: index.php?page=listing_commande');
      exit();
   }

   $sql = "SELECT ";
   $sql.= " cp.qte AS qte, ";
   $sql.= " cp.fk_produit AS id_produit, ";
   $sql.= " c.fk_statut AS id_statut, ";
   $sql.= " c.n_commande AS n_commande ";
   $sql.= " FROM t_commande c ";
   $sql.= " LEFT JOIN t_commande_produit cp ON cp.fk_commande=c.id ";
   $sql.= " WHERE c.id=".$id_commande;
   $datas_commande = $bdd->getData($sql);

   $n_commande = $datas_commande[0]['n_commande'];
   $statut_commande = $datas_commande[0]['id_statut'];

   $total_price_ht = 0;
   $total_price_ttc = 0;
   $total_promo = 0;
   $html = '<div class="titre_panier">Commande n° '.$n_commande.'</div>';

   $html .= '<div style="width:70%; margin: auto;">';
   $html .= '    <table style="width:100%;margin:auto;padding:20px;" cellspacing="0" cellpadding="0">';

   $html .= '        <tr class="tab_header">';
   $html .= '            <td class="tab_td" style="width: 52%;">Produit</td>';
   $html .= '            <td class="tab_td" style="width: 12%;">Prix HT</td>';
   $html .= '            <td class="tab_td" style="width: 12%;">Prix TTC</td>';
   $html .= '            <td class="tab_td" style="width: 12%;">Quantité</td>';
   $html .= '            <td class="tab_td" style="width: 12%;">Sous total</td>';
   $html .= '        </tr>';

   $i = 0;
   if($datas_commande){
      foreach ($datas_commande as $data_produit_cart) {
         $image = $bdd->squery("SELECT nom_fichier FROM t_produit_image WHERE fk_produit=" . $data_produit_cart['id_produit'] . " LIMIT 1");
         $sql = "SELECT * FROM t_produit WHERE id=" . $data_produit_cart['id_produit'];
         $data_produit = $bdd->getData($sql);
         $data_produit = $data_produit[0];

         $tva = $bdd->squery("SELECT value FROM t_tva WHERE id=" . $data_produit['fk_tva']);
         $sql = "SELECT titre FROM t_produit_trad WHERE fk_produit=" . $data_produit_cart['id_produit'] . " AND fk_langue=" . $_SESSION[SESSION_NAME]['id_langue'];
         $nom = $bdd->squery($sql);

         if ($data_produit['fk_promotion']) {
            $reduction = $bdd->squery("SELECT pr.reduction AS reduction FROM t_produit p LEFT JOIN t_promotion pr ON pr.id=p.fk_promotion WHERE p.id=" . $data_produit_cart['id_produit']);
            $total_promo += (($data_produit['prixHT'] * $reduction / 100) * $data_produit_cart['qte']);
            $prixHT = $data_produit['prixHT'] - ($data_produit['prixHT'] * $reduction / 100);
            $prixTTC = $prixHT + ($prixHT * $tva / 100);
         } else {
            $prixHT = $data_produit['prixHT'];
            $prixTTC = $data_produit['prixHT'] + ($prixHT * $tva / 100);
         }

         // Gestion Total (prix)
         $total_price_ht += $prixHT * $data_produit_cart['qte'];
         $total_price_ttc += $prixTTC * $data_produit_cart['qte'];

         $html .= '        <tr ' . (($i++ % 2) ? 'class="tab_row_1"' : 'class="tab_row_2"') . '>';
         $html .= '            <td>';
         $html .= '                <img src="images/produit/' . $image . '" style="width:64px; height: 64ox; margin: 10px; vertical-align: middle;" />&nbsp;&nbsp;' . $nom;
         if ($data_produit['fk_promotion']) {
            ///$reduction
            $html .= '                <span class="zone_information_panier_product_price_promo">&nbsp;Promo&nbsp;&nbsp; -' . ceil($reduction) . ' %</span>';
         }

         $html .= '            </td>';
         $html .= '            <td>' . number_format($prixHT, 2) . ' €</td>';
         $html .= '            <td>' . number_format($prixTTC, 2) . ' €</td>';
         $html .= '            <td>' . $data_produit_cart['qte'] . '</td>';
         $html .= '            <td>' . number_format(($prixTTC * $data_produit_cart['qte']), 2) . ' €</td>';
         $html .= '        </tr>';
      }
      $html .= '    </table>';

      // Gestion du Statut
      $html.= '<div style="width: 45%; float: left;">';
      $html.= '    <form method="POST" action="index.php?page=manage_commande" enctype="multipart/form-data">';
      $html.= '        <div class="button-submit" style="text-align: center;">';
      $html.= '            <label> Statut de la Commande ';
      $html.= '                <select name="id_statut">';

      $sql = "SELECT sc.id AS id_statut, sct.nom AS label ";
      $sql.= " FROM t_statut_commande sc ";
      $sql.= " LEFT JOIN t_statut_commande_trad sct ON sct.fk_statut_commande=sc.id AND sct.fk_langue=".$_SESSION[SESSION_NAME]['id_langue'];
      $sql.= " ORDER BY id_statut ASC ";

      $datas_statut = $bdd->getData($sql);
      if($datas_statut) {
         foreach ($datas_statut as $data_statut) {
            $html.= '<option value="'.$data_statut['id_statut'].'" '.(($data_statut['id_statut'] == $statut_commande)?' selected="selected" ':'').'>'.$data_statut['label'].'</option>';
         }
      }
      $html.= '                </select>';
      $html.= '            </label><br/><br/>';
      $html.= '            <input type="submit" value="Modifier le Statut" />';
      $html.= '            <input type="hidden" name="id_commande" id="id_commande" value="'.$id_commande.'" />';
      $html.= '        </div>';
      $html.= '    </form>';
      $html.= '</div>';


      // Gestion tableau Total
      $html .= '<table style="width:45%;margin-right: 0px;margin-left:calc(60% - 84px);padding:20px;border-collapse: collapse;" cellspacing="0" cellpadding="0" >';
      $html .= '    <tr>';
      $html .= '        <td class="tab_header panier_total"> Total HT </td>';
      $html .= '        <td class="panier_info_total"> ' . number_format($total_price_ht, 2) . ' €</td>';
      $html .= '    </tr>';
      $html .= '    <tr>';
      $html .= '        <td class="tab_header panier_total"> Total TTC </td>';
      $html .= '        <td class="panier_info_total"> ' . number_format($total_price_ttc, 2) . ' €</td>';
      $html .= '    </tr>';
      $html .= '    <tr>';
      $html .= '        <td class="tab_header panier_total"> Total A Payer  </td>';
      $html .= '        <td class="panier_info_total"><span> ' . number_format($total_price_ttc, 2) . ' €</span></td>';
      $html .= '    </tr>';
      if ($total_promo) {
         $html .= '    <tr>';
         $html .= '        <td colspan="2" class="info_promo_panier"> Le Client a économiser ' . number_format($total_promo, 2) . ' € sur sa Commande !</td>';
         $html .= '    </tr>';
      }
      $html .= '</table>';


      $html .= '</div>';

   }
?>
