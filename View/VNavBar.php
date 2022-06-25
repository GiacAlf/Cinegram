<?php

class VNavBar
{
    private Smarty $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }


    public function showNavBar() {
        $user = $this->navbar();
        $this->smarty->assign('user', $user);
    }


    //non_loggato, admin, username -> con le diverse opzioni la nav bar presenta i corretti bottoni
    public function navbar(): string {
        if (SessionHelper::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($utente->chiSei() == "Admin"){
                $user = "admin";
            }
            else {
                $user = $utente->getUsername();
            }
        }
        else {
            $user = "non_loggato";
        }
        return $user;
    }


}