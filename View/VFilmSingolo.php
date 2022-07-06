<?php

class VFilmSingolo {

    private Smarty $smarty;

    //il costruttore della pagina del film singolo richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //metodo che ci fa vedere la pagina del film singolo, prendendo
    //come parametro il film che ha selezionato l'utente
    public function avviaPaginaFilm(EFilm $film_selezionato, bool $visto, bool $ha_scritto, array $locandina, array $film_visti,
                                    array $locandine_film_visti): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('film', $film_selezionato);
        $this->smarty->assign('locandina_film', $locandina);
        $this->smarty->assign('ha_scritto', $ha_scritto);
        $this->smarty->assign('visto', $visto);
        $this->smarty->assign('attori', $film_selezionato->getListaAttori());
        $this->smarty->assign('registi', $film_selezionato->getListaRegisti());
        $this->smarty->assign('recensioni', $film_selezionato->getListaRecensioni());
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->display('film_singolo.tpl');
    }


    //metodo che restituisce al controllore il testo e il voto della recensione
    //se tutti e due sono null lo impedisce l'html
    public function scriviRecensione(): ?array {

        $array_recensione = array();
        $testo_recensione = null;
        $voto_recensione = null;
        if(isset($_POST['testo'])){
            $testo_recensione = $_POST['testo'];
        }
        if(isset($_POST['voto'])){
            $voto_recensione = $_POST['voto'];
        }
        //se non è settato ne il voto ne il testo vaffanculo -> oppure dall'html lo fa
        $array_recensione[] = $testo_recensione;
        $array_recensione[] = $voto_recensione;
        return $array_recensione;
    }
}