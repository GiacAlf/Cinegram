<?php
require_once("Smarty/Smarty.class.php");

class StartSmarty extends Smarty {

    public static function configuration(): Smarty {

        $smarty = new Smarty();
        $smarty->setTemplateDir("Smarty/templates/");
        $smarty->setCompileDir( "Smarty/templates_c/");
        $smarty->setCacheDir( "Smarty/cache/");
        $smarty->setConfigDir( "Smarty/configs/");
        return $smarty;
    }
}