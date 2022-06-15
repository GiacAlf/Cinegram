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

        $nuovoValore= new DateTime();
        $nomeAttributo="sinossi";

        if($nomeAttibuto="data")

            FPersistentManager::update( $film , null , null ,null, null,
            $nuovoValore , null , null );

        if (gettype($nuovoValore)="array") {

            if($nomeAttributo="attori")
            FPersistentManager::update($film, null, null, null,
                null, null, $nuovoValore, null);

            if($nomeAttributo="registi")
                FPersistentManager::update($film, null, null, null,
                    null, null, null , $nuovoValore);
        }
        else
        {
            FPersistentManager::update($film , $nomeAttributo , $nuovoValore , null ,
            null , null , null , null);
        }
        //da rivedere non mi piace per nulla
    }


}