<?php

class VRecensione
{
    private Smarty $smarty;


    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    public function avviaPaginaRecensione(ERecensione $recensione): void{
        $this->smarty->assign( 'id', $recensione->getIdFilmRecensito());
        $this->smarty->assign( 'autore_rece', $recensione->getUsernameAutore());
        $this->smarty->assign( 'voto', $recensione->getVoto());
        $this->smarty->assign( 'testo', $recensione->getTesto());
        $this->smarty->assign( 'data', $recensione->getDataScrittura()->format('d-m-Y H:i'));
        $this->smarty->assign( 'risposte', $recensione->getRisposteDellaRecensione());
        $this->smarty->display('recensione.tpl');
    }

}