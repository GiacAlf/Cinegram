<?php

class VMembers {

    private Smarty $smarty;

    //il costruttore della page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo per creare la pagina dei members: per forza di cose qua credo che sia necessario
    //chiedere le statistiche ai Controller direttamente nel metodo
    //La pagina cambia a seconda se si è registrati o meno
    public function avviaPaginaMembers(array $recensioni, array $utenti, array $immagini_utenti,
                                       array $film_visti, array $locandine_film_visti, array $utenti_piu_seguiti,
                                       array $immagini_utenti_piu_seguiti, bool $identificato): void{
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('identificato', $identificato);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->assign('utenti_popolari', $utenti);
        $this->smarty->assign('immagini_utenti_popolari', $immagini_utenti);
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->assign('utenti_seguiti', $utenti_piu_seguiti);
        $this->smarty->assign('immagini_utenti_seguiti', $immagini_utenti_piu_seguiti);
        $this->smarty->display('members.tpl');
    }

}