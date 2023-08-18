<?php
$bdd = new Data();

if (isset($_POST) && !empty($_POST)) {
    // On revient d'un formulaire

    // Préparation des informations récuperées du formulaire
    $h = array();
    $h['nom_tva'] = $_POST['form_nom_tva'];
    $h['value'] = $_POST['form_value'];

    // Test pour savoir si on ajoute ou on modifie
    if ($_POST['id_tva'] > 0) {
        // Update de BDD
        $id_tva = $_POST['id_tva'];
        $bdd->sql_update('t_tva', $id_tva, $h);
    } else {
        // Ajout en BDD
        $id_tva = $bdd->sql_insert('t_tva', $h);
    }

    // Redirection
    header('Location: index.php?page=manage_tva&id_tva=' . $id_tva);
}

// Vérification pour Ajout / Modification
if (isset($_GET['id_tva']) && !empty($_GET['id_tva'])) {
    // Modification
    $id_tva = $_GET['id_tva'];
    $data_tva = $bdd->build_r_from_id('t_tva', $id_tva);
} else {
    // On est en Creation
    $id_tva = 0;
    $data_tva = array();
    $data_tva['nom_tva'] = '';
    $data_tva['value'] = 0.0;
}


// Mise en forme du formulaire
$html = '   <div class="form-style">';

// Gestion du Titre de la page (Modification ou Ajout)
if ($id_tva > 0) {
    $html .= '       <h1>Modification TVA<span>Modifier une TVA...</span></h1>';
} else {
    $html .= '       <h1>Ajout TVA<span>Ajouter une TVA...</span></h1>';
}

// Debut du Formulaire HTML
$html .= '       <form method="POST" action="index.php?page=manage_tva" enctype="multipart/form-data">';

// Nom et Prénom
$html .= '           <div class="section"><span>1</span>Nom</div>';
$html .= '           <div class="inner-wrap-l">';
$html .= '               <label>Nom <input type="text" name="form_nom_tva" value="' . $data_tva['nom_tva'] . '"/></label>';
$html .= '           </div>';
$html .= '           <div class="inner-wrap-r">';
$html .= '               <label>Valeur <input type="number" step=".01" name="form_value" value="' . $data_tva['value'] . '"/></label>';
$html .= '           </div>';
$html .= '           <div style="clear:both;"></div>';

// Bouton Enregistrer
$html .= '           <div class="button-section">';
$html .= '               <input type="submit" value="Enregistrer" />';
$html .= '           </div>';

// Champs caché...
$html .= '           <input type="hidden" name="id_tva" id="id_tva" value="' . $id_tva . '" />';

$html .= '       </form>';
$html .= '   </div>';
?>