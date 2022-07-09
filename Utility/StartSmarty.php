<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/Cinegram/Smarty/Smarty.class.php");

class StartSmarty extends Smarty {

    public static function configuration(): Smarty {

        $smarty = new Smarty();
        $smarty->setTemplateDir($_SERVER["DOCUMENT_ROOT"] . "Cinegram/Smarty/templates/");
        $smarty->setCompileDir($_SERVER["DOCUMENT_ROOT"] . "/Cinegram/Smarty/templates_c/");
        $smarty->setCacheDir($_SERVER["DOCUMENT_ROOT"] . "/Cinegram/Smarty/cache/");
        $smarty->setConfigDir($_SERVER["DOCUMENT_ROOT"] . "/Cinegram/Smarty/configs/");
        return $smarty;
    }
}