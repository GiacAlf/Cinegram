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
        $ultimeAttivita = array();
        $identificato = false;
        //controlli per quanto riguarda l'utente loggato o meno
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}

        //lo username come sempre lo prendo dalla sessione
        //prima controllo se l'utente è loggato ed è un member (metodo Foundation apposito)
        //e poi discrimino
        if($identificato){
            $username = "Matteo";
            $member = FPersistentManager::load("EMember",null,$username,null,
                null,null,null,null,false);
            $ultimeAttivita=FPersistentManager::caricaUltimeAttivitaUtentiSeguiti($member,6);
        }
        else{
            $ultimeAttivita=FPersistentManager::caricaUltimeAttivita(5);
        }
        $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(3);

        $view = new VMembers();
        //caricare di tutti i members le locandine small

        //ridai un booleano identificato. TRUE se è member registrato, FALSE se non lo è
        //carica le foto per ogni utente (avatar piccolo)
        //al metodo della view vengono passati comunque due array, un booleano e le foto poi

         /* passo questi dati ad un unico metodo di una view insieme ad un parametro
         per discriminare l'utente registrato da quello non registrato oppure ci saranno
         due metodi della view separati, uno per la grafica di ogni tipologia di utente(la
         prima è sicuramente migliore)*/
        $view->avviaPaginaMembers($ultimeAttivita, $utentiPiuPopolari, $identificato);
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
        //caricare l'immagine del profilo di tutti i member in size small
        //FPersistentManager::loadImmagineProfilo($member,true);

        // TODO se sei l'admin carica una pagina per fare le cose dell'admin sull'utente
        if(SessionHelper::getUtente()->chiSei() == "Admin"){ //ma se ho un utente non registrato che succede?
            $view_admin = new VAdmin(); //in teoria la stringa a sinistra dovrebbe essere null, si spera
            $view_admin->avviaPaginaModeraUtente($member);
        }
        else {
            //TODO if($user:chiSei == "Admin") chiama la VAdmin sennò la VFilms
            $view->avviaPaginaUtente($member, $filmvisti, $following, $follower);
        }
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