<?php

class VErrore
{
    private Smarty $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    public function error(int $id_errore){
        $this->smarty->assign('i', $id_errore);
        switch ($id_errore) {
            case '1' :
                $testo = 'Autorizzazione necessaria!';
                $titolo = 'Autorizzazione necessaria';
                break;
            case '2' :
                $testo = 'La URL richiesta non esiste/non è stata trovata!';
                $titolo = 'HTTP/1.1 404 URL Not Found';
                break;
            case '3':
                $testo = 'Il metodo richiesto non esiste/non è stato trovato!';
                $titolo = 'HTTP/1.1 405 Method Not Allowed';
                break;
            case '4':
                $testo = 'Nessun risultato trovato!'; //qua lo famo per le foto
                $titolo = 'No result Found';
                break;
            case '5' :
                $testo = 'Non puoi eliminare e/o modificare';
                $titolo = 'Errore eliminazione/modifica';
                break;
        }
        $this->smarty->assign('testo', $testo);
        $this->smarty->assign('titolo', $titolo);
        $this->smarty->display('error.tpl');
    }

}