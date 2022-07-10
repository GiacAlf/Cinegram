<?php

class CHomepage {

    /* sara' il metodo sempre chiamato all'inizio(?), url del tipo localhost/homepage/imposta-homepage in get */
    public static function impostaHomepage(): void {

        $numero_estrazioni = 4;
        $view = new VHomePage();

        $filmRecenti = FPersistentManager::caricaFilmRecenti($numero_estrazioni);
        $locandineFilmRecenti = FPersistentManager::loadLocandineFilms($filmRecenti, true);

        $utentiPopolari = FPersistentManager::caricaUtentiPiuPopolari($numero_estrazioni);
        $immaginiUtentiPopolari = FPersistentManager::loadImmaginiProfiloMembers($utentiPopolari, false);

        // per ora no agli avatar vicino alle recensioni (e risposte) ci mettiamo solo gli username
        $ultimeRecensioniScritte = FPersistentManager::caricaUltimeRecensioniScritte(6);

        //nel template ci sono i film più visti, prima qua c'erano i più recensiti
        //sceglieremo poi
        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti($numero_estrazioni);
        $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

        // ma qua tipo non bisogna richiamare pure il Persistent Manager per prendermi le locandine piccole? certo, fatto
        // io!!

        $view->avviaHomePage($filmRecenti, $locandineFilmRecenti, $filmPiuVisti, $locandineFilmPiuVisti, $ultimeRecensioniScritte,
            $utentiPopolari, $immaginiUtentiPopolari);
    }
}