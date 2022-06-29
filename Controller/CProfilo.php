<?php

class CProfilo {

    /*
    metodo chiamato quando l'utente registrato vuole accedere al suo profilo(ci sara' nella homepage un
    bottone da premere), inviera' una url in get
    localhost/profilo/carica-profilo
    */
    public static function caricaProfilo(): void{
        if(!SessionHelper::isLogged()){
            $view = new VErrore();
            $view->error(8);
        }

        $numeroEstrazioni=5;

        $username = SessionHelper::getUtente()->getUsername();
        $view = new VUtenteSingolo();
        $member = FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,true);
        $immagineProfilo = FPersistentManager::loadImmagineProfilo($member, true);
        $filmVisti = FPersistentManager::calcolaNumeroFilmVisti($member);
        $following = FPersistentManager::calcolaNumeroFollowing($member);
        $follower = FPersistentManager::calcolaNumeroFollower($member);
        $utentiPopolari= FPersistentManager::caricaUtentiPiuPopolari($numeroEstrazioni);
        $immaginiMembers = FPersistentManager::loadImmaginiProfiloMembers($utentiPopolari , false);
        $view->avviaPaginaUtente($member , $immagineProfilo, $filmVisti, $following,$follower,
        false, $utentiPopolari, $immaginiMembers);
    }

    /*
    l'utente vuole aggiornare la sua immagine di profilo(ne mettiamo una di default,il classico avatar grigio di tutti i profili)
    dopo imposteremo questa cosa, ovvero se nel db non ne troviamo caricata nessuna, mettiamo quella di default. L'utente carichera'
    la foto con la form per i file vista a lezione. Url localhost/profilo/aggiorna-immagine
    */
    //TODO: avevamo stabilito che la view si recuperasse dalla sessione lo username, il controllore fa solo il controllo sul login

    public static function aggiornaImmagine(): void{

        //verifica che l'utente sia registrato
        if(!SessionHelper::isLogged()){
            $view = new VErrore();
            $view->error(8);
        }
        $username = SessionHelper::getUtente()->getUsername();
        $view = new VUtenteSingolo();
        //recuperare dalla view giusta i dati dell'immagine
        $nuova_foto = $view->aggiornaFoto();

        //se nuova foto è null, si chiama da qua la schermata di errore?
        if ($nuova_foto == null){
            $view_errore = new VErrore();
            $view_errore->error(4);
        }


        /*
         la view passerà sempre l'array $_FILES per intero, dopo aver fatto tutti i check dovuti
         le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (il path nel server della nuova immagine),
        $_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
        */

       FPersistentManager::updateImmagineProfilo($username , $nuova_foto['tmp_name'], $nuova_foto['size'],
       $nuova_foto['type']);

        //ricaricare la pagina del member col l'immagine cambiata tramite il metodo sopra.
        header("Location: localhost/member/carica-member/" . $username);
        //qui reinderizzo alla pagina dell'utente
    }

    /*
     *  L'utente vuole modificare la sua bio, di default all'iscrizione ne faremo mettere una oppure
    mettiamo stringa vuota e le deve modificare lui la prima volta tramite questo metodo(?), da vedere.
    Associamo una richiesta http fatta in get con url localhost/profilo/aggiorna-bio

    */
    public static function aggiornaBio(): void{

        //verificare che l'utente è registrato e caricare il suo username dalla sessione
        if(!SessionHelper::isLogged()){
            $view = new VErrore();
            $view->error(8);
        }

        $username = SessionHelper::getUtente()->getUsername();

        $view = new VUtenteSingolo();
        //recupero dalla view la nuova bio
        $updatedBio = $view->aggiornaBio();
        $member = FPersistentManager::load("EMember",null,$username,null,
            null,null,null,null,false);

        FPersistentManager::updateBio($member, $updatedBio);

        //ricaricare la pagina con la bio aggiornata tramite il metodo sopra

        header("Location: localhost/member/carica-member/" . $username);
        //qui reinderizzo alla pagina dell'utente

    }

    /*
    l'utente puo' aggiornare la sua password tramite questo bottone che avra' associato una url
    localhost/profilo/aggiorna-password, metodo post dove inviera' la nuova password
    */

    public static function aggiornaPassword(): void{
        /*recupero della nuova password dalla form, ma questa funzione puo' essere
        chiamata solo dal member registrato oppure anche un member che non se la ricorda nella schermata di login(?)*/
        if(!SessionHelper::isLogged()){
            $view = new VErrore();
            $view->error(8);
        }

        $username = SessionHelper::getUtente()->getUsername();
        $view = new VUtenteSingolo();
        $vecchiaPassword = $view->recuperaVecchiaPassword();
        $nuovaPassword = $view->aggiornaPassword();
        $confermaNuovaPassword = $view->verificaConfermaPassword();

        //TODO:fare un metodo in foundation che prende uno username mi dice la sua password attuale
        $vecchiaPasswordDalDb="ciao";

        //QUANDO è CHE FACCIO VEDERE LA SCHERMATA DI ERRORE:
        //1) se la nuova pw è null
        //2) se la vecchia password non coincide con quella attuale -> una roba tipo getPassword()(il TODO SOPRA9
        //3) se le nuova pw e la conferma pw sono due stringhe diverse
        //se nuova password è null, si chiama da qua la schermata di errore? -> bisognerà controllare qua anche l'espressione
        //regolare? O lo si fa nella view?

        //TODO: costruire nella VErrore i casi sopra citati
        if ($nuovaPassword == null){
            $view_errore = new VErrore();
            $view_errore->error(5);
        }
        elseif ($vecchiaPassword != $vecchiaPasswordDalDb){
            $view_errore = new VErrore();
            $view_errore->error(5);
        }
        elseif ($nuovaPassword != $confermaNuovaPassword){
            $view_errore = new VErrore();
            $view_errore->error(5);
        }
        $member = FPersistentManager::load("EMember",null,$username,null,null,null,
            null,null,false);
        FPersistentManager::updatePassword($member,$nuovaPassword);
        //notifica che sto a salva le robe
        header("Location: localhost/member/carica-member/" . $username);
        //qui reinderizzo alla pagina dell'utente
    }

    //localhost/profilo/modifica-profilo
    public static function modificaProfilo(){
        //prendo l'utente dalla sessione
        if(!SessionHelper::isLogged()){
            $view = new VErrore();
            $view->error(8);
        }
        $username = SessionHelper::getUtente()->getUsername();
        $member = FPersistentManager::load("EMember",null, $username,null,null,
            null,null,null,false);
        $view = new VUtenteSingolo();
        $immagineProfilo=FPersistentManager::loadImmagineProfilo($member , true);
        $view->avviaPaginaModificaUtente($member, $immagineProfilo);
        //faccio vedere il template
    }
}