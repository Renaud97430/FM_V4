<?php
    // Image du Jour
    $bdd = new Data();
    $html = '';
    $sql = "SELECT photographie FROM t_photo";
    $datas_photo = $bdd->getData($sql);
    if($datas_photo) {
        $nb_photo = count($datas_photo);

        $html .= '<div class="title_image_jour">Image du Jour</div>';
        $html .= '<div class="image_jour">';
        $html .= '    <img src="images/' . $datas_photo[rand(0, $nb_photo - 1)]['photographie'] . '" />';
        $html .= '</div>';
    }
?>
