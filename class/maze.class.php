<?php
class Maze{
    private $width;
    private $height;
    private $size_case;
    private $nb_case_width;
    private $nb_case_height;
    private $maze = array();
    private $visited = array();
    private $direction = array(
        array('x' => 0, 'y' => -1),     // Haut
        array('x' => 1, 'y' => 0),      // Droite
        array('x' => 0, 'y' => 1),      // Bas
        array('x' => -1, 'y' => 0)      // Gauche
    );

    public function __construct($width, $height, $size_case) {
        $this->nb_case_width = round($width / $size_case);
        $this->nb_case_height = round($height / $size_case);
        $this->width = $this->nb_case_width * $size_case;
        $this->height = $this->nb_case_height * $size_case;;
        $this->size_case = $size_case;

        $this->generateMaze();
    }

    public function generateMaze() {
        // initialisation matrices
        for ($x = 0; $x < $this->nb_case_width; $x++) {
            $this->maze[$x] = array();
            $this->visited[$x] = array();
            for ($y = 0; $y < $this->nb_case_height; $y++) {
                $this->maze[$x][$y] = 0;
                $this->visited[$x][$y] = 0;
            }
        }
        $startX = rand(0, $this->nb_case_width-1);
        $startY = rand(0, $this->nb_case_height-1);
        $this->walk($startX, $startY);

        // Version moins aléatoire => on commence en haut a gauche
        // $this->walk(0,0);
    }

    public function drawMazeText() {
        $str = '<pre>'.PHP_EOL;

        // On parcourt toutes les cases et on affiche le symbole correspondant
        for($y = 0; $y < $this->nb_case_height; $y++) {
            $str_up = '+';
            $str_down = '|';
            for ($x = 0; $x < $this->nb_case_width; $x++) {
                switch ($this->maze[$x][$y]) {
                    case 0 :
                        if(!$x && !$y) $str_up.= '    +';
                        else $str_up.= '----+';
                        $str_down   .= '    |';
                        break;
                    case 1 :
                        $str_up  .= '    +';
                        $str_down.= '    |';
                        break;
                    case 2 :
                        if(!$x && !$y) $str_up.= '    +';
                        else $str_up.= '----+';
                        $str_down   .= '     ';
                        break;
                    case 3 :
                        $str_up  .= '    +';
                        $str_down.= '     ';
                        break;
                }
            }
            $str.= $str_up.PHP_EOL;
            $str.= $str_down.PHP_EOL;
        }

        // Gestion de la derniere ligne avec la sortie
        $str.= '+';
        for ($x = 0; $x < round($this->width/$this->size_case) - 1; $x++) {
            $str.= '----+';
        }
        $str.= '    +';
        $str.= PHP_EOL;
        $str.= '</pre>'.PHP_EOL;

        return $str;
    }

    public function drawMazePic($name_save='') {
        // Création de l'image et gestion des couleurs
        $im = imagecreate($this->width+1, $this->height+1);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);

        // Fond blanc avec un cadre noir tout au tour
        imagefill($im, 0, 0, $white);
        imagerectangle($im, 0, 0, $this->width, $this->height, $black);

        // On parcourt toutes les cases et on affiche le symbole correspondant
        for($x = 0; $x < $this->nb_case_width; $x++) {
            for ($y = 0; $y < $this->nb_case_height; $y++) {
                switch ($this->maze[$x][$y]) {
                    case 0 :
                        // ----+
                        //     |
                        imageline($im, $x*$this->size_case, $y*$this->size_case, $x*$this->size_case+$this->size_case, $y*$this->size_case, $black );
                        imageline($im, $x*$this->size_case+$this->size_case, $y*$this->size_case, $x*$this->size_case+$this->size_case, $y*$this->size_case+$this->size_case, $black );
                        break;
                    case 1 :
                        //     +
                        //     |
                        imageline($im, $x*$this->size_case+$this->size_case, $y*$this->size_case, $x*$this->size_case+$this->size_case, $y*$this->size_case+$this->size_case, $black );
                        break;
                    case 2 :
                        // ----+
                        //
                        imageline($im, $x*$this->size_case, $y*$this->size_case, $x*$this->size_case+$this->size_case, $y*$this->size_case, $black );
                        break;
                    case 3 :
                        //
                        //
                        break;
                }
            }
        }

        // Entrée et Sortie
        imageline($im, 0, 0, $this->size_case-1, 0, $white);
        imageline($im, $this->width-$this->size_case+1, $this->height, $this->width, $this->height, $white);

        // Gestion de la sortie
        if(!$name_save) {
            ob_start();
            imagepng($im);
            $image_data = ob_get_clean();
            $base64_image = base64_encode($image_data);
            imagedestroy($im);
            return '<img src="data:image/png;base64,'.$base64_image.'" />';
        } else {
            imagepng($im, $name_save);
            imagedestroy($im);
        }
    }

    private function walk($x, $y) {
        if ($this->visited[$x][$y] == 0) {
            $this->visited[$x][$y] = 1;
        }

        // On mélange l'ordre des directions pour ne pas avoir de labyrinthe régulier
        shuffle($this->direction);

        // On parcours toutes les directions
        foreach ($this->direction as $dir) {
            $nextX = $x + $dir['x'];
            $nextY = $y + $dir['y'];
            if ($nextX >= $this->nb_case_width or $nextY >= $this->nb_case_height or $nextX < 0 or $nextY < 0) {
                // On sort du cadre du labyrinthe => direction suivante
                continue;
            }
            if ($this->visited[$nextX][$nextY] == 1) {
                // Deja visité => direction suivante
                continue;
            }

            if ($nextX == $x) {
                // Déplacement Vertical
                if ($nextY > $y) {
                    // vers le bas => On modifie le motif de la case voisine en bas
                    $this->maze[$x][$nextY] = 1;
                } else {
                    //vers le haut
                    if ($this->maze[$x][$y] == 2) {
                        // On modifie le motif de la case en cours
                        $this->maze[$x][$y] = 3;
                    } else {
                        // On modifie le motif de la case en cours
                        $this->maze[$x][$y] = 1;
                    }
                }
            }

            if ($nextY == $y) {
                //Déplacement Horizontal
                if ($nextX > $x) {
                    //vers la droite
                    if ($this->maze[$x][$y] == 1) {
                        // On modifie le motif de la case en cours
                        $this->maze[$x][$y] = 3;
                    } else {
                        // On modifie le motif de la case en cours
                        $this->maze[$x][$y] = 2;
                    }
                } else {
                    //vers la gauche => On modifie le motif de la case voisine a gauche
                    $this->maze[$nextX][$y] = 2;
                }
            }
            // Et on recommence avec la case voisine d'une facon recursive jusqu'a la fin...
            $this->walk($nextX, $nextY);
        }
    }
}

?>