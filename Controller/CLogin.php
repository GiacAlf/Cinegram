<?php

class CLogin
{
    /* metodo che permette al member di fare login, ci sara' una form che inviera' i dati in post
    propongo una url localhost/login/accesso(-1) */
    public static function VerificaLogin(){
        /* recupero i dati dalla view in $POST[username] e $POST[password]
        inizializzo la sessione
        */
        $username="martin";
        $password="scorsese";
        if (FPersistentManager::userRegistrato($username,$password) && !FPersistentManager::userBannato($username)){
            /*decidere se mettere tutto l'oggetto in sessione oppure solo lo username, io propongo per la seconda.

            Dopo dobbiamo discriminare tra member ed admin quindi */
            $chiSei=FPersistentManager::tipoUserRegistrato($username,$password);
            print($chiSei);
            //se sei un member ti faccio vedere la pagina VUtenteSingolo sennò la VAdmin
            /*chiamero' la view che gestira' l'admin se $cosaSei="Admin"
            altrimenti chiamo quella del member, oppure faccio decidere a smarty(?)*/
            //qua parte la sessione

        }
        if (FPersistentManager::userBannato($username)){
            print("sei bannato");

            /*chiamo una schermata di errore che dice che l'utente
            che ha fatto il login è in realta bannato, dobbiamo notificarlo*/
            //si chiama VErrore, con il suo id numerico


        }
        if (!FPersistentManager::userRegistrato($username,$password)){
            /* mostrare la classica schermata che dice che username e password non corrispondo*/
            print ("username e password non corrispondo");
            //chiamo la VErrore con il suo id numerico

        }
    }

    //TODO: metodo che chiama unicamente la pagina del Login(VLogin)

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

}