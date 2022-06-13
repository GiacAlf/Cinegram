<?php
require('Smarty/Smarty.class.php');

class StartSmarty extends Smarty {
    static function configuration(){
        $smarty=new Smarty();
        $smarty->setTemplateDir('Smarty/templates/');
        $smarty->setCompileDir('Smarty/templates_c/');
        $smarty->setCacheDir('Smarty/cache/');
        $smarty->setConfigDir('Smarty/configs/');
        return $smarty;
    }
}

