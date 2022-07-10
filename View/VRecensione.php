<?php

/**
 *Classe adibita a gestire l'input e l'output delle attività dell'utente
 * inerenti alle recensioni
 */
class VRecensione {

    /**
     *L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;


    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    /**
     * Metodo che fa visualizzare la pagina della recensione selezionata
     * @param ERecensione $recensione
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaRecensione(ERecensione $recensione): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'recensione', $recensione);
        $this->smarty->assign( 'risposte', $recensione->getRisposteDellaRecensione());
        $this->smarty->display('recensione.tpl');
    }


    /**
     * Metodo che fa visualizzare la pagina per modificare la recensione selezionata
     * @param ERecensione $recensione
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaModificaRecensione(ERecensione $recensione): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'recensione', $recensione);
        $this->smarty->display('modifica_recensione.tpl');
    }


    /**
     * Metodo che fa visualizzare la pagina per modificare la risposta selezionata
     * @param ERisposta $risposta
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaModificaRisposta(ERisposta $risposta): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'risposta', $risposta);
        $this->smarty->display('modifica_risposta.tpl');
    }


    /**
     * Metodo che recupera il testo della risposta a una recensione
     * scritta dall'utente
     * @return string|null
     */
    public function scriviRisposta(): ?string {

        $testo_risposta = null;
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        return $testo_risposta;
    }


    /**
     * Metodo che recupera tutte le info necessarie scritte dall'utente
     * per poter modificare una recensione
     * @return array|null
     */
    public function modificaRecensione(): ?array {

        $array_recensione = array();
        $nuovo_testo_recensione = null;
        $nuovo_voto_recensione = null;
        if(isset($_POST['nuovo_testo'])) {
            $nuovo_testo_recensione = $_POST['nuovo_testo'];
        }
        if(isset($_POST['nuovo_voto'])) {
            $nuovo_voto_recensione = $_POST['nuovo_voto'];
        }
        //se non è settato ne il voto ne il testo vaffanculo -> oppure dall'html lo fa
        $array_recensione[] = $nuovo_testo_recensione;
        $array_recensione[] = $nuovo_voto_recensione;
        return $array_recensione;
    }


    /**
     * Metodo che recupera tutte le info necessarie scritte dall'utente
     * per poter modificare una risposta
     * @return string|null
     */
    public function modificaRisposta(): ?string {

        $nuovo_testo_risposta = null;
        if(isset($_POST['nuova_risposta'])){
            $nuovo_testo_risposta = $_POST['nuova_risposta'];
        }
        return $nuovo_testo_risposta;
    }
}