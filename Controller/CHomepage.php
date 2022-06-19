<?php

class CHomepage
{

    /*
    sara' il metodo sempre chiamato all'inizio(?), url del tipo localhost/homepage in get */
    public static function impostaHomePage(): void{
        $numero_estrazioni = 5;
        //$view = new VHomePage();

        $filmRecenti = FPersistentManager::caricaFilmRecenti($numero_estrazioni);
        $utentiPopolari = FPersistentManager::caricaUtentiPiuPopolari($numero_estrazioni);
        $ultimeRecensioniScritte = FPersistentManager::caricaUltimeRecensioniScritte($numero_estrazioni);
        $filmPiuRecensiti = FPersistentManager::caricaFilmPiuRecensiti($numero_estrazioni);
        //ma qua tipo non bisogna richiamare pure il Persistant Manager per prendermi le locandine piccole?

        //testando mi da un problema su $utentiPopolari riguardo array_slice(), controllare!!

        print_r($filmRecenti);
        print_r($utentiPopolari);
        print_r($ultimeRecensioniScritte);
        print_r($filmPiuRecensiti);

        /* Qui dovro' chiamare la view corretta e passare al suo metodo gli array
        tanto questa pagina è uguale per tutti*/
        //$view->avviaHomePage($filmRecenti, $filmPiuRecensiti, $ultimeRecensioniScritte, $utentiPopolari);
    }







}