<?php
    $bdd = new Data();

    $sql = "SELECT ";
    $sql.= " p.photographie AS photo,";
    $sql.= " p.titre AS titre,";
    $sql.= " p.description AS description,";
    $sql.= " CONCAT(u.prenom, ' ' , u.nom) AS utilisateur";
    $sql.= " FROM t_photo p";
    $sql.= " LEFT JOIN t_user u ON u.id=p.fk_user";

    // Verification si retour d'un formulaire
    if( isset($_POST) && !empty($_POST)){
        $sql.= " WHERE 1=1 ";

        if(!empty($_POST['titre'])){
            $sql.= " AND p.titre LIKE '%".$_POST['titre']."%'";
        }
        if(!empty($_POST['description'])){
            $sql.= " AND p.description LIKE '%".$_POST['description']."%'";
        }
        if(!empty($_POST['user'])){
            $sql.= " AND u.id =".$_POST['user'];
        }
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $user = $_POST['user'];
    } else {
        $titre = '';
        $description = '';
        $user = 0;
    }

    // Formulaire de recherche
    $html = '';
    $html.= '<form action="index.php?page=listing_photo" method="POST">';
    $html.= '   <label><input type="text" name="titre" placeholder="Titre..." '.((!empty($titre))?' value="'.$titre.'" ': ' value="" ').' /></label>';
    $html.= '   <label><input type="text" name="description" placeholder="Description..."  '.((!empty($description))?' value="'.$description.'" ': ' value="" ').'/></label>';
    $html.= '   <label>';
    $html.= '       <select name="user">';
    $html.= '           <option value="">-- Choisissez un utilisateur --</option>';
    $sql_user = "SELECT id, CONCAT(prenom, ' ', nom) AS nom FROM t_user ORDER by nom ASC;";
    $datas_user = $bdd->getData($sql_user);
    foreach($datas_user as $data_user) {
        $html.= '           <option value="'.$data_user['id'].'"';
        if($data_user['id'] == $user) {
            $html .= ' selected="selected" ';
        }
        $html.= '>'.$data_user['nom'].'</option>';
    }
    $html.= '       </select>';
    $html.= '   </label>';
    $html.= '   <label><input type="submit" value="Rechercher" /></label>';
    $html.= '</form>';

    $datas_photo = $bdd->getData($sql);
    $html.= '<div class="zone_photo">';

    // Si je suis ici => Tout va bien ! la requete est correcte et il y a au moins un enregistrement
    // Etape 3 : Je parcours les enregistrements de ma requete
    if($datas_photo) {
        foreach ($datas_photo as $data) {
            $html .= '<div class="one_image">';
            $html .= '    <img src="images/' . $data['photo'] . '" />';
            $html .= '    <div class="titre">' . $data['titre'] . '</div>';
            $html .= '    <div class="description">' . $data['description'] . '</div>';
            $html .= '    <div class="auteur">' . $data['utilisateur'] . '</div>';
            $html .= '</div>';
        }
    }
    $html.= '</div>';

?>
