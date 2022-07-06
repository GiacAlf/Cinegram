<?php

class VFilms {

    private Smarty $smarty;

    //il costruttore della page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //l'unica cosa che non ho capitp (unica si fa per dire) è come mettere e
    //lavorare con le finestrelle che vediamo nel layout che abbiamo pensato

    //metodo per creare la pagina dei films: per forza di cose qua credo che sia necessario
    //chiedere le statistiche ai Controller direttamente nel metodo
    //La pagina cambia a seconda se si è registrati o meno
    public function avviaPaginaFilms(array $film_visti, array $locandine_film_visti, array $utenti_seguiti,
                                     array $immagini_seguiti, array $film_recenti, array $locandine_film_recenti,
                                     array $recensioni): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->assign('utenti_seguiti', $utenti_seguiti);
        $this->smarty->assign('immagini_utenti_seguiti', $immagini_seguiti);
        $this->smarty->assign('film_recenti', $film_recenti);
        $this->smarty->assign('locandine_film_recenti', $locandine_film_recenti);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->display('films.tpl');
    }
}