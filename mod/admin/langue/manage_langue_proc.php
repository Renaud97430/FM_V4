<?php
    $bdd = new Data();

    if(isset($_POST) && !empty($_POST)){
        // On revient d'un formulaire

        // Préparation des informations récuperées du formulaire
        $h = array();
        $h['nom'] = $_POST['form_nom'];

        // Test pour savoir si on ajoute ou on modifie
        if($_POST['id_langue'] > 0){
            // Update de BDD
            $id_langue = $_POST['id_langue'];
            $bdd->sql_update('t_langue',$id_langue, $h);
        }else{
            // Ajout en BDD
            $id_langue = $bdd->sql_insert('t_langue',$h);
        }

        // Redirection
        header('Location: index.php?page=manage_langue&id_langue='.$id_langue);
    }

    // Vérification pour Ajout / Modification
    if (isset($_GET['id_langue']) && !empty($_GET['id_langue'])) {
        // Modification
        $id_langue = $_GET['id_langue'];
        $data_langue = $bdd->build_r_from_id('t_langue',$id_langue);
    }else{
        // On est en Creation
        $id_langue = 0;
        $data_langue = array();
        $data_langue['nom'] = '';
    }


    // Mise en forme du formulaire
    $html = '   <div class="form-style">';

    // Gestion du Titre de la page (Modification ou Ajout)
    if($id_langue > 0){
        $html .= '       <h1>Modification Langue<span>Modifier une Langue...</span></h1>';
    }else{
        $html .= '       <h1>Ajout Langue<span>Ajouter une Langue...</span></h1>';
    }

    // Debut du Formulaire HTML
    $html.= '       <form method="POST" action="index.php?page=manage_langue" enctype="multipart/form-data">';

    // Nom et Prénom
    $html.= '           <div class="section"><span>1</span>Nom de la langue</div>';
    $html.= '           <div class="inner-wrap">';
    $html.= '               <label>Nom <input type="text" name="form_nom" value="'.$data_langue['nom'].'"/></label>';
    $html.= '           </div>';
    $html.= '           <div style="clear:both;"></div>';

    // Bouton Enregistrer
    $html.= '           <div class="button-section">';
    $html.= '               <input type="submit" value="Enregistrer" />';
    $html.= '           </div>';

    // Champs caché...
    $html.= '           <input type="hidden" name="id_langue" id="id_langue" value="'.$id_langue.'" />';

    $html.= '       </form>';
    $html.= '   </div>';
?>