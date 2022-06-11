<?php

class CHomepage
{

    /* sara' il metodo sempre chiamato all'inizio(?), url del tipo localhost/homepage in get */
    public static function ImpostaHomePage(){
        //vedere il numero di estrazioni

        $filmRecenti=FPersistentManager::caricaFilmRecenti(5);
        $utentiPopolari=FPersistentManager::caricaUtentiPiuPopolari(5);
        $ultimeRecensioniScritte=FPersistentManager::caricaUltimeRecensioniScritte(5);
        $filmPiuRecensiti=FPersistentManager::caricaFilmPiuRecensiti(5);



        //testando mi da un problema su $utentiPopolari riguardo array_slice(), controllare!!
        print_r($filmRecenti);
        print_r($utentiPopolari);
        print_r($ultimeRecensioniScritte);
        print_r($filmPiuRecensiti);
        /* Qui dovro' chiamare la view corretta e passare al suo metodo gli array
        tanto questa pagina è uguale per tutti*/




    }







}