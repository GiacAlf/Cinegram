<?php

/**
 *Classe adibita a far visualizzare all'utente l'errore che ha commesso
 * durante varie azioni
 */
class VErrore {

    /**
     * L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }


    /**
     * Metodo che fa visualizzare una pagina di errore differente a seconda dell'errore commesso
     * dall'utente
     * @param int $id_errore
     * @return void
     * @throws SmartyException
     */
    public function error(int $id_errore): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('id_errore', $id_errore);
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
                $testo = 'Il metodo o la risorsa richiesto/a non esiste/non è stato trovato!';  //lo chiama il front controller
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
                $testo = 'il member moderato è già bannato oppure ha già 0 ammonizioni';
                $titolo = 'Errore moderazione';
                break;
            case '14' :
                $testo = 'il member moderato è già non bannato';
                $titolo = 'Errore moderazione';
                break;
            case '15' :
                $testo = 'Lo username usato è già occupato';
                $titolo = 'Errore registrazione';
                break;
            case '16' :
                $testo = 'Il member selezionato è al momento bannato: non è possibile seguirlo o rispondere alle sue recensioni';
                $titolo = 'Errore utente!';
                break;
        }
        $this->smarty->assign('testo', $testo);
        $this->smarty->assign('titolo', $titolo);
        $this->smarty->display('errore.tpl');
    }
}