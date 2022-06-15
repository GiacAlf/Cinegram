<?php

class CGestioneAdmin{

    /*
      metodo che serve all'admin per caricare un film nella piattaforma, metodo in post, url
    localhost/admin/caricafilm
    */
    public static function caricaFilm(){
        //prendere dalla view le informazioni del film
        $titolo = "prova";
        $data= new DateTime('now');
        $durata=120;
        $sinossi="un bel film di prova";
        $listaRegisti=array();
        $listaAttori=array();
        $immagine="prova";
        $tipoImmagine="jpeg";
        $sizeImmagine="1920x1080";


        $film= new EFilm(null, $titolo , $data , $durata , $sinossi , null , null
            , $listaRegisti , $listaAttori , null );

        FPersistentManager::store($film , $film ,null , null ,null ,
        $immagine , $tipoImmagine , $sizeImmagine);
    }

    /*
    L'admin vuole modificare un attributo di un film,
    url localhost/admin/modificafilm
    */
    public static function modificaFilm(){

        /*possiamo fare una checkbox dove l'admin seleziona l'attributo da eliminare, pero' ci
        deve per forza inviare l'id */

        $id=2;
        $film=FPersistentManager::load("EFilm" , $id ,null ,null ,
        null , null , null ,null ,false);

        $nuovoValore= array();
        $nomeAttributo="sinossi";

        if($nomeAttibuto="data")

            FPersistentManager::update( $film , null , null ,null, null,
            $nuovoValore , null , null );

        if($nomeAttributo="attori")

            FPersistentManager::update($film, null, null, null,
                null, null, $nuovoValore, null);

        if($nomeAttributo="registi")

            FPersistentManager::update($film, null, null, null,
                    null, null, null , $nuovoValore);

        else
        {
            FPersistentManager::update($film , $nomeAttributo , $nuovoValore , null ,
            null , null , null , null);
        }
        //da rivedere non mi piace per nulla
    }

    /*
     metodo che serve all'admin quando vuole eliminare una recensione di un member.
    Url localhost/admin/rimuoviRecensione...... anche qui username e id film vengono inviati nella url(?)
    quindi nel template dobbiamo mettere anche una url per l'admin(?)(vedere bene, non ho troppo le idee chiare)
    */
    public static function rimuoviRecensione(){

        //dati che qualcuno mi dara'
        $idFilm=2;
        $usernameAutore="pippo";
        FPersistentManager::delete("ERecensione",$usernameAutore,null,null,$idFilm,null);
        //notifica che sto eliminando la recensione.

    }

     //idem come sopra()
    public static function rimuoviRisposta(){

        //qualcuno mi procurera' i dati

        $idFilm = 1;
        $data = new DateTime();
        $usernameAutore="matteo";
        FPersistentManager::delete("ERisposta",$usernameAutore,null,null,null,$data);

        //notifica che ho eliminato la risposta
    }

    /*
    metodo che permette all'admin di ammonire il member,
    url localhost/admin/ammonisci
    */
    public static function ammonisciUser(){
        //qualcuno mi da lo username

        //recupero lo username dell'admin dalla sessione
        $username="admin";
        $usernameMember="matteo";
        $admin= new EAdmin($username);
        if(!FPersistentManager::userBannato($username))
            $admin->ammonisciUser($usernameMember);
        else
            print("Utente bannato");
    }

    public static function sbannaUser(){

        $username ="giangiacomo";

        $usernameAdmin="alberto";
        $admin=new EAdmin($usernameAdmin);

        if (FPersistentManager::userBannato($username)){
            FPersistentManager::sbannaUser($username);
            //$admin->



        }




        else
            print ("l'utente non è bannato");



    }





}