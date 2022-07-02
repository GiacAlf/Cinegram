<?php

class VErrore {

    private Smarty $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    public function error(int $id_errore): void{
        $user = SessionHelper::UserNavBar();
        $this->smarty->assign('user', $user);
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
                $testo = 'Immagine caricata non è del tipo corretto jpeg oppure è troppo pesante' ; //qua lo famo per le foto
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
            case '8' :
                $testo = 'Questa opzione o questa pagina è riservata solo agli utenti registrati o agli admin!';
                $titolo = 'Autenticazione necessaria!';
                break;
            case '9' :
                $testo = 'Questa operazione non può essere eseguita con un input vuoto!' . "\n" .
                    "Clicca 'indietro' nel browser per tornare alla pagina precedente";
                $titolo = 'Errore di input!';
                break;
            case '10' :
                $testo = 'La vecchia password non corrisponde!';
                $titolo = 'Errore password!';
                break;
            case '11' :
                $testo = 'Questa operazione è stata già eseguita in precedenza!';
                $titolo = 'Errore input!';
                break;
            case '12' :
                $testo = 'Questa opzione o questa pagina è riservata solo agli utenti non registrati';
                $titolo = 'Autenticazione non necessaria!';
                break;
            case '13' :
                $testo = 'il member moderato è già bannato';
                $titolo = 'Errore moderazione';
                break;
            case '14' :
                $testo = 'il member moderato è già non bannato';
                $titolo = 'Errore moderazione';
                break;

        }
        $this->smarty->assign('testo', $testo);
        $this->smarty->assign('titolo', $titolo);
        $this->smarty->display('error.tpl');
    }
}