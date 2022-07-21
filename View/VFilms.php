<?php

/**
 *Classe adibita a gestire e a mostrare la pagina dell'applicazione
 * nota come Films
 */
class VFilms {
    /**
     * L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;

    //il costruttore della page richiama l'oggetto smarty configurato
    //e se lo salva
    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //l'unica cosa che non ho capitp (unica si fa per dire) è come mettere e
    //lavorare con le finestrelle che vediamo nel layout che abbiamo pensato

    //metodo per creare la pagina dei films: per forza di cose qua credo che sia necessario
    //chiedere le statistiche ai Controller direttamente nel metodo
    //La pagina cambia a seconda se si è registrati o meno
    /**
     * Metodo che fa visualizzare una pagina in cui l'utente può vedere diverse tipologie
     * di film, scelti per data d'uscita o per votazione media
     * @param array $film_voto_medio
     * @param array $locandine_film_voto
     * @param array $utenti_seguiti
     * @param array $immagini_seguiti
     * @param array $film_recenti
     * @param array $locandine_film_recenti
     * @param array $recensioni
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaFilms(array $film_voto_medio, array $locandine_film_voto, array $utenti_seguiti,
                                     array $immagini_seguiti, array $film_recenti, array $locandine_film_recenti,
                                     array $recensioni): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('film_voto_medio', $film_voto_medio);
        $this->smarty->assign('locandine_voto_medio', $locandine_film_voto);
        $this->smarty->assign('utenti_seguiti', $utenti_seguiti);
        $this->smarty->assign('immagini_utenti_seguiti', $immagini_seguiti);
        $this->smarty->assign('film_recenti', $film_recenti);
        $this->smarty->assign('locandine_film_recenti', $locandine_film_recenti);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->display('films.tpl');
    }
}