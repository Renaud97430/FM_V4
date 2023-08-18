<?php
    $bdd = new Data();

    // Suppression ToDo :) ?
    if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
        // Suppression du rayon
        $id_promotion = $_GET['delete_id'];

        // Suppression de la traduction
        $bdd->squery("DELETE FROM t_promotion_trad WHERE fk_promotion=".$id_promotion);

        // Suppression du rayon
        $bdd->sql_delete('t_promotion',$id_promotion);

        // Redirection vers le listing des rayon
        header("location: index.php?page=listing_promotion");
    }

    // Etape 1 : Préparation de la requete
    $sql = 'SELECT';
    $sql.= '    p.id AS id_promotion,';
    $sql.= '    pt.nom AS code_promotion,';
    $sql.= '    p.reduction AS reduction,';
    $sql.= '    p.isActif AS isActif ';
    $sql.= ' FROM t_promotion p';
    $sql.= ' LEFT JOIN t_promotion_trad pt ON pt.fk_promotion = p.id';
    $sql.= ' WHERE';
    $sql.= '    pt.fk_langue = '.$_SESSION[SESSION_NAME]['id_langue'];

    // Etape 2 : Execution de la requete sur le serveur de BDD
    $datas_promotion = $bdd->getData($sql);


    // Préparation du retour
    $html  = '   <div class="form-style">';
    $html .= '       <h1>Listing Promotions<span>Listing des Promotions de la boutique...</span></h1>';

    // Lien Ajout utilisateur
    $html .= '   <div class="new_promotion">';
    $html .= '       <a href="index.php?page=manage_promotion">';
    $html .= '           <img src="images/interface/add.png" />';
    $html .= '       </a>';
    $html .= '   </div>';

    // Première ligne du tableau
    $html .= '        <table style="width:80%;margin:auto;padding:20px;" cellspacing="0" cellpadding="0">';
    $html .= '              <tr class="tab_header">';
    $html .= '                  <td class="tab_td">ID</td>';
    $html .= '                  <td class="tab_td">Code Promotion</td>';
    $html .= '                  <td class="tab_td">Réduction (%)</td>';
    $html .= '                  <td class="tab_td">Actif</td>';
    $html .= '                  <td class="tab_td" style="width:100px;">&nbsp;</td>';
    $html .= '              </tr>';

    // Si je suis ici => Tout va bien ! la requete est correcte et il y a au moins un enregistrement
    // Etape 3 : Je parcours les enregistrements de ma requete
    $i = 0;
    if($datas_promotion) {
        foreach ($datas_promotion as $data) {
            if ($i % 2)
                $html .= '       <tr class="tab_row_1">';
            else
                $html .= '       <tr class="tab_row_2">';
            $html .= '            <td class="tab_td">' . $data['id_promotion'] . '</td>';
            $html .= '            <td class="tab_td">' . $data['code_promotion'] . '</td>';
            $html .= '            <td class="tab_td">' . $data['reduction'] . '</td>';

            if ($data['isActif'])
                $html .= '            <td class="tab_td"><img src="images/interface/actif.png" /></td>';
            else
                $html .= '            <td class="tab_td">&nbsp;</td>';

            // Actions
            $html .= '            <td class="tab_td">';
            $html .= '                <a href="index.php?page=manage_promotion&id_promotion=' . $data['id_promotion'] . '"><img src="images/interface/edit.png"></a>';
            $html .= '                <a onclick="if(window.confirm(\'Etes vous sur ?\')){ return true; }else{ return false;}" href="index.php?page=listing_promotion&delete_id=' . $data['id_promotion'] . '" > <img src="images/interface/suppr.png"> </a>';
            $html .= '            </td>';
            $html .= '        </tr>';
            $i++;
        }
    }
    $html.= '        </table>';
    $html.= '   </div>';
?>