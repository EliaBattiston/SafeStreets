<?php
    function executePHP($file){
        ob_start();
        require($file);
        return ob_get_clean();
    }
?>