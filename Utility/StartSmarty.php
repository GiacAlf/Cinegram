<?php
require_once("Smarty/Smarty.class.php");

/**
 * Classe adibita a restituire un oggetto smarty
 * configurato correttamente
 */
class StartSmarty extends Smarty {

    /**
     * Metodo che restituisce l'oggetto smarty configurato
     * a seguito dell'assegnazione corretta delle cartelle di Smarty
     * @return Smarty
     */
    public static function configuration(): Smarty {

        $smarty = new Smarty();
        $smarty->setTemplateDir("Smarty/templates/");
        $smarty->setCompileDir( "Smarty/templates_c/");
        $smarty->setCacheDir( "Smarty/cache/");
        $smarty->setConfigDir( "Smarty/configs/");
        return $smarty;
    }
}