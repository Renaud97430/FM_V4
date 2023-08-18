<?php
    require('inc/param.php');
    require('inc/route.php');
    require('class/data.class.php');
    require('class/page.class.php');




    function dbug($var=''){
        if(is_object($var)){
            echo '<pre style="color:#FF0000">';
            var_dump($var);
            echo '</pre>';
            return '';
        }
        if(is_array($var)){

            // print_r no screen flush
            ob_start();
                echo '<pre>';
                print_r($var);
                echo '</pre>';
                $dbug=ob_get_contents();
            ob_end_clean();

            $dbug='<div class="debug"><span ondblclick="this.parentElement.remove();">[ DEBUG ]</span><div>'.$dbug.'&nbsp;</div></div>';
            echo $dbug;
        }elseif($var===false){
            echo '<div class="debug"><span ondblclick="this.parentElement.remove();"span>[ DEBUG ]</span><div>FALSE&nbsp;</div></div>';
        }else{
            $dbug='<div class="debug"><span ondblclick="this.parentElement.remove();"span>[ DEBUG ]</span><div>'.$var.'&nbsp;</div></div>';
            echo $dbug;
        }
    }

?>