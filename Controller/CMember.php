<?php

class CMember {

    /*
     L'utente clicca su Members ed a seconda se è registrato oppure no vedra' la stessa
    schermata con diversi dati, le diverse schermate le potrebbe gestire Smarty, noi gli passiamo
    un parametro registrato o non registrato e lei capisce, oppure fare due schermate diverse che
    richiamiamo noi dentro questo metodo. Sara' associata una url del tipo
    localhost/member/carica-members
    */

    public static function caricaMembers(): void{
        $ultimeRecensioni = array();
        //controlli per quanto riguarda l'utente loggato o meno
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}
        //se l'utente è loggato e se è un member
        if(SessionHelper::isLogged()
            && FPersistentManager::tipoUserRegistrato(SessionHelper::getUtente()->getUsername()) == "Member"){
            $identificato = true;
            $username = "Matteo"; //SessionHelper::getUtente()->getUsername()
            $member = FPersistentManager::load("EMember",null,$username,null,
                null,null,null,null,false);
            $ultimeRecensioni=FPersistentManager::caricaUltimeRecensioniScritteUtentiSeguiti($member,6);
        }
        else{
            $identificato = false;
            $ultimeRecensioni=FPersistentManager::caricaUltimeRecensioniScritte(5);
        }
        $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(5);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, true);

        $utentiPiuSeguiti=FPersistentManager::caricaUtentiConPiuFollower(5);
        $immaginiUtentiSeguiti = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuSeguiti, false);

        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti(5);
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
    public static function caricaMember($username): void{
        $view = new VUtenteSingolo();
        $member = FPersistentManager::load("EMember",null,$username,null,null,
            null,null,null,true);
        $filmvisti = FPersistentManager::calcolaNumeroFilmVisti($member);
        $following = FPersistentManager::calcolaNumeroFollowing($member);
        $follower = FPersistentManager::calcolaNumeroFollower($member);
        $immagine_profilo = FPersistentManager::loadImmagineProfilo($member, true);
        $seguito = false;
        if(SessionHelper::isLogged()){
            //se dovesse essere un admin pazienza, non lo trova il metodo loSegui
            $username_sessione = SessionHelper::getUtente()->getUsername();
            $seguito = FPersistentManager::loSegui($username_sessione, $username);
        }
        $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(5);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, false);
        $view->avviaPaginaUtente($member, $immagine_profilo,
            $filmvisti, $following, $follower, $seguito, $utentiPiuPopolari, $immaginiUtentiPopolari);


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


    public static function mostraFollow(string $username): void{
        //QUA HO PENSATO DI PRENDERE SOLO LE LISTE, TANTO SOLO QUELLE MI SERVONO
        //$member = FPersistentManager::load("EMember",null,$username,null,null,
          //  null,null,null,true);
        $view = new VUtenteSingolo();
        $lista_follower = FPersistentManager::loadListaFollower($username);
        $immagini_follower = FPersistentManager::loadImmaginiProfiloMembers($lista_follower, true);
        $lista_following = FPersistentManager::loadListaFollower($username);
        $immagini_following = FPersistentManager::loadImmaginiProfiloMembers($lista_following, true);
        $view->avviaPaginaFollow($lista_follower, $immagini_follower, $lista_following, $immagini_following);
    }


    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' seguire il member, sara' una richiesta in get
    al seguente url localhost/member/follow-member/username */
    public static function followMember(string $username): void{

        //verificare che l'utente sia registrato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}

        $following="giangiacomo"; //lo si recupera dall'url

        //recupero dalla sessione il mio username => $follower = $username
        $follower = "matteo";
        $following = FPersistentManager::load("EMember",null,$following,null,null,
        null,null,null,false);
        $follower = FPersistentManager::load("EMember",null,$follower,null,null,
            null,null,null,false);

        FPersistentManager::follow($follower, $following);
    }


    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' unfolloware il member, sara' una richiesta in get
    al seguente url localhost/member/unfollow-member/username. */

    public static function unfollowMember(string $username): void{

        //verificare che l'utente sia registrato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}

        $following = "giangiacomo"; //lo si recupera dall'url

        //recupero dalla sessione il mio username => $follower = $username
        $follower = "matteo";

        $following = FPersistentManager::load("EMember",null,$following,null,null,
            null,null,null,false);
        $follower = FPersistentManager::load("EMember",null,$follower,null,null,
            null,null,null,false);

        FPersistentManager::unfollow($follower,$following);

    }

    /*
    metodo che serve per far registrare l'utente, ci sara' una form ed una richiesta fatta in post
    alla seguente url : localhost/member/registrazione-member
    */
    public static function registrazioneMember(): void{
        $view = new VLogin();
        $array_credenziali = $view->RegistrazioneCredenziali();
        if($array_credenziali[0] == null || $array_credenziali[1] == null){
            $view_errore = new VErrore();
            $view_errore->error(6);
        }
        else{
            $username = $array_credenziali[0];
            $password = $array_credenziali[1];
            $bio = $array_credenziali[2];
            $data = new DateTime(); //il format giusto poi lo fa Foundation
            $foto_profilo = $view->RegistrazioneImmagineProfilo();
            //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
            //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
            //qua se l'img è null pazienza
            $member = new EMember($username, $data, $bio, 0, null, null, null, null);
            FPersistentManager::store($member, null, $password, null, null, $foto_profilo['img'],
                $foto_profilo['type'], $foto_profilo['size']); //immagino si chiami così poi boh
        }
    }

    public static function paginaRegistrazione():void{
        //TODO: ha l'unico compito di fare il display del template di registrazione
    }


    /*
     richiesta in get con url  localhost/member/cerca-member/username, viene chiamato quando nella barra di ricerca
    si vuole cercare un member passando il suo username
    */
    public static function cercaMember(string $username): void{
        /*lo username lo recuperiamo dalla view dato che arrivera nell'array $get */
        //in teoria qua siamo sicuri che la checkbox abbia Member come valore, per come
        //avevamo discusso l'url nella riunione del 14/6
        $view = new VRicerca();
        $username = $view->eseguiRicerca();
        $member = FPersistentManager::load("EMember",null,$username,null,null,
            null,null,null,false);
        $array_risultati = array($member); //faccio così perché la view vuole sempre un array come parametro
        $view->avviaPaginaRicerca($array_risultati);
    }
}