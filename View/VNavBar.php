<?php
//TODO: Da modificare nel nostro caso d'uso
class VNavBar
{
    private Smarty $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Metodo che consente di visualizzare l'homepage
     * @throws SmartyException
     */
    public function showHome() {
        $user = $this->navbar();
        $this->smarty->assign('user', $user);
        $this->smarty->display('home.tpl');
    }

    /**
     * Metodo che consente di visualizzare la navbar in base al tipo di utente
     * @return string
     */
    public function navbar(): string
    {
        if (SessionHelper::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($utente->getAdmin()){
                $user = "admin";
            } else {
                $user = $utente->getUsername();
            }
        } else {
            $user = "nouser";
        }
        return $user;
    }


}