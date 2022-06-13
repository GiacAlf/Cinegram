<?php

class CInterazioneFilm
{
    /* questo sara' il metodo associato alla ricerca del film per titolo avra' una URL
    del tipo localhost/film?titolo=titanic*/
    public static function cercaFilm(){
        /*il titolo lo recuperiamo dalla view dato che arrivera nell'array $get */

        $titolo="suspiria";

        $films = array();
        $films  =FPersistentManager::load("EFilm", null,null,null,
        null,null,$titolo,null,null,false);
       //caricare le locandine dell'array di film ricevute


        /*dovro' adesso dare questi film alla view che si occupa della visualizzazione dei risultati
        della ricerca

        view->impostaVisualizzazioneRisultati
         */


    }

    /*questo metodo verra' chiamato quando l'utente clicca su uno specifico film,
    sara' associata una url (secondo lo standard Restful) fatta in get del tipo localhost/film/id
    ,parsificando la stringa il front controller passera' l'id come parametro
     */
    public static function CaricaFilm(int $id){

        //restituzione del film completo

        $film=FPersistentManager::load("EFilm",$id,null,null,
        null,null,null,null,true);
        //$locandina=FPersistentManager::loadLocandina($film,true);
        //print_r($film);

        /*qui dovro' passare alla view che fara' il display della pagina
        del film singolo
        view->impostaPagina($films)
         */

    }

    /*questo metodo verra' chiamato quando un utente registrato vorra' scrivere una recensione
    ad un film. I dati verranno generati da una form. Sara' associato una url del tipo
    localhost/recensione   */
    public static function ScriviRecensione(){

        //verificare se lo username è loggato, dopo vedro' come fare.

        //chiamo la view che mi restituisce i dati per la creazione della recensione(presi dalla form)
        /* idfilm verra' restituito cosi' come il voto ed il testo
           la data viene creato in questo metodo al momento
           lo username è preso dalla sessione(?)
           $username=$SESSION["username"]
        */
        //prova
         //prova

        $idFilm=2;
        $username="damiano";
        $voto=3;
        $testo="prova";
        $data= new DateTime();
        $recensione=new ERecensione($idFilm, $username,$voto,$testo,$data,null);
        FPersistentManager::store($recensione,null,null,null,null,null,null
        ,null);

    }

    /* metodo che verra' chiamato quando un utente registrato vuole rispondere ad una recensione, sara' chiamato da una url
    localhost/risposta i dati come nella recensione vengono passati con una form */

    public static function ScriviRisposta(){
        //anche qui dobbiamo verificare se l'utente è loggato

        //chiamo la view che mi restituisce i dati per la creazione della risposta(presi dalla form)
        /* idfilm verra' restituito cosi' come il testo e lo usernameautorerecensione
           la data viene creato in questo metodo al momento
           lo usernameautore è preso dalla sessione(?)
           $username=$SESSION["username"]*/

        //prova

        $date= new DateTime();
        $usernameAutore="damiano";
        $testo="prova risposta";
        $idFilm=2;
        $usernameAutoreRecensione="matteo";

        $risposta = new ERisposta($usernameAutore, $date, $testo, $idFilm, $usernameAutoreRecensione);
        FPersistentManager::store($risposta,null,null,null,null,null,null,null);
    }

    /*metodo che verra' chiamato quando si vuole eliminare una recensione, adesso pero' dobbiamo fare
    delle considerazioni per quanto riguarda la URL da associare. Htlm prevede solo i metodi get e post quindi
    possiamo fare richieste solo con questi due, propongo di associargli localhost/recensione/-1 (sappiamo grazie
    a -1 che chiameremo questo metodo), ovviamente in post */

    public static function EliminaRecensione(){

        //verificare se utente è loggato

        /*avendo inviato in post la richiesta dovremmo sempre leggere
        dalla view
        ci facciamo inviare l'id del film ,che insieme allo usernameAutore(letto dalla sessione)
        formano la chiave primaria che identifica la recensione */

        $idFilm=2;
        $usernameAutore="pippo";
        FPersistentManager::delete("ERecensione",$usernameAutore,null,null,$idFilm,null);
    }



    /*metodo che verra' chiamato quando si vuole eliminare una risposta
    , propongo di associare ,localhost/risposta/-1, come fatto sopra. (sappiamo grazie
   a -1 che chiameremo questo metodo), ovviamente in post */

    public static function EliminaRisposta(){

        //verificare utente loggato

        //recupero dalla view i dati inviati dal client in post
        /* ci facciamo inviare la data e lo username lo prendiamo dalla sessione
        */

        $data = new DateTime();
        $usernameAutore="matteo";
        FPersistentManager::delete("ERisposta",$usernameAutore,null,null,null,$data);

    }


    /* supponendo ci sia un pulsante per caricare le risposte della recensione (Vedi risposte)
    allora associamo una url localhost/risposte in post */
    public static function caricaRisposte(){

        //leggere dalla view corrispondente i dati inviati, saranno la chiave che identifica la recensione
        //quindi usernameAutore e idfilm

        $usernameAutore="damiano";
        $idFilm=2;

        $risposte=FPersistentManager::loadRisposte($idFilm,$usernameAutore);
        print_r($risposte);

        /*dire alla view di farle vedere a schermo(?) o semplicemente
        cliccando sul buttone parte un js che carica una finestra (?) ,non ne ho idea*/



    }

    /*metodo che che parte quando si vuole aggiungere il film alla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/-1 , non possiamo scrivere /localhost/film/id si confonde
    con caricafilm , metodo post*/
    public static function vediFilm(){
        //controllo se utente è loggato
        //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
        $id=3;
        $username="matteo";
        $film=FPersistentManager::load("EFilm",$id,null,null,
            null,null,null,null,null,false);
        $member=FPersistentManager::load("EMember",null,$username,null,null,
        null,null,null,null,false);
        FPersistentManager::vediFilm($member, $film);
    }



    /*metodo che che parte quando si vuole rimuovere il film dalla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/-2 , non possiamo scrivere /localhost/film/id si confonde
    con caricafilm ,metodo post */
    public static function rimuoviFilmVisto(){
        //controllo se utente è loggato
        //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
        $id=1;
        $username="matteo";
        $film=FPersistentManager::load("EFilm",$id,null,null,
            null,null,null,null,null,false);
        $member=FPersistentManager::load("EMember",null,$username,null,null,
            null,null,null,null,false);
        FPersistentManager::rimuoviFilmVisto($member,$film);

    }

    /* metodo associato al bottone per caricare la pagina dove ci sono tutti i film
    sara' una semplice get con url localhost/films */
    public static function caricaFilms(){

        $filmPiuVisti=FPersistentManager::caricaFilmPiuVisti(5);
        $filmPiuRecensiti=FPersistentManager::caricaFilmPiuRecensiti(5);
        $filmPiuRecenti=FPersistentManager::caricaFilmRecenti(5);
        $filmVotoMedioPiuAlto=FPersistentManager::caricaFilmConVotoMedioPiuAlto(5);

        //caricare le locandine piccole dei film

        //passare questi array alla view che gestisce i films (damiano l'ha chiamata proprio films)

        print_r($filmPiuRecensiti);
        print_r($filmPiuRecenti);
        print_r($filmVotoMedioPiuAlto);
        print_r($filmPiuVisti);
        //far fare il display della pagina alla view



    }








}