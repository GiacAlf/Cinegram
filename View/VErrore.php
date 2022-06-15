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
                $testo = 'Le credenziali inserite sono errate o sono mancanti';
                $titolo = 'Errore login';
                break;
            case '2' :
                $testo = 'La URL richiesta non esiste/non è stata trovata!';  //lo chiama il Front controller
                $titolo = 'HTTP/1.1 404 URL Not Found';
                break;
            case '3':
                $testo = 'Il metodo richiesto non esiste/non è stato trovato!';  //lo chiama il front controller
                $titolo = 'HTTP/1.1 405 Method Not Allowed';
                break;
            case '4':
                $testo = 'Immagine caricata non è del tipo corretto jpeg' ; //qua lo famo per le foto
                $titolo = 'Errore immagine caricata';
                break;
            case '5' :
                $testo = 'Non puoi eliminare e/o modificare';
                $titolo = 'Errore eliminazione/modifica';
                break;
            case '6' :
                $testo = 'Le credenziali inserite sono errate o sono mancanti';
                $titolo = 'Errore registrazione';
                break;
            case '7' :
                $testo = 'il member che ha effettuato il login è bannato';
                $titolo = 'Errore login';
                break;


        }
        $this->smarty->assign('testo', $testo);
        $this->smarty->assign('titolo', $titolo);
        $this->smarty->display('error.tpl');
    }

}