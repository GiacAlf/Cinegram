<?php

class CMember {

    /*
     L'utente clicca su Members ed a seconda se è registrato oppure no vedra' la stessa
    schermata con diversi dati, le diverse schermate le potrebbe gestire Smarty, noi gli passiamo
    un parametro registrato o non registrato e lei capisce, oppure fare due schermate diverse che
    richiamiamo noi dentro questo metodo. Sara' associata una url del tipo
    localhost/member/carica-members
    */

    public static function caricaMembers(): void {

        //controlli per quanto riguarda l'utente loggato o meno
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}
        //se l'utente è loggato e se è un member
        //QUA NON CONVIENE CHIEDERE ALL'UTENTE DELLA SESSIONE IL SUO RUOLO? METODO chiSei
        //alternativa: FPersistentManager::tipoUserRegistrato(SessionHelper::getUtente()->getUsername()) == "Member"
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            $identificato = true;
            $username = SessionHelper::getUtente()->getUsername();
            $member = FPersistentManager::load("EMember",null, $username,null,
                null,null,null,null,false);
            $ultimeRecensioni = FPersistentManager::caricaUltimeRecensioniScritteUtentiSeguiti($member,6);
        }
        else {
            $identificato = false;
            $ultimeRecensioni = FPersistentManager::caricaUltimeRecensioniScritte(5);
        }
        $utentiPiuPopolari = FPersistentManager::caricaUtentiPiuPopolari(2);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, true);

        $utentiPiuSeguiti = FPersistentManager::caricaUtentiConPiuFollower(2);
        $immaginiUtentiSeguiti = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuSeguiti, false);

        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti(2);
        $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

        $view = new VMembers();

         /* passo questi dati ad un unico metodo di una view insieme ad un parametro
         per discriminare l'utente registrato da quello non registrato oppure ci saranno
         due metodi della view separati, uno per la grafica di ogni tipologia di utente(la
         prima è sicuramente migliore)*/
        $view->avviaPaginaMembers($ultimeRecensioni, $utentiPiuPopolari, $immaginiUtentiPopolari,
            $filmPiuVisti, $locandineFilmPiuVisti, $utentiPiuSeguiti, $immaginiUtentiSeguiti, $identificato);
    }


    /*L'utente clicca sul singolo member per accedere alla sua pagina personale, avra' associato una
    url localhost/member/carica-member/username con metodo get-> infatti lo username viene passato dall'url */
    public static function caricaMember(string $username): void {

        if(FPersistentManager::exist("EUser", null, $username, null, null, null, null,
            null, null)) {
            $view = new VUtenteSingolo();
            $member = FPersistentManager::load("EMember", null, $username, null, null,
                null, null, null, true);
            $filmVisti = FPersistentManager::calcolaNumeroFilmVisti($member);
            $following = FPersistentManager::calcolaNumeroFollowing($member);
            $follower = FPersistentManager::calcolaNumeroFollower($member);
            $immagine_profilo = FPersistentManager::loadImmagineProfilo($member, true);
            $seguito = false;
            if (SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
                //se dovesse essere un admin pazienza, non lo trova nel metodo loSegui
                //se gli username sono uguali nel metodo lo segui, ti dà false
                $username_sessione = SessionHelper::getUtente()->getUsername();
                $seguito = FPersistentManager::loSegui($username_sessione, $username);
            }
            $utentiPiuPopolari = FPersistentManager::caricaUtentiPiuPopolari(2);
            $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, false);
            $view->avviaPaginaUtente($member, $immagine_profilo,
                $filmVisti, $following, $follower, $seguito, $utentiPiuPopolari, $immaginiUtentiPopolari);
        }
        else {
            $view = new VErrore();
            $view->error(3);
        }


        /* CHIUNQUE SIA L'UTENTE SUL SITO COMPARE LA PAGINA DEL MEMBER, POI L'ADMIN CLICCA SU
        "MODERA UTENTE" PER AMMONIRLO E TUTTO IL RESTO


        // TODO se sei l'admin carica una pagina per fare le cose dell'admin sull'utente
        if(SessionHelper::getUtente()->chiSei() == "Admin"){ //ma se ho un utente non registrato che succede?
            $view_admin = new VAdmin(); //in teoria la stringa a sinistra dovrebbe essere null, si spera
            $view_admin->avviaPaginaModeraUtente($member);
        }
        else {
            //TODO if($user:chiSei == "Admin") chiama la VAdmin sennò la VFilms
            $view->avviaPaginaUtente($member, $filmvisti, $following, $follower);
        }*/
    }


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
    public static function followMember(string $username_da_seguire): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //se sei loggato e se sei un member e se l'utente della sessione è diverso dell'utente da andare a seguire puoi fare
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member" &&
            SessionHelper::getUtente()->getUsername() != $username_da_seguire){
            if(FPersistentManager::exist("EUser", null, $username_da_seguire, null, null, null, null,
                null, null)) {

                $username = SessionHelper::getUtente()->getUsername();

                $following = $username_da_seguire; //lo si recupera dall'url = $username_da_seguire

                //recupero dalla sessione il mio username => $follower = $username
                $follower = $username;
                //CONTROLLO COME IN UNFOLLOW MEMBER?
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

    public static function unfollowMember(string $username_da_non_seguire): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //verificare che l'utente sia registrato
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member" &&
            SessionHelper::getUtente()->getUsername() != $username_da_non_seguire) {
            if(FPersistentManager::exist("EUser", null, $username_da_non_seguire, null, null, null, null,
                null, null)) {
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
    public static function cercaMember(): void {

        //qua l'utente avrà cliccato il bottone cercaMember con la form, il cui contenuto viene recuperato
        //dalla view
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
        //qua forse è più efficace una cosa del tipo:
        //$array_risultati = array();
        //$immagini_profilo = array();
        //if($username != null){
        //$member = FPersistentManager::load("EMember", null, $username, null, null,
        //                null, null, null, false);
        // $immagini_profilo = FPersistentManager::loadImmaginiProfiloMembers($array_risultati, false);
        //}
        //$view->avviaPaginaRicerca($array_risultati, $immagini_profilo);

        $view->avviaPaginaRicerca($array_risultati, $immagini_profilo);
    }
}