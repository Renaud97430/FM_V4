<?php
    $bdd = new Data();

    if (isset($_POST) && !empty($_POST)) {
        // On revient d'un formulaire

        // Préparation des informations récuperées du formulaire
        $h = array();
        $h['nom'] = $_POST['form_nom'];
        $h['isActif'] = (isset($_POST['form_isActif']))?1:0;

        // Test pour savoir si on ajoute ou on modifie
        if ($_POST['id_stock'] > 0) {
            // Update de BDD
            $id_stock = $_POST['id_stock'];
            $bdd->sql_update('t_stock', $id_stock, $h);
        } else {
            // Ajout en BDD
            $id_stock = $bdd->sql_insert('t_stock', $h);
        }

        // Redirection
        header('Location: index.php?page=manage_stock&id_stock=' . $id_stock);
    }

    // Vérification pour Ajout / Modification
    if (isset($_GET['id_stock']) && !empty($_GET['id_stock'])) {
        // Modification
        $id_stock = $_GET['id_stock'];
        $data_stock = $bdd->build_r_from_id('t_stock', $id_stock);
    } else {
        // On est en Creation
        $id_stock = 0;
        $data_stock = array();
        $data_stock['nom'] = '';
        $data_stock['isActif'] = 1;
    }


    // Mise en forme du formulaire
    $html = '   <div class="form-style">';

    // Gestion du Titre de la page (Modification ou Ajout)
    if ($id_stock > 0) {
        $html .= '       <h1>Modification Stock<span>Modifier un stock...</span></h1>';
    } else {
        $html .= '       <h1>Ajout Stock<span>Ajouter un stock...</span></h1>';
    }

    // Debut du Formulaire HTML
    $html .= '       <form method="POST" action="index.php?page=manage_stock" enctype="multipart/form-data">';

    // Nom et Prénom
    $html .= '           <div class="section"><span>1</span>Nom</div>';
    $html .= '           <div class="inner-wrap-l">';
    $html .= '               <label>Nom <input type="text" name="form_nom" value="' . $data_stock['nom'] . '"/></label>';
    $html .= '           </div>';
    $html .= '           <div class="inner-wrap-r">';
    if($data_stock['isActif'])
        $html .= '               <label>Actif ? <input type="checkbox"  name="form_isActif" value="1" checked="checked"/></label>';
    else
        $html .= '               <label>Actif ? <input type="checkbox"  name="form_isActif" value="1" /></label>';
    $html .= '           </div>';
    $html .= '           <div style="clear:both;"></div>';

    // Bouton Enregistrer
    $html .= '           <div class="button-section">';
    $html .= '               <input type="submit" value="Enregistrer" />';
    $html .= '           </div>';

    // Champs caché...
    $html .= '           <input type="hidden" name="id_stock" id="id_stock" value="' . $id_stock . '" />';

    $html .= '       </form>';
    $html .= '   </div>';
?>