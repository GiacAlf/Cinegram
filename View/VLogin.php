<?php

/**
 *Classe adibita a gestire tutto l'input e l'output inerenti alle attività di login
 * e registrazione dell'utente
 */
class VLogin {
    /**
     * L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;
    /**
     * Il massimo peso, in byte, delle immagini che l'utente può caricare
     * @var int
     */
    private static int $maxSizeImmagineProfilo = 524288;

    //il costruttore della  page richiama l'oggetto smarty configurato
    //e se lo salva
    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //il metodo di avvio della pagina non fa altro che presentare la form di login
    //e basta, non devo assegnare niente
    /**
     * Metodo che fa visualizzare la pagina utile all'utente per loggarsi
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaLogin(): void {

        //QUA ATTENZIONE: SI PRESUPPONE CHE PER ACCEDERE A LOGIN $user = "non_loggato"
        //QUINDI O FACCIO COSì
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->display('login.tpl');
    }


    //due template diversi per il login e la registrazione? Sennò
    //penso vada bene uno solo comunque
    /**
     * Metodo che fa visualizzare la pagina utile all'utente per registrarsi
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaRegistrazione(): void {

        //QUA ATTENZIONE: SI PRESUPPONE CHE PER ACCEDERE A REGISTRAZIONE $user = "non_loggato"
        //QUINDI O FACCIO COSì
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->display('registrazione.tpl');
    }


    //metodo per verificare il login, devo discriminare dai campi registrazione

    /**
     * Metodo che recupera lo username e la password inserite dall'utente per loggarsi
     * @return array
     */
    public function verificaLogin(): array {

        $username = null;
        $password = null;
        if(isset($_POST['username_login']) && isset($_POST['password_login'])
            /*&& $this->checkPassword($_POST['password_login'])*/) {
            $username = $_POST['username_login'];
            $password = $_POST['password_login'];
        }
        return array($username, $password);
    }


    /**
     * Metodo che recupera tutte le credenziali inserite dall'utente necessarie per loggarsi: username, password
     * conferma della password ed, eventualmente, una bio
     * @return array
     */
    public function RegistrazioneCredenziali(): array {

        //$pattern1 = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[*!@$%^&£'\"#(){}\[\]>°?~_+-=|]).{8,32}$/";
        //regola:1 lettera minuscola, 1 lettera maiuscola, 1 cifra, 1 carattere speciale e lunga da 8 a 32 caratteri
        //CONTROLLO DELLE ESPRESSIONI REGOLARI QUI NELLE VIEW
        $username = null;
        $password = null;
        $bio = null;
        $conferma_password = null;
        if(isset($_POST['username_registrazione']) && isset($_POST['password_registrazione'])
            && isset($_POST['conferma_password']) && $this->checkPassword($_POST['password_registrazione'])
            && $this->checkPassword($_POST['conferma_password'])) {
            $username = $_POST['username_registrazione'];
            $password = $_POST['password_registrazione'];
            $conferma_password = $_POST['conferma_password'];
        }
        if(isset($_POST['bio'])) {
            $bio = $_POST['bio'];
        }
        return array($username, $password, $conferma_password, $bio);
    }


    //metto a parte la roba per le foto, non ho idea per ora di come gestirlo $_Files

    /**
     *Metodo che recupera l'eventuale immagine profilo che l'utente ha caricato per
     * registrarsi
     * @return array|null
     */
    public function RegistrazioneImmagineProfilo(): ?array {

        $array_foto = null;
        if(isset($_FILES['immagine_profilo']) && $this->checkFoto()) {
            $array_foto = $_FILES['immagine_profilo'];
        }
        return $array_foto;
    }


    /**
     * Metodo che verifica e controlla la robustezza della password
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool {

        $match = false;
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32}$/";
        if(preg_match($pattern, $password)) {
            $match = true;
        }
        return $match;
    }


    /**
     * Metodo che controlla se l'immagine caricata dall'utente rispetti le specifiche desiderate:
     * peso non superiore a 500 KB e tipo jpeg o png
     * @return bool|null
     * @throws SmartyException
     */
    public function checkFoto(): ?bool {
        $check = false;
        if($_FILES['immagine_profilo']['size'] != null && $_FILES['immagine_profilo']['type']!= null){  //forse questo controllo ulteriore è inutile, però boh
            if($_FILES['immagine_profilo']['size'] > self::$maxSizeImmagineProfilo) {
                $view_errore = new VErrore();
                $view_errore->error(4);
                return null;
            }
            elseif($_FILES['immagine_profilo']['type'] != 'image/jpeg' && $_FILES['immagine_profilo']['type'] != 'image/png') {
                $view_errore = new VErrore();
                $view_errore->error(4);
                return null;
            }
            else {
                $check = true;
            }
        }
        return $check;
    }
}