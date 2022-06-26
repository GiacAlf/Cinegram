<?php

class VRecensione
{
    private Smarty $smarty;


    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //sembra che così funzioni, mentre se chiamo showNavBar [$navbar->showNavBar()] no, la variabile user non la prende
    public function avviaPaginaRecensione(ERecensione $recensione): void{
        $user = SessionHelper::UserNavBar();
        $this->smarty->assign( 'user', $user);
        $this->smarty->assign( 'id', $recensione->getIdFilmRecensito());
        $this->smarty->assign( 'autore_rece', $recensione->getUsernameAutore());
        $this->smarty->assign( 'voto', $recensione->getVoto());
        $this->smarty->assign( 'testo', $recensione->getTesto());
        $this->smarty->assign( 'data', $recensione->getDataScrittura()->format('d-m-Y H:i'));
        $this->smarty->assign( 'risposte', $recensione->getRisposteDellaRecensione());
        $this->smarty->display('recensione.tpl');
    }

    public function avviaPaginaModificaRecensione(ERecensione $recensione): void{
        $this->smarty->assign( 'id_film', $recensione->getIdFilmRecensito());
        $this->smarty->assign( 'username', $recensione->getUsernameAutore());
        $this->smarty->assign( 'voto', $recensione->getVoto());
        $this->smarty->assign( 'testo', $recensione->getTesto());
        $this->smarty->display('modifica_recensione.tpl');
    }

    public function avviaPaginaModificaRisposta(ERisposta $risposta): void{
        $this->smarty->assign( 'autore_rece', $risposta->getUsernameAutoreRecensione());
        $this->smarty->assign( 'testo', $risposta->getTesto());
        $this->smarty->assign( 'data', $risposta->ConvertiDatainFormatoUrl());
        $this->smarty->display('modifica_risposta.tpl');
    }

    public function scriviRisposta(): ?string{
        $testo_risposta = null;
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        return $testo_risposta;
    }

    public function modificaRecensione(): ?array{
        $array_recensione = array();
        $nuovo_testo_recensione = null;
        $nuovo_voto_recensione = null;
        if(isset($_POST['nuovo_testo'])){
            $nuovo_testo_recensione = $_POST['nuovo_testo'];
        }
        if(isset($_POST['nuovo_voto'])){
            $nuovo_voto_recensione = $_POST['nuovo_voto'];
        }
        //se non è settato ne il voto ne il testo vaffanculo -> oppure dall'html lo fa
        $array_recensione[] = $nuovo_testo_recensione;
        $array_recensione[] = $nuovo_voto_recensione;
        return $array_recensione;
    }

    public function modificaRisposta(): ?string{
        $nuovo_testo_risposta = null;
        if(isset($_POST['nuova_risposta'])){
            $nuovo_testo_risposta = $_POST['nuova_risposta'];
        }
        return $nuovo_testo_risposta;
    }

}