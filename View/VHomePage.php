<?php

/**
 *Classe adibita a far visualizzare la home page dell'applicazione
 */
class VHomePage {
    /**
     * L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;

    //il costruttore della home page richiama l'oggetto smarty configurato
    //e se lo salva
    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    //COME GESTISCO SE L'UTENTE è GIà LOGGATO O MENO, FACCIO COMPARIRE UN ICONCINA CON IL MEMBER? BOH
    //Provo così: metto un'etichetta là sopra con scritto LOGIN di default, se l'utente è loggato sostituisco l'etichetta
    //con il suo username sennò lascio l'etichetta di default

    //metodo per farmi comparire l'home page riempita con tutti i dati necessari -> dato che il display è un print
    //è ok il ritorno void, credo
    /**
     * Metodo che fa visualizzare l'home page dell'applicazione con alcune info: film recenti, ultime recensioni
     * film più visti e utenti più popolari
     * @param array $film_recenti
     * @param array $locandine_film_recenti
     * @param array $film_visti
     * @param array $locandine_film_visti
     * @param array $ultime_recensioni
     * @param array $utenti_popolari
     * @param array $immagini_utenti_popolari
     * @return void
     * @throws SmartyException
     */
    public function avviaHomePage(array $film_recenti, array $locandine_film_recenti, array $film_visti,
                                  array $locandine_film_visti, array $ultime_recensioni,
                                  array $utenti_popolari, array $immagini_utenti_popolari): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('film_recenti', $film_recenti);
        $this->smarty->assign('locandine_film_recenti', $locandine_film_recenti);
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->assign('recensioni', $ultime_recensioni);
        $this->smarty->assign('utenti_popolari', $utenti_popolari);
        $this->smarty->assign('immagini_utenti_popolari', $immagini_utenti_popolari);
        $this->smarty->display('home_page.tpl');
        //passo gli interi array a smarty, che poi si preoccuperà di prendere le robe che gli interessano
    }
}