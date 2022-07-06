<?php

class VRecensione {

    private Smarty $smarty;


    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //sembra che così funzioni, mentre se chiamo showNavBar [$navbar->showNavBar()] no, la variabile user non la prende
    public function avviaPaginaRecensione(ERecensione $recensione): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'recensione', $recensione);
        $this->smarty->assign( 'risposte', $recensione->getRisposteDellaRecensione());
        $this->smarty->display('recensione.tpl');
    }


    public function avviaPaginaModificaRecensione(ERecensione $recensione): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'recensione', $recensione);
        $this->smarty->display('modifica_recensione.tpl');
    }


    public function avviaPaginaModificaRisposta(ERisposta $risposta): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign( 'risposta', $risposta);
        $this->smarty->display('modifica_risposta.tpl');
    }


    public function scriviRisposta(): ?string {

        $testo_risposta = null;
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        return $testo_risposta;
    }


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


    public function modificaRisposta(): ?string {

        $nuovo_testo_risposta = null;
        if(isset($_POST['nuova_risposta'])){
            $nuovo_testo_risposta = $_POST['nuova_risposta'];
        }
        return $nuovo_testo_risposta;
    }
}