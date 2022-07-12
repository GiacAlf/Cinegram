<?php

/**
 * Controllore che gestisce i casi d'uso legati
 * a tutto ciò che riguarda gli utenti e la parte più social dell'applicazione
 */
class CMember {

    /**
     * Metodo che, recuperando alcune informazioni soprattutto degli utenti dal database, chiama la
     * view adibita a far visualizzare la pagina nota come "Members"
     * @return void
     * @throws SmartyException
     */
    public static function caricaMembers(): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            $identificato = true;
            $username = SessionHelper::getUtente()->getUsername();
            $member = FPersistentManager::load("EMember",null, $username,null,
                null,null,null,null,false);
            $ultimeRecensioni = FPersistentManager::caricaUltimeRecensioniScritteUtentiSeguiti($member,6);
        }
        else {
            $identificato = false;
            $ultimeRecensioni = FPersistentManager::caricaUltimeRecensioniScritte(6);
        }
        $utentiPiuPopolari = FPersistentManager::caricaUtentiPiuPopolari(4);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, true);

        $utentiPiuSeguiti = FPersistentManager::caricaUtentiConPiuFollower(5);
        $immaginiUtentiSeguiti = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuSeguiti, false);

        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti(5);
        $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

        $view = new VMembers();

        $view->avviaPaginaMembers($ultimeRecensioni, $utentiPiuPopolari, $immaginiUtentiPopolari,
            $filmPiuVisti, $locandineFilmPiuVisti, $utentiPiuSeguiti, $immaginiUtentiSeguiti, $identificato);
    }


    /*L'utente clicca sul singolo member per accedere alla sua pagina personale, avra' associato una
    url localhost/member/carica-member/username con metodo get-> infatti lo username viene passato dall'url */
    /**
     * Metodo che chiama la view adibita a far visualizzare la pagina dell'utente singolo
     * cliccato dall'utente, non necessariamente loggato, nell'applicazione
     * @param string $username
     * @return void
     * @throws SmartyException
     */
    public static function caricaMember(string $username): void {

        if(FPersistentManager::exist("EUser", null, $username, null, null, null, null,
            null, null)) {
            $view = new VUtenteSingolo();
            $member = FPersistentManager::load("EMember", null, $username, null, null,
                null, null, null, true);
            $filmVisti = FPersistentManager::calcolaNumeroFilmVisti($member);
            $following = FPersistentManager::calcolaNumeroFollowing($member);
            $follower = FPersistentManager::calcolaNumeroFollower($member);
            $bannato = FPersistentManager::userBannato($username);
            $immagine_profilo = FPersistentManager::loadImmagineProfilo($member, true);
            $seguito = false;
            if (SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {

                $username_sessione = SessionHelper::getUtente()->getUsername();
                $seguito = FPersistentManager::loSegui($username_sessione, $username);
            }
            $utentiPiuPopolari = FPersistentManager::caricaUtentiPiuPopolari(4);
            $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, false);
            $view->avviaPaginaUtente($member, $immagine_profilo,
                $filmVisti, $following, $follower, $seguito, $bannato, $utentiPiuPopolari, $immaginiUtentiPopolari);
        }
        else {
            $view = new VErrore();
            $view->error(3);
        }

    }


    /**
     * Metodo che chiama la view adibita a far visualizzare la
     * pagina dei follower e following dell'utente cliccato
     * @param string $username
     * @return void
     * @throws SmartyException
     */
    public static function mostraFollow(string $username): void {

        //QUA HO PENSATO DI PRENDERE SOLO LE LISTE, TANTO SOLO QUELLE MI SERVONO
        //$member = FPersistentManager::load("EMember",null,$username,null,null,
          //  null,null,null,true);
        if(FPersistentManager::exist("EUser", null, $username, null, null, null, null,
            null, null)) {
            $view = new VUtenteSingolo();
            $lista_follower = FPersistentManager::loadListaFollower($username);
            $immagini_follower = FPersistentManager::loadImmaginiProfiloMembers($lista_follower, true);
            $lista_following = FPersistentManager::loadListaFollowing($username);
            $immagini_following = FPersistentManager::loadImmaginiProfiloMembers($lista_following, true);
            $view->avviaPaginaFollow($username, $lista_follower, $immagini_follower, $lista_following, $immagini_following);
        }
        else {
            $view = new VErrore();
            $view->error(3);
        }
    }


    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' seguire il member, sara' una richiesta in get
    al seguente url localhost/member/follow-member/username */
    /**
     * Metodo che aggiunge alla lista dei following dell'utente, necessariamente loggato,
     * l'utente cliccato e selezionato dallo stesso
     * @param string $username_da_seguire
     * @return void
     * @throws SmartyException
     */
    public static function followMember(string $username_da_seguire): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //se sei loggato e se sei un member e se l'utente della sessione è diverso dell'utente da andare a seguire puoi fare
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member" &&
            SessionHelper::getUtente()->getUsername() != $username_da_seguire){
            if(FPersistentManager::exist("EUser", null, $username_da_seguire, null, null, null, null,
                null, null)) {
                if(!FPersistentManager::userBannato($username_da_seguire)) {
                    $username = SessionHelper::getUtente()->getUsername();

                    $following = $username_da_seguire; //lo si recupera dall'url = $username_da_seguire

                    $follower = $username;
                    $segui = FPersistentManager::loSegui($follower, $following);
                    if (!$segui) {
                        $following = FPersistentManager::load("EMember", null, $following, null, null,
                            null, null, null, false);
                        $follower = FPersistentManager::load("EMember", null, $follower, null, null,
                            null, null, null, false);
                        FPersistentManager::follow($follower, $following);
                        header("Location: https://" . VUtility::getRootDir() . "/member/carica-member/" . $username_da_seguire);
                    } else { //FA UN PO' CAGARE COME SINTASSI PERò SPERO SIA OK
                        $view = new VErrore();
                        $view->error(11);
                    }
                }
                else{
                    $view = new VErrore();
                    $view->error(16);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' unfolloware il member, sara' una richiesta in get
    al seguente url localhost/member/unfollow-member/username. */

    /**
     * Metodo che rimuove dalla lista dei following dell'utente, necessariamente loggato,
     * l'utente cliccato e selezionato dallo stesso
     * @param string $username_da_non_seguire
     * @return void
     * @throws SmartyException
     */
    public static function unfollowMember(string $username_da_non_seguire): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //verificare che l'utente sia registrato
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member" &&
            SessionHelper::getUtente()->getUsername() != $username_da_non_seguire) {
            if(FPersistentManager::exist("EUser", null, $username_da_non_seguire, null, null, null, null,
                null, null)) {
                if(!FPersistentManager::userBannato($username_da_non_seguire)) {
                    $username = SessionHelper::getUtente()->getUsername();
                    $following = $username_da_non_seguire; //lo si recupera dall'url  = $username_da_non_seguire
                    //recupero dalla sessione il mio username => $follower = $username
                    $follower = $username; //=> $follower = $username
                    //una volta che sei loggato, però bisogna verificare che l'utente effettivamente è seguito
                    $segue = FPersistentManager::loSegui($follower, $following);
                    if ($segue) {
                        $following = FPersistentManager::load("EMember", null, $following, null, null,
                            null, null, null, false);
                        $follower = FPersistentManager::load("EMember", null, $follower, null, null,
                            null, null, null, false);

                        FPersistentManager::unfollow($follower, $following);
                        header("Location: https://" . VUtility::getRootDir() . "/member/carica-member/" . $username_da_non_seguire);
                    } else { //FA UN PO' CAGARE COME SINTASSI PERò SPERO SIA OK
                        $view = new VErrore();
                        $view->error(11);
                    }
                }
                else{
                    $view = new VErrore();
                    $view->error(16);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
    metodo che serve per far registrare l'utente, ci sara' una form ed una richiesta fatta in post
    alla seguente url : localhost/member/registrazione-member
    */
    /**
     * Metodo che, una volta recuperate tutte le credenziali necessarie,
     * registra e salva nel database un nuovo utente
     * @return void
     * @throws SmartyException
     */
    public static function registrazioneMember(): void {

        if(!SessionHelper::isLogged()) {
            $view = new VLogin();
            $array_credenziali = $view->RegistrazioneCredenziali();
            //se o lo username o la password sono vuote [forse inutili dato che c'è required in html]
            //oppure se la password e la conferma password sono diverse parte l'errore
            if ($array_credenziali[0] == null || $array_credenziali[1] == null ||
                $array_credenziali[1] != $array_credenziali[2]) {
                $view_errore = new VErrore();
                $view_errore->error(6);
            }
            else {
                $username = $array_credenziali[0];
                $password = $array_credenziali[1];
                $bio = $array_credenziali[3];
                $data = new DateTime(); //il format giusto poi lo fa Foundation
                $foto_profilo = $view->RegistrazioneImmagineProfilo();
                //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
                //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
                //qua se l'img è null pazienza
                $member = new EMember($username, $data, $bio, 0, null, null, null, null);
                if(!FPersistentManager::exist("EUser", null, $username, null, null, null, null,
                    null, null)) {
                    FPersistentManager::store($member, null, $password, null, null, $foto_profilo['tmp_name'],
                        $foto_profilo['type'], $foto_profilo['size']); //immagino si chiami così poi boh
                    //dovrà partire la sessione
                    SessionHelper::login($member);
                    //scritto brutto per dire che conviene redirectare all'homepage
                    header("Location: https://" . VUtility::getRootDir() . "/homepage/imposta-homepage");
                    //REGISTRAZIONE COME ADMIN? DA DATABASE DIRETTAMENTE?
                }
                else {
                    $view = new VErrore();
                    $view->error(15);
                }
            }
        }
        else {
            $view = new VErrore();
            $view->error(12);
        }
    }


    //qua basta che facevo vedere il template

    /**
     * Metodo che ha il compito di chiamare la view adibita a visualizzare
     * la pagina per registarsi
     * @return void
     * @throws SmartyException
     */
    public static function paginaRegistrazione(): void {

        if(!SessionHelper::isLogged()) {
            $view = new VLogin();
            $view->avviaPaginaRegistrazione();
        }
        else {
            $view = new VErrore();
            $view->error(12);
        }
    }


    /*
     richiesta in get con url  localhost/member/cerca-member/username, viene chiamato quando nella barra di ricerca
    si vuole cercare un member passando il suo username
    */
    /**
     * Metodo che, preso in ingresso il prompt scritto dall'utente,
     * cerca e restituisce l'utente richiesto, se esiste
     * @return void
     * @throws SmartyException
     */
    public static function cercaMember(): void {

        $view = new VRicerca();
        $array_risultati = array();
        $immagini_profilo = array();
        $username = $view->eseguiRicerca();
        if($username != null && FPersistentManager::exist("EUser", null, $username, null, null, null, null,
                null, null)){
            $member = FPersistentManager::load("EMember", null, $username, null, null,
                        null, null, null, false);
            $array_risultati[] = $member;
            $immagini_profilo = FPersistentManager::loadImmaginiProfiloMembers($array_risultati, false);
        }


        $view->avviaPaginaRicerca($array_risultati, $immagini_profilo);
    }
}