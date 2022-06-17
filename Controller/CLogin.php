<?php

class CLogin {
    /* metodo che permette al member di fare login, ci sara' una form che inviera' i dati in post
    propongo una url localhost/login/accesso(-1) */
    public static function verificaLogin(): void{
        /* recupero i dati dalla view in $POST[username] e $POST[password]
        */
        $username = null;
        $password = null;
        $view = new VLogin();
        $array_credenziali = $view->verificaLogin();
        if($array_credenziali[0] == null || $array_credenziali[1] == null){
            $view_errore = new VErrore();
            $view_errore->error(1);
        }
        else { //[Damiano] forse ho sbagliato questo if else, è giusto???? -> il dubbio mi viene dal metodo Registrazione in CInterazioneMember
            $username = "martin"; // = $array_credenziali[0]
            $password = "scorsese"; // = $array_credenziali[1]
        }
        if (FPersistentManager::userRegistrato($username, $password) && !FPersistentManager::userBannato($username)){
            /*decidere se mettere tutto l'oggetto in sessione oppure solo lo username, io propongo per la seconda.

            Dopo dobbiamo discriminare tra member ed admin quindi */
            $chiSei = FPersistentManager::tipoUserRegistrato($username);
            // print($chiSei);
            $utente = null;
            //se sei un member ti faccio vedere la pagina VUtenteSingolo sennò la VAdmin
            /*chiamero' la view che gestira' l'admin se $cosaSei="Admin"
            altrimenti chiamo quella del member, oppure faccio decidere a smarty(?)*/
            if ($chiSei == "Member"){
                $view_member = new VUtenteSingolo();
                $utente = FPersistentManager::load("EMember",null, $username,null,
                    null,null,null,null,true);
                $view_member->avviaPaginaUtente($utente, FPersistentManager::calcolaNumeroFilmVisti($utente),
                    FPersistentManager::calcolaNumeroFollowing($utente), FPersistentManager::calcolaNumeroFollower($utente));
            }
            else{
                $view_admin = new VAdmin();
                $utente = FPersistentManager::load("EAdmin", null, $username, null,
                null, null, null, null, false);
                $view_admin->avviaPaginaAdmin($utente); //visualizzo l'admin
            }
            SessionHelper::login($utente);
        }
        if (FPersistentManager::userBannato($username)){
            print("sei bannato");

            /*chiamo una schermata di errore che dice che l'utente
            che ha fatto il login è in realta bannato, dobbiamo notificarlo*/
            //si chiama VErrore, con il suo id numerico
            $view_errore = new VErrore();
            $view_errore->error(7);
        }
        if (!FPersistentManager::userRegistrato($username, $password)){
            /* mostrare la classica schermata che dice che username e password non corrispondo*/
            print ("username e password non corrispondo");
            //chiamo la VErrore con il suo id numerico
            $view_errore = new VErrore();
            $view_errore->error(1);
        }
    }


    //TODO: metodo che chiama unicamente la pagina del Login(VLogin)
    //piccola bozza, poi matte' miglioralo tu, l'url può essere localhost/login
    public static function paginaLogin(): void{
        $view = new VLogin();
        $view->avviaPaginaLogin();
    }

    /*L'utente clicca su questo pulsante e semplicemente verra' effettuato il classico logout
    associo una url localhost/logout
    */
    public static function logoutMember(): void{
        /*
        l'unica cosa da fare qui dentro è distruggere completamente la sessione cosi' che
        l'utente dovra' fare nuovamente il login perche si distrugge la cartella associata a lui
        sul server grazie a session_destroy(), eliminiamo gli array in ram con unset() e possiamo anche
        inviare un cookie con chiave PHPSESSID e valore ""*/
        SessionHelper::logout(); //tutto qua giusto?
    }
}