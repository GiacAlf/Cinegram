<?php

class VLogin {

    private Smarty $smarty;
    private static int $maxSizeImmagineProfilo = 524288;

    //il costruttore della  page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //il metodo di avvio della pagina non fa altro che presentare la form di login
    //e basta, non devo assegnare niente
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


    //TODO: metodo per registrarsi, devo discriminare dai campi login -> MANCA IL CONFERMA PASSWORD
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
    public function RegistrazioneImmagineProfilo(): ?array {

        $array_foto = null;
        if(isset($_FILES['immagine_profilo']) && $this->checkFoto()) {
            $array_foto = $_FILES['immagine_profilo'];
        }
        return $array_foto;
    }


    public function checkPassword(string $password): bool {

        $match = false;
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32}$/";
        if(preg_match($pattern, $password)) {
            $match = true;
        }
        return $match;
    }


    public function checkFoto(): bool {
        $check = false;
        if(isset($_FILES['immagine_profilo'])){  //forse questo controllo ulteriore è inutile, però boh
            if($_FILES['immagine_profilo']['size'] > self::$maxSizeImmagineProfilo) {
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            elseif($_FILES['immagine_profilo']['type'] != 'image/jpeg' && $_FILES['immagine_profilo']['type'] != 'image/png') {
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            else {
                $check = true;
            }
        }
        return $check;
    }
}