<?php
$bdd = new Data();

if (isset($_POST) && !empty($_POST)) {
    // On revient d'un formulaire

    // Préparation des informations récuperées du formulaire
    $h = array();
    $h['nom'] = $_POST['form_nom'];

    // Test pour savoir si on ajoute ou on modifie
    if ($_POST['id_pays'] > 0) {
        // Update de BDD
        $id_pays = $_POST['id_pays'];
        $bdd->sql_update('t_pays', $id_pays, $h);
    } else {
        // Ajout en BDD
        $id_pays = $bdd->sql_insert('t_pays', $h);
    }

    // Redirection
    header('Location: index.php?page=manage_pays&id_pays=' . $id_pays);
}

// Vérification pour Ajout / Modification
if (isset($_GET['id_pays']) && !empty($_GET['id_pays'])) {
    // Modification
    $id_pays = $_GET['id_pays'];
    $data_pays = $bdd->build_r_from_id('t_pays', $id_pays);
} else {
    // On est en Creation
    $id_pays = 0;
    $data_pays = array();
    $data_pays['nom'] = '';
}


// Mise en forme du formulaire
$html = '   <div class="form-style">';

// Gestion du Titre de la page (Modification ou Ajout)
if ($id_pays > 0) {
    $html .= '       <h1>Modification Pays<span>Modifier un pays...</span></h1>';
} else {
    $html .= '       <h1>Ajout Pays<span>Ajouter un pays...</span></h1>';
}

// Debut du Formulaire HTML
$html .= '       <form method="POST" action="index.php?page=manage_pays" enctype="multipart/form-data">';

// Nom et Prénom
$html .= '           <div class="section"><span>1</span>Nom</div>';
$html .= '           <div class="inner-wrap">';
$html .= '               <label>Nom <input type="text" name="form_nom" value="' . $data_pays['nom'] . '"/></label>';
$html .= '           </div>';
$html .= '           <div style="clear:both;"></div>';

// Bouton Enregistrer
$html .= '           <div class="button-section">';
$html .= '               <input type="submit" value="Enregistrer" />';
$html .= '           </div>';

// Champs caché...
$html .= '           <input type="hidden" name="id_pays" id="id_pays" value="' . $id_pays . '" />';

$html .= '       </form>';
$html .= '   </div>';
?>