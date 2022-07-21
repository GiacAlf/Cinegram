<?php

/**
 * *Classe adibita a gestire l'input e l'output delle attività dell'utente
 * in corrispondenza delle pagine degli altri utenti o della sua pagina personale
 */
class VUtenteSingolo {

    /**
     *L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;
    /**
     * Il massimo peso, in byte, delle immagini che l'utente può caricare
     * @var int
     */
    private static int $maxSizeImmagineProfilo = 524288;

    //il costruttore della pagina dell'utente singolo richiama l'oggetto smarty configurato
    //e se lo salva
    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo che ci fa vedere la pagina dell'utente singolo, prendendo
    //come parametro l'utente selezionato
    /**
     * Metodo che fa visualizzare la pagina personale di un utente
     * @param EMember $utente_selezionato
     * @param array $immagine_profilo
     * @param int $numero_film_visti
     * @param int $numero_following
     * @param int $numero_follower
     * @param bool $seguito
     * @param bool $bannato
     * @param array $utenti_popolari
     * @param array $immagini_utenti
     * @return void
     * @throws SmartyException
     */
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


    /**
     * Metodo che fa visualizzare la pagina per modificare alcune info della pagina personale dell'utente
     * @param EMember $utente
     * @param array $immagine_profilo
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaModificaUtente(EMember $utente, array $immagine_profilo): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('member', $utente);
        $this->smarty->assign('immagine_vecchia', $immagine_profilo);
        $this->smarty->display('modifica_profilo.tpl');
    }


    /**
     * Metodo che fa visualizzare la pagina degli utenti seguiti e seguenti dell'utente selezionato
     * @param string $username
     * @param array $lista_follower
     * @param array $immagini_follower
     * @param array $lista_following
     * @param array $immagini_following
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaFollow(string $username, array $lista_follower, array $immagini_follower,
                                      array  $lista_following, array $immagini_following): void {

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
    /**
     * Metodo che restituisce l'immagine caricata dall'utente per poter aggiornare il suo profilo
     * @return array|null
     */
    public function aggiornaFoto(): ?array{
        $foto = null;
        if(isset($_FILES['nuova_img_profilo']) && $this->checkFoto()) {
            $foto = $_FILES['nuova_img_profilo'];
        }
        return $foto;
    }


    //metodo che controlla che sia tutto ok

    /**
     * Metodo che controlla se l'immagine caricata dall'utente rispetti le specifiche desiderate:
     * peso non superiore a 500 KB e tipo jpeg o png
     * @return bool|null
     * @throws SmartyException
     */
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

    /**
     * Metodo che restituisce la nuova bio dell'utente per poter aggiornare il suo profilo
     * @return string|null
     */
    public function aggiornaBio(): ?string {

        $nuova_bio = null;
        if(isset($_POST['nuova_bio'])) {
            $nuova_bio = $_POST['nuova_bio'];
        }
        return $nuova_bio;
    }


    //metodo che aggiorna la password

    /**
     * Metodo che restituisce la nuova password dell'utente per poter aggiornare il suo profilo
     * @return string|null
     */
    public function aggiornaPassword(): ?string {

        $nuova_password = null;
        if(isset($_POST['nuova_password']) && $this->checkPassword($_POST['nuova_password'])) {
            $nuova_password = $_POST['nuova_password'];
        }
        return $nuova_password;
    }


    /**
     * Metodo che restituisce la vecchia password dell'utente per poter verificare e far partire
     * l'aggiornamento di una nuova password
     * @return string|null
     */
    public function recuperaVecchiaPassword(): ?string {

        $vecchia_password = null;
        if(isset($_POST['vecchia_password'])) {
            $vecchia_password = $_POST['vecchia_password'];
        }
        return $vecchia_password;
    }


    /**
     * Metodo che restituisce la conferma della nuova password dell'utente per poter aggiornare il suo profilo
     * @return string|null
     */
    public function verificaConfermaPassword(): ?string {

        $conferma_password = null;
        if(isset($_POST['conferma_nuova_password']) && $this->checkPassword($_POST['nuova_password'])) {
            $conferma_password = $_POST['conferma_nuova_password'];
        }
        return $conferma_password;
    }


    /**
     * Metodo che verifica e controlla la robustezza della password
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool {

        $match = false;
        $pattern = "((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})";
        if(preg_match($pattern, $password)) {
            $match = true;
        }
        return $match;
    }
}