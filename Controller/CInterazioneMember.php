<?php

class CInterazioneMember
{
    /*L'utente clicca su Members ed a seconda se è registrato oppure no vedra' la stessa
    schermata con diversi dati, le diverse schermate le potrebbe gestire Smarty, noi gli passiamo
    un parametro registrato o non registrato e lei capisce, oppure fare due schermate diverse che
    richiamiamo noi dentro questo metodo. Sara' associata una url del tipo localhost/members*/

    public static function caricaMembers(){

        //controlli per quanto riguarda l'utente loggato o meno

        //lo username come sempre lo prendo dalla sessione
        $username="Matteo";
        $member=FPersistentManager::load("EMember",null,$username,null,
        null,null,null,null,null,false);
        $ultimeAttivitaSeguiti=FPersistentManager::caricaUltimeAttivitaUtentiSeguiti($member,6);
        $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(3);


        $ultimeAttivita=FPersistentManager::caricaUltimeAttivita(5);

        //caricare di tutti i members le locandine small
        print_r($ultimeAttivita);
        print_r($ultimeAttivitaSeguiti);
        print_r($utentiPiuPopolari);
        //carica le foto per ogni utente (avatar piccolo)

         /* passo questi dati ad un unico metodo di una view insieme ad un parametro
         per discriminare l'utente registrato da quello non registrato oppure ci saranno
         due metodi della view separati, uno per la grafica di ogni tipologia di utente(la
         prima è sicuramente migliore)*/


    }
    /*L'utente clicca sul singolo member per accedere alla sua pagina personale, avra' associato una
    url localhost/member/username con metodo get */
    public static function caricaMember($username){


        $member=FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,true);
        $filmvisti=FPersistentManager::calcolaNumeroFilmVisti($member);
        $following=FPersistentManager::calcolaNumeroFollowing($member);
        $follower=FPersistentManager::calcolaNumeroFollower($member);
        //caricare l'immagine del profilo di tutti i member in size small
        //FPersistentManager::loadImmagineProfilo($member,true);

        /* dare tutti i dati alla view che fara' il display*/



    }

    /* una volta fatto l'accesso ed essere entrato nella pagina del singolo member
    l'utente in sessione potra' seguire il member, sara' una richiesta in post
    al seguente url localhost/member/-1, lo username da seguire lo dara' il bottone
    cliccato. */
    public static function seguiMember(){

        //verificare che l'utente sia registrato

        //recuperare dalla view nell'array $post lo username del membro da seguire
        $following="giangiacomo";

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
    al seguente url localhost/member/-2, lo username da unfolloware lo dara' il bottone
    cliccato. */

    public static function togliMember(){


        //verificare che l'utente sia registrato

        //recuperare dalla view nell'array $post lo username del membro da seguire
        $following="giangiacomo";

        //recupero dalla sessione il mio username
        $follower="matteo";

        $following=FPersistentManager::load("EMember",null,$following,null,null,
            null,null,null,false);
        $follower=FPersistentManager::load("EMember",null,$follower,null,null,
            null,null,null,false);

        FPersistentManager::unfollow($follower,$following);

    }

    /* metodo che permette al member di fare login, ci sara' una form che inviera' i dati in post
    propongo una url localhost/member/-3 */
    public static function loginMember(){
        /* recupero i dati dalla view in $POST[username] e $POST[password]
        inizializzo la sessione
        */
        $username="martin";
        $password="scorsese";
        if (FPersistentManager::userRegistrato($username,$password) && !FPersistentManager::userBannato($username)){
            /*decidere se mettere tutto l'oggetto in sessione oppure solo lo username, io propongo per la seconda.

            Dopo dobbiamo discriminare tra member ed admin quindi */
            $cosaSei=FPersistentManager::tipoUserRegistrato($username,$password);
            print($cosaSei);

            /*chiamero' la view che gestira' l'admin se $cosaSei="Admin"
            altrimenti chiamo quella del member, oppure faccio decidere a smarty(?)*/

        }
        if (FPersistentManager::userBannato($username)){
            print("sei bannato");

            /*chiamo una schermata di errore che dice che l'utente
            che ha fatto il login è in realta bannato, dobbiamo notificarlo*/


        }
        if (!FPersistentManager::userRegistrato($username,$password)){
            /* mostrare la classica schermata che dice che username e password non corrispondo*/
            print ("username e password non corrispondo");



        }
    }

    /*L'utente clicca su questo pulsante e semplicemente verra' effettuato il classico logout
    associo una url localhost/member/-4
    */
    public static function logoutMember(){
        /*
        l'unica cosa da fare qui dentro è distruggere completamente la sessione cosi' che
        l'utente dovra' fare nuovamente il login perche si distrugge la cartella associata a lui
        sul server grazie a session_destroy(), eliminiamo gli array in ram con unset() e possiamo anche
        inviare un cookie con chiave PHPSESSID e valore ""*/

    }

    /*l'utente puo' aggiornare la sua password tramite questo bottone che avra' associato una url
    localhost/member/-5 , metodo post dove inviera' la nuova password */

    public static function AggiornaPasswordMember(){
        /*recupero della nuova password dalla form, ma questa funzione puo' essere
        chiamata solo dal member registrato oppure anche un member che non se la ricorda nella schermata di login(?)*/
        $nuovaPassword="paperino";
        $username="damiano";
        $member=FPersistentManager::load("EMember",null,$username,null,null,null,
        null,null,false);
        FPersistentManager::updatePassword($member,$nuovaPassword);
    }

}