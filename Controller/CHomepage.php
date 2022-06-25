<?php

class CHomepage {

    /*
    sara' il metodo sempre chiamato all'inizio(?), url del tipo localhost/homepage/imposta-homepage in get */
    public static function impostaHomepage(): void {

        $numero_estrazioni = 8;
        $view = new VHomePage();

        $filmRecenti = FPersistentManager::caricaFilmRecenti($numero_estrazioni);
        $locandineFilmRecenti = FPersistentManager::loadLocandineFilms($filmRecenti, true);

        $utentiPopolari = FPersistentManager::caricaUtentiPiuPopolari($numero_estrazioni);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPopolari, false);

        // per ora no agli avatar vicino alle recensioni (e risposte) ci mettiamo solo gli username
        $ultimeRecensioniScritte = FPersistentManager::caricaUltimeRecensioniScritte($numero_estrazioni);

        $filmPiuRecensiti = FPersistentManager::caricaFilmPiuRecensiti($numero_estrazioni);
        $locandineFilmPiuRecensiti = FPersistentManager::loadLocandineFilms($filmPiuRecensiti, false);

        // ma qua tipo non bisogna richiamare pure il Persistent Manager per prendermi le locandine piccole? certo, fatto
        // io!!

        print_r($filmRecenti);
        print_r($utentiPopolari);
        print_r($ultimeRecensioniScritte);
        print_r($filmPiuRecensiti);

        /* Qui dovro' chiamare la view corretta e passare al suo metodo gli array
        tanto questa pagina è uguale per tutti*/

        $view->avviaHomePage($filmRecenti, $locandineFilmRecenti, null, null,
            null, null, null);
    }
}