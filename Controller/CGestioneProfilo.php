<?php

class CGestioneProfilo
{
    /* metodo chiamato quando l'utente registrato vuole accedere al suo profilo(ci sara' nella homepage un
    bottone da premere), inviera' una url localhost/profilo
    */
    public static function caricaProfilo(){

        /*bastera' controllare se l'utente è registrato e prendere
        dalla sessione il suo username*/
        $username="pippo";

        $member=FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,null,true);
        //FPersistentManager::loadImmagineProfilo($member,true):
        //carica immagina di profilo
        $filmvisti=FPersistentManager::calcolaNumeroFilmVisti($member);
        $following=FPersistentManager::calcolaNumeroFollowing($member);
        $follower=FPersistentManager::calcolaNumeroFollower($member);

        //chiamare view responsabile della

    }

    /*l'utente vuole aggiornare la sua immagine di profilo(ne mettiamo una di default,il classico avatar grigio di tutti i profili)
    dopo imposteremo questa cosa, ovvero se nel db non ne troviamo caricata nessuna, mettiamo quella di default. L'utente carichera'
    la foto con la form per i file vista a lezione. Url localhost/profilo/1  */

    public static function aggiornaImmagineProfilo(){

        //verifica che l'utente sia registrato

        //recuperare dalla view giusta i dati dell'immagine

        /*tramite un metodo che dopo faremo controllare che l'immagina caricata
        rispetti i requisiti da noi imposti, sul content-type, sulla size etc*/

        /*se l'immagina supera i controlli allora chiamare
        FPersistentManager:store*/

        //ricaricare la pagina del member col l'immagine cambiata tramite il metodo sopra.


    }

    /* L'utente vuole modificare la sua bio, di default all'iscrizione ne faremo mettere una oppure
    mettiamo stringa vuota e le deve modificare lui la prima volta tramite questo metodo(?), da vedere.
    Associamo una richiesta http fatta in post con url localhost/profilo/2

    */
    public static function aggiornaBioProfilo(){

        //verificare che l'utente è registrato e caricare il suo username dalla sessione

        //recupero dalla view la nuova bio
        $updatedBio="ciao questa è la bio di prova inviata tramite richiesta http col metodo post";

        $username="matteo";
        $member=FPersistentManager::load("EMember",null,$username,null,
            null,null,null,null,false);

        FPersistentManager::updateBio($member,$updatedBio);

        //ricaricare la pagina con la bio aggiornata tramite il metodo sopra

    }






}