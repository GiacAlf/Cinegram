<?php

/**
 *Classe adibita a gestire l'input e l'output delle attività dell'utente
 * inerenti alle ricerche compiute su film o altri utenti
 */
class VRicerca {
    /**
     *L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;

    //il costruttore della home page richiama l'oggetto smarty configurato
    //e se lo salva
    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();;
    }

    //metodo che mi fa vedere la pagina dopo aver eseguito la ricerca: dato che io avrò
    //sempre un array da far visualizzare io prima faccio vedere quanti risultati ci sono
    //poi se ho effettivamente dei risultati li assegno a smarty. In ogni caso faccio display del template
    /**
     * Metodo che fa visualizzare la pagina contenente i risultati della ricerca dell'utente
     * @param array $risultato_ricerca
     * @param array $immagini
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaRicerca(array $risultato_ricerca, array $immagini): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('risultato_ricerca', $risultato_ricerca);
        $this->smarty->assign('immagini', $immagini);
        $this->smarty->display('ricerca.tpl');
    }


    //metodo che restituisce al controller il prompt scritto dall'utente

    /**
     * Metodo che recupera la stringa scritta dall'utente per effettuare una ricerca
     * @return string|null
     */
    public function eseguiRicerca(): ?string {

        $ricerca = null;
        if (isset($_POST['ricerca'])) {
            $ricerca = $_POST['ricerca'];
        }
        return $ricerca;
    }

}