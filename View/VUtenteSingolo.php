<?php

class VUtenteSingolo {

    private Smarty $smarty;
    private static int $maxSizeImmagineProfilo = 524288;

    //il costruttore della pagina dell'utente singolo richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo che ci fa vedere la pagina dell'utente singolo, prendendo
    //come parametro l'utente selezionato
    public function avviaPaginaUtente(EMember $utente_selezionato, array $immagine_profilo,
                                      int $numero_film_visti, int $numero_following,
                                      int $numero_follower, bool $seguito, bool $bannato, array $utenti_popolari, array $immagini_utenti) {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('member', $utente_selezionato);
        $this->smarty->assign('immagine_profilo', $immagine_profilo);
        $this->smarty->assign('seguito', $seguito);
        $this->smarty->assign('bannato', $bannato);
        $this->smarty->assign('film_visti', $utente_selezionato->getFilmVisti());
        $this->smarty->assign('recensioni', $utente_selezionato->getRecensioniScritte());
        $this->smarty->assign('numero_film_visti', $numero_film_visti);
        $this->smarty->assign('numero_following', $numero_following);
        $this->smarty->assign('numero_follower', $numero_follower);
        $this->smarty->assign('utenti_popolari', $utenti_popolari);
        $this->smarty->assign('immagini_utenti_popolari', $immagini_utenti);
        $this->smarty->display('member_singolo.tpl');
    }


    public function avviaPaginaModificaUtente(EMember $utente, array $immagine_profilo): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('member', $utente);
        $this->smarty->assign('immagine_vecchia', $immagine_profilo);
        $this->smarty->display('modifica_profilo.tpl');
    }


    public function avviaPaginaFollow(string $username, array $lista_follower, array $immagini_follower,
                                      array $lista_following, array $immagini_following): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('username', $username);
        $this->smarty->assign('follower', $lista_follower);
        $this->smarty->assign('immagini_follower', $immagini_follower);
        $this->smarty->assign('following', $lista_following);
        $this->smarty->assign('immagini_following', $immagini_following);
        $this->smarty->display('follower.tpl');
    }


    //metodo che restituisce l'array contenente tutte le info
    //della nuova foto profilo
    //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
    //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
    public function aggiornaFoto(): ?array{
        $foto = null;
        if(isset($_FILES['nuova_img_profilo']) && $this->checkFoto()) {
            $foto = $_FILES['nuova_img_profilo'];
        }
        return $foto;
    }


    //metodo che controlla che sia tutto ok
    public function checkFoto(): ?bool{

        $check = false;
        if($_FILES['nuova_img_profilo']['size'] != null && $_FILES['nuova_img_profilo']['type']!= null) { //forse questo controllo ulteriore è inutile, però boh
            if($_FILES['nuova_img_profilo']['size'] > self::$maxSizeImmagineProfilo) {
                $view_errore = new VErrore();
                $view_errore->error(4);
                return null;
            }
            elseif($_FILES['nuova_img_profilo']['type'] != 'image/jpeg' && $_FILES['nuova_img_profilo']['type'] != 'image/png') {
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


    //metodo che aggiorna la bio
    public function aggiornaBio(): ?string {

        $nuova_bio = null;
        if(isset($_POST['nuova_bio'])) {
            $nuova_bio = $_POST['nuova_bio'];
        }
        return $nuova_bio;
    }


    //metodo che aggiorna la password
    public function aggiornaPassword(): ?string {

        $nuova_password = null;
        if(isset($_POST['nuova_password']) && $this->checkPassword($_POST['nuova_password'])) {
            $nuova_password = $_POST['nuova_password'];
        }
        return $nuova_password;
    }


    public function recuperaVecchiaPassword(): ?string {

        $vecchia_password = null;
        if(isset($_POST['vecchia_password'])) {
            $vecchia_password = $_POST['vecchia_password'];
        }
        return $vecchia_password;
    }


    public function verificaConfermaPassword(): ?string {

        $conferma_password = null;
        if(isset($_POST['conferma_nuova_password']) && $this->checkPassword($_POST['nuova_password'])) {
            $conferma_password = $_POST['conferma_nuova_password'];
        }
        return $conferma_password;
    }


    public function checkPassword(string $password): bool {

        $match = false;
        $pattern = "((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})";
        if(preg_match($pattern, $password)) {
            $match = true;
        }
        return $match;
    }
}