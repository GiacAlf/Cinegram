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
        //ridai un booleano identificato. TRUE se è member registrato, FALSE se non lo è
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
    al seguente url localhost/member/username=.../-1, lo username da seguire lo dara' il bottone
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
    al seguente url localhost/member/username=..../-2, lo username da unfolloware lo dara' il bottone
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

    //TODO: metodo per registrarsi

    //TODO:metodo cercaMember -> si guardi il metodo cercaFilm in CInterazioneFilm

}