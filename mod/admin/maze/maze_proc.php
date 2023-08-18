<?php
    $bdd = new Data();
    $result = '';

    if(isset($_POST) && !empty($_POST)){
        // On revient d'un formulaire
        $largeur = $_POST['form_x'];
        $hauteur = $_POST['form_y'];
        $case = $_POST['form_case'];

        require 'class/maze.class.php';
        $maze = new Maze($largeur,$hauteur , $case);

        // Mise en forme du resultat
        $result.= '<div class="zone_maze">';
        $result.= '     Labyrinthe de '.$largeur.' pixels par '.$hauteur.' pixels avec un chemin large de '.$case.' pixels<br/><br/>';
        $result.= '     '.$maze->drawMazePic();
        $result.= '</div>';
    }

    // Mise en forme du formulaire
    $html = '   <div class="form-style">';

    // Gestion du Titre de la page
    $html .= '       <h1>Labyrinthe<span>Génération d\'un labyrinthe...</span></h1>';


    // Debut du Formulaire HTML
    $html.= '       <form method="POST" action="index.php?page=maze" enctype="multipart/form-data">';

    // Nom et Prénom
    $html.= '           <div class="section"><span>1</span>Taille de l\'image et largeur du chemin</div>';
    $html.= '           <div class="inner-wrap-l">';
    $html.= '               <label>Largeur (en pixel) <input type="text" name="form_x" value="400"/></label>';
    $html.= '               <label>hauteur (en pixel) <input type="text" name="form_y" value="200"/></label>';
    $html.= '           </div>';
    $html.= '           <div class="inner-wrap-r">';
    $html.= '               <label>Largeur du Chemin (en pixel)<input type="text" name="form_case" value="10"/></label>';
    $html.= '           </div>';
    $html.= '           <div style="clear:both;"></div>';


    // Bouton Enregistrer
    $html.= '           <div class="button-section">';
    $html.= '               <input type="submit" value="Générer" />';
    $html.= '           </div>';

    $html.= '       </form>';

    // Affichage du resultat
    $html.= $result;

    $html.= '   </div>';
?>