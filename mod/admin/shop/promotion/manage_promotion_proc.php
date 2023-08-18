<?php
    $bdd = new Data();

    if(isset($_POST) && !empty($_POST)){
        // On revient d'un formulaire

        // Préparation des informations récuperées du formulaire
        $h = array();
        $h['reduction'] = $_POST['form_reduction'];
        $h['isActif'] = (isset($_POST['form_isActif'])?1:0);

        // Test pour savoir si on ajoute ou on modifie
        if($_POST['id_promotion'] > 0){
            // Update de BDD
            $id_promotion = $_POST['id_promotion'];
            $bdd->sql_update('t_promotion',$id_promotion, $h);
        }else{
            // Ajout en BDD
            $id_promotion = $bdd->sql_insert('t_promotion',$h);
        }

        // Gestion Traduction
        $sql = "DELETE FROM t_promotion_trad WHERE fk_promotion=".$id_promotion;
        $bdd->query($sql);

        $sql = "SELECT * FROM t_langue";
        $datas_langue = $bdd->getData($sql);
        foreach($datas_langue as $data_langue) {
            $h = array();
            $h['fk_promotion'] = $id_promotion;
            $h['fk_langue'] = $data_langue['id'];
            $h['nom'] = $_POST['form_nom_'.$data_langue['id']];
            $bdd->sql_insert('t_promotion_trad',$h);
        }

        // Redirection
        header('Location: index.php?page=manage_promotion&id_promotion='.$id_promotion);
    }

    // Vérification pour Ajout / Modification
    if (isset($_GET['id_promotion']) && !empty($_GET['id_promotion'])) {
        // Modification
        $id_promotion = $_GET['id_promotion'];
        $data_promotion = $bdd->build_r_from_id('t_promotion',$id_promotion);
    }else{
        // On est en Creation
        $id_promotion = 0;
        $data_promotion = array();
        $data_promotion['reduction'] = 0;
        $data_promotion['isActif'] = 1;
    }

    // Mise en forme du formulaire
    $html = '   <div class="form-style">';

    // Gestion du Titre de la page (Modification ou Ajout)
    if($id_promotion > 0){
        $html .= '       <h1>Modification Promotion<span>Modifier une promotion...</span></h1>';
    }else{
        $html .= '       <h1>Ajout Promotion<span>Ajouter une promotion...</span></h1>';
    }

    // Debut du Formulaire HTML
    $html.= '       <form method="POST" action="index.php?page=manage_promotion" enctype="multipart/form-data">';

    // Nom, Code et %
    $html.= '           <div class="section"><span>1</span>Information Promotion</div>';
    $html.= '           <div class="inner-wrap-l">';
    $sql = "SELECT * FROM t_langue";
    $datas_langue = $bdd->getData($sql);
    foreach($datas_langue as $data_langue) {
        $sql = "SELECT nom FROM t_promotion_trad WHERE fk_promotion=".$id_promotion." AND fk_langue=".$data_langue['id'];
        $trad = $bdd->squery($sql);
        $html.= '               <label>Code de la Promotion ('.$data_langue['nom'].') <input type="text" name="form_nom_'.$data_langue['id'].'" value="'.$trad.'"/></label>';
    }
    $html.= '           </div>';

    $html.= '           <div class="inner-wrap-r">';
    $html.= '               <label>Reduction (%) <input type="number" step=".01" name="form_reduction" value="'.$data_promotion['reduction'].'"/></label>';
    if($data_promotion['isActif'])
        $html .= '               <label>Actif ? <input type="checkbox"  name="form_isActif" value="1" checked="checked"/></label>';
    else
        $html .= '               <label>Actif ? <input type="checkbox"  name="form_isActif" value="1" /></label>';

    $html.= '           </div>';
    $html.= '           <div style="clear:both;"></div>';

    // Bouton Enregistrer
    $html.= '           <div class="button-section">';
    $html.= '               <input type="submit" value="Enregistrer" />';
    $html.= '           </div>';

    // Champs caché...
    $html.= '           <input type="hidden" name="id_promotion" id="id_promotion" value="'.$id_promotion.'" />';

    $html.= '       </form>';
    $html.= '   </div>';
?>