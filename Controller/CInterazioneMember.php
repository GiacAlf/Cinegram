<?php

class CInterazioneMember
{
    /*L'utente clicca su Members ed a seconda se è registrato oppure no vedra' la stessa
    schermata con diversi dati, le diverse schermate le potrebbe gestire Smarty, noi gli passiamo
    un parametro registrato o non registrato e lei capisce, oppure fare due schermate diverse che
    richiamiamo noi dentro questo metodo. Sara' associata una url del tipo localhost/members*/

    public static function caricaMembers(){
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
            $username="Matteo";
            $member=FPersistentManager::load("EMember",null,$username,null,
                null,null,null,null,null,false);
            $ultimeAttivita=FPersistentManager::caricaUltimeAttivitaUtentiSeguiti($member,6);
        }
        else{
            $ultimeAttivita=FPersistentManager::caricaUltimeAttivita(5);
        }
        $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(3);

        $view = new VMembers();
        //caricare di tutti i members le locandine small
        print_r($ultimeAttivita);
        print_r($ultimeAttivita);
        print_r($utentiPiuPopolari);
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
    url localhost/member/username con metodo get-> infatti lo username viene passato dall'url */
    public static function caricaMember($username){

        $view = new VUtenteSingolo();
        $member=FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,true);
        $filmvisti=FPersistentManager::calcolaNumeroFilmVisti($member);
        $following=FPersistentManager::calcolaNumeroFollowing($member);
        $follower=FPersistentManager::calcolaNumeroFollower($member);
        //caricare l'immagine del profilo di tutti i member in size small
        //FPersistentManager::loadImmagineProfilo($member,true);

        /* dare tutti i dati alla view che fara' il display*/
        $view->avviaPaginaUtente($member, $filmvisti, $following, $follower);

    }

    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' seguire il member, sara' una richiesta in post
    al seguente url localhost/member/username=.../-1, lo username da seguire lo dara' il bottone
    cliccato. */
    public static function seguiMember(){

        //verificare che l'utente sia registrato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}


        $following="giangiacomo"; //lo si recupera dall'url

        //recupero dalla sessione il mio username
        $follower="matteo";
        $following=FPersistentManager::load("EMember",null,$following,null,null,
        null,null,null,false);
        $follower=FPersistentManager::load("EMember",null,$follower,null,null,
            null,null,null,false);

        FPersistentManager::follow($follower, $following);



    }


    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' unfolloware il member, sara' una richiesta in post
    al seguente url localhost/member/username=..../-2, lo username da unfolloware lo dara' il bottone
    cliccato. */

    public static function togliMember(){


        //verificare che l'utente sia registrato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();

        //}

        $following="giangiacomo"; //lo si recupera dall'url

        //recupero dalla sessione il mio username
        $follower="matteo";

        $following=FPersistentManager::load("EMember",null,$following,null,null,
            null,null,null,false);
        $follower=FPersistentManager::load("EMember",null,$follower,null,null,
            null,null,null,false);

        FPersistentManager::unfollow($follower,$following);

    }


    //TODO: metodo per registrarsi

    //TODO:metodo cercaMember -> si guardi il metodo cercaFilm in CInterazioneFilm

}