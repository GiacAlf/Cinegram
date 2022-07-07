<?php

class CProfilo {

    /*
    metodo chiamato quando l'utente registrato vuole accedere al suo profilo(ci sara' nella homepage un
    bottone da premere), inviera' una url in get
    localhost/profilo/carica-profilo/username
    */
    public static function caricaProfilo(string $username): void {

        if(SessionHelper::isLogged() && $username == SessionHelper::getUtente()->getUsername()) {
            if(FPersistentManager::exist("EUser", null, $username, null, null, null, null,
                null, null)) {
                $numeroEstrazioni = 2;
                //oppure viene passato nell'url. è uguale
                //$username = SessionHelper::getUtente()->getUsername();
                $view = new VUtenteSingolo();
                $member = FPersistentManager::load("EMember", null, $username, null, null,
                    null, null, null, true);
                $immagineProfilo = FPersistentManager::loadImmagineProfilo($member, true);
                $filmVisti = FPersistentManager::calcolaNumeroFilmVisti($member);
                $following = FPersistentManager::calcolaNumeroFollowing($member);
                $follower = FPersistentManager::calcolaNumeroFollower($member);
                $utentiPopolari = FPersistentManager::caricaUtentiPiuPopolari($numeroEstrazioni);
                $immaginiMembers = FPersistentManager::loadImmaginiProfiloMembers($utentiPopolari, false);
                $view->avviaPaginaUtente($member, $immagineProfilo, $filmVisti, $following, $follower,
                    false, $utentiPopolari, $immaginiMembers);
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
    l'utente vuole aggiornare la sua immagine di profilo(ne mettiamo una di default,il classico avatar grigio di tutti i profili)
    dopo imposteremo questa cosa, ovvero se nel db non ne troviamo caricata nessuna, mettiamo quella di default. L'utente carichera'
    la foto con la form per i file vista a lezione. Url localhost/profilo/aggiorna-immagine
    */

    public static function aggiornaImmagine(): void {

        //verifica che l'utente sia registrato
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member"){
            $username = SessionHelper::getUtente()->getUsername();
            $view = new VUtenteSingolo();
            //recuperare dalla view giusta i dati dell'immagine
            $nuova_foto = $view->aggiornaFoto();
            //se nuova foto è null, si chiama da qua la schermata di errore?
            //no, secondo me dato che non è obbligatorio avere la nuova foto secondo me
            //si può fare header ... e basta
            if($nuova_foto != null) {
                //$view_errore = new VErrore();
                //$view_errore->error(4);
                FPersistentManager::updateImmagineProfilo($username , $nuova_foto['tmp_name'], $nuova_foto['type'],
                    $nuova_foto['size']);
            }
            //ricaricare la pagina del member col l'immagine cambiata tramite il metodo sopra.
            header("Location: https://" . VUtility::getRootDir() . "/profilo/carica-profilo/" . $username);
            //qui reinderizzo alla pagina dell'utente
        }
        else {
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
    L'utente vuole modificare la sua bio, di default all'iscrizione ne faremo mettere una oppure
    mettiamo stringa vuota e le deve modificare lui la prima volta tramite questo metodo(?), da vedere.
    Associamo una richiesta http fatta in get con url localhost/profilo/aggiorna-bio
    */
    public static function aggiornaBio(): void {

        //verificare che l'utente è registrato e caricare il suo username dalla sessione
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            $username = SessionHelper::getUtente()->getUsername();
            $view = new VUtenteSingolo();
            //recupero dalla view la nuova bio
            $updatedBio = $view->aggiornaBio();
            $member = FPersistentManager::load("EMember",null,$username,null,
                null,null,null,null,false);
            //un po' come il metodo di sopra
            if($updatedBio != null) {
                FPersistentManager::updateBio($member, $updatedBio);
            }
            //ricaricare la pagina con la bio aggiornata tramite il metodo sopra
            header("Location: https://" . VUtility::getRootDir() . "/profilo/carica-profilo/" . $username);
            //qui reinderizzo alla pagina dell'utente
        }
        else {
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
    l'utente puo' aggiornare la sua password tramite questo bottone che avra' associato una url
    localhost/profilo/aggiorna-password, metodo post dove inviera' la nuova password
    */

    public static function aggiornaPassword(): void {

        /* recupero della nuova password dalla form, ma questa funzione puo' essere
        chiamata solo dal member registrato oppure anche un member che non se la ricorda nella schermata di login(?) */
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            $username = SessionHelper::getUtente()->getUsername();
            $view = new VUtenteSingolo();
            $vecchiaPassword = $view->recuperaVecchiaPassword();
            $nuovaPassword = $view->aggiornaPassword();
            $confermaNuovaPassword = $view->verificaConfermaPassword();

            //TODO:fare un metodo in foundation che prende uno username mi dice la sua password attuale
            $esattezzaVecchiaPassword = FPersistentManager::userRegistrato($username,$vecchiaPassword);

            //QUANDO è CHE FACCIO VEDERE LA SCHERMATA DI ERRORE:
            //1) se la nuova pw è null
            //2) se la vecchia password non coincide con quella attuale -> una roba tipo getPassword()(il TODO SOPRA9
            //3) se le nuova pw e la conferma pw sono due stringhe diverse
            //se nuova password è null, si chiama da qua la schermata di errore? -> bisognerà controllare qua anche l'espressione
            //regolare? O lo si fa nella view?

            if($nuovaPassword == null || $confermaNuovaPassword == null || $vecchiaPassword == null) {
                $view_errore = new VErrore();
                $view_errore->error(6);
            }
            elseif(!$esattezzaVecchiaPassword) {
                $view_errore = new VErrore();
                $view_errore->error(10);
            }
            elseif($nuovaPassword != $confermaNuovaPassword) {
                $view_errore = new VErrore();
                $view_errore->error(6);
            }
            else {
                $member = FPersistentManager::load("EMember", null, $username, null, null, null,
                    null, null, false);
                FPersistentManager::updatePassword($member, $nuovaPassword);
                //notifica che sto a salva le robe
                header("Location: https://" . VUtility::getRootDir() . "/profilo/carica-profilo/" . $username);
                //qui reinderizzo alla pagina dell'utente
            }
        }
        else {
            $view = new VErrore();
            $view->error(8);
        }
    }


    //localhost/profilo/modifica-profilo
    public static function modificaProfilo(): void {

        //prendo l'utente dalla sessione, oppure lo passo nell'url per far i controlli?
        //no perché la riga 158 è come se fosse un controllo di sicurezza: sono sicuro di prendere l'utente della sessione
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            $username = SessionHelper::getUtente()->getUsername();
            $member = FPersistentManager::load("EMember",null, $username,null,null,
                null,null,null,false);
            $view = new VUtenteSingolo();
            $immagineProfilo = FPersistentManager::loadImmagineProfilo($member, true);
            $view->avviaPaginaModificaUtente($member, $immagineProfilo);
            //faccio vedere il template
        }
        else {
            $view = new VErrore();
            $view->error(8);
        }
    }
}