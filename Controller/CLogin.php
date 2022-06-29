<?php

class CLogin {
    /*
    metodo che permette al member di fare login, ci sara' una form che inviera' i dati in post
    propongo una url localhost/login/verifica-login
     */
    public static function verificaLogin(): void{
        /* recupero i dati dalla view in $POST[username] e $POST[password]
        */
        $username = null;
        $password = null;
        $view = new VLogin();
        $array_credenziali = $view->verificaLogin();
        //se è pieno il campo username E il campo password, parte tutto il codice, sennò subito l'errore
        if($array_credenziali[0] != null && $array_credenziali[1] != null) {
            $username = "martin"; // = $array_credenziali[0]
            $password = "scorsese"; // = $array_credenziali[1]
            if (FPersistentManager::userRegistrato($username, $password) && !FPersistentManager::userBannato($username)) {
                /*decidere se mettere tutto l'oggetto in sessione oppure solo lo username, io propongo per la seconda.
                Dopo dobbiamo discriminare tra member ed admin quindi */
                $chiSei = FPersistentManager::tipoUserRegistrato($username);
                // print($chiSei);
                $utente = null;
                //se sei un member ti faccio vedere la pagina VUtenteSingolo sennò la VAdmin
                if ($chiSei == "Member") {
                    //c'è la possibilità di chiamare il cercaMember, ma boh
                    $view_member = new VUtenteSingolo();
                    $utente = FPersistentManager::load("EMember", null, $username, null,
                        null, null, null, null, false);
                    $utente_completo = FPersistentManager::load("EMember", null, $username, null,
                        null, null, null, null, true);
                    $immagine_profilo = FPersistentManager::loadImmagineProfilo($utente, true);
                    $seguito = false; //perché avvio la pagina dell'utente della sessione in teoria
                    $utentiPiuPopolari=FPersistentManager::caricaUtentiPiuPopolari(5);
                    $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuPopolari, false);
                    $view_member->avviaPaginaUtente($utente_completo, $immagine_profilo, FPersistentManager::calcolaNumeroFilmVisti($utente_completo),
                        FPersistentManager::calcolaNumeroFollowing($utente_completo), FPersistentManager::calcolaNumeroFollower($utente_completo),
                        $seguito, $utentiPiuPopolari, $immaginiUtentiPopolari);
                } else {
                    $view_admin = new VAdmin();
                    $utente = FPersistentManager::load("EAdmin", null, $username, null,
                        null, null, null, null, false);
                    $view_admin->avviaPaginaAdmin($utente); //visualizzo l'admin
                }
                //avvia la sessione con l'oggetto non completo
                SessionHelper::login($utente);
            }
            //oppure elseif qui? forse no, perché se questa condizione è corretta vuol dire che le credenziali sono corrette
            if (FPersistentManager::userBannato($username)) {
                print("sei bannato");
                /*chiamo una schermata di errore che dice che l'utente
                che ha fatto il login è in realta bannato, dobbiamo notificarlo*/
                //si chiama VErrore, con il suo id numerico
                $view_errore = new VErrore();
                $view_errore->error(7);
            }
            //oppure elseif qui?
            if (!FPersistentManager::userRegistrato($username, $password)) {
                /* mostrare la classica schermata che dice che username e password non corrispondo*/
                print ("username e password non corrispondo");
                //chiamo la VErrore con il suo id numerico
                $view_errore = new VErrore();
                $view_errore->error(1);
            }
        }
        else{
            $view_errore = new VErrore();
            $view_errore->error(1);
        }
    }


    /*
     metodo che serve solo a caricare soltanto la pagina di login
    url: localhost/login/pagina-login
     */
    public static function paginaLogin(): void{
        $view = new VLogin();
        $view->avviaPaginaLogin();
    }

    /*L'utente clicca su questo pulsante e semplicemente verra' effettuato il classico logout
    associo una url localhost/login/logout-member
    */
    public static function logoutMember(): void{
        /*
        l'unica cosa da fare qui dentro è distruggere completamente la sessione cosi' che
        l'utente dovra' fare nuovamente il login perche si distrugge la cartella associata a lui
        sul server grazie a session_destroy(), eliminiamo gli array in ram con unset() e possiamo anche
        inviare un cookie con chiave PHPSESSID e valore ""*/
        SessionHelper::logout(); //poi reinderizzo all'home page, oppure lo si fa
        //nei metodi di session helper
        header("Location: https://localhost/homepage/imposta-homepage");
    }
}