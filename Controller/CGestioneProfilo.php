<?php

class CGestioneProfilo {

    /*
    metodo chiamato quando l'utente registrato vuole accedere al suo profilo(ci sara' nella homepage un
    bottone da premere), inviera' una url localhost/profilo in get
    */
    public static function caricaProfilo(): void{
        //if(SessionHelper::isLogged()){
          //  $username = SessionHelper::getUtente()->getUsername();
        //}

        $username = "pippo";
        $view = new VUtenteSingolo();
        $member = FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,true);
        //FPersistentManager::loadImmagineProfilo($member,true):
        //carica immagina di profilo
        $filmVisti = FPersistentManager::calcolaNumeroFilmVisti($member);
        $following = FPersistentManager::calcolaNumeroFollowing($member);
        $follower = FPersistentManager::calcolaNumeroFollower($member);
        $view->avviaPaginaUtente($member, $filmVisti, $following, $follower);
    }

    /*
    l'utente vuole aggiornare la sua immagine di profilo(ne mettiamo una di default,il classico avatar grigio di tutti i profili)
    dopo imposteremo questa cosa, ovvero se nel db non ne troviamo caricata nessuna, mettiamo quella di default. L'utente carichera'
    la foto con la form per i file vista a lezione. Url localhost/profilo/aggiornaimmagine
    */

    public static function aggiornaImmagineProfilo(): void{

        //verifica che l'utente sia registrato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        $username = "proz";
        $view = new VUtenteSingolo();
        //recuperare dalla view giusta i dati dell'immagine
        $nuova_foto = $view->aggiornaFoto();

        //se nuova foto è null, si chiama da qua la schermata di errore?
        if ($nuova_foto == null){
            $view_errore = new VErrore();
            $view_errore->error(4);
        }

        /*tramite un metodo che dopo faremo controllare che l'immagina caricata
        rispetti i requisiti da noi imposti, sul content-type, sulla size etc*/
        //TODO: io passerò sempre l'array $_FILES per intero, dopo aver fatto tutti i check dovuti
        //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
        //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)

        /*se l'immagina supera i controlli allora chiamare
        FPersistentManager:store*/

        //ricaricare la pagina del member col l'immagine cambiata tramite il metodo sopra.
        //notifica che sto a salva le robe
        header("Location  localhost/profilo/?username=" . $username); //qui reinderizzo alla pagina dell'utente
    }

    /*
     *  L'utente vuole modificare la sua bio, di default all'iscrizione ne faremo mettere una oppure
    mettiamo stringa vuota e le deve modificare lui la prima volta tramite questo metodo(?), da vedere.
    Associamo una richiesta http fatta in get con url localhost/profilo/aggiornabio

    */
    public static function aggiornaBioProfilo(): void{

        //verificare che l'utente è registrato e caricare il suo username dalla sessione
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        $view = new VUtenteSingolo();
        //recupero dalla view la nuova bio
        $updatedBio = "ciao questa è la bio di prova inviata tramite richiesta http col metodo post";
        $updatedBio = $view->aggiornaBio();
        // TODO prendere member dalla SESSION
        $username = "matteo";
        $member = FPersistentManager::load("EMember",null,$username,null,
            null,null,null,null,false);

        FPersistentManager::updateBio($member, $updatedBio);

        //ricaricare la pagina con la bio aggiornata tramite il metodo sopra
        //notifica che sto a salva le robe
        header("Location localhost/profilo/?username=" . $username); //qui reinderizzo alla pagina dell'utente

    }

    /*
    l'utente puo' aggiornare la sua password tramite questo bottone che avra' associato una url
    localhost/profilo/aggiornapw, metodo post dove inviera' la nuova password
    */

    public static function aggiornaPasswordMember(): void{
        /*recupero della nuova password dalla form, ma questa funzione puo' essere
        chiamata solo dal member registrato oppure anche un member che non se la ricorda nella schermata di login(?)*/
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}
        $view = new VUtenteSingolo();
        $nuovaPassword = "paperino";
        $nuovaPassword = $view->aggiornaPassword();

        //se nuova password è null, si chiama da qua la schermata di errore? -> bisognerà controllare qua anche l'espressione
        //regolare? O lo si fa nella view?
        if ($nuovaPassword == null){
            $view_errore = new VErrore();
            $view_errore->error(5);
        }

        $username = "damiano";
        $member = FPersistentManager::load("EMember",null,$username,null,null,null,
            null,null,false);
        FPersistentManager::updatePassword($member,$nuovaPassword);
        //notifica che sto a salva le robe
        header("Location  localhost/profilo/?username=" . $username); //qui reinderizzo alla pagina dell'utente
    }
}