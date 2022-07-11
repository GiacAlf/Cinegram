<?php

/**
 * Controllore che gestisce i casi d'uso dell'applicazione legati
 * a tutto ciò che riguarda i film
 */
class CFilm {

    /**
     * Metodo che, preso in ingresso il prompt scritto dall'utente,
     * cerca e restituisce il film richiesto, se esiste
     * @return void
     * @throws SmartyException
     */
    public static function cercaFilm(): void {

        /*il titolo lo recuperiamo dalla view dato che arrivera nell'array $get */
        $view = new VRicerca();
        $titolo = $view->eseguiRicerca();

        $films = array();
        $locandine = array();

        if($titolo != null && FPersistentManager::exist("EFilm", null, null, null, null, null, $titolo,
            null, null)){
            $films = FPersistentManager::load("EFilm", null, null, null,
                            null, $titolo, null, null, false);
            $locandine = FPersistentManager::loadLocandineFilms($films, false);
        }
        $view->avviaPaginaRicerca($films, $locandine);
    }



    /**
     * Metodo che chiama la view adibita a far visualizzare la pagina del film singolo
     * cliccato dall'utente, non necessariamente loggato, nell'applicazione
     * @param int $idFilm
     * @return void
     * @throws SmartyException
     */
    public static function caricaFilm(int $idFilm): void {

        //restituzione del film completo
        if(FPersistentManager::exist("EFilm", $idFilm, null, null, null, null, null,
                    null, null)) {
            $view = new VFilmSingolo();
            $film = FPersistentManager::load("EFilm", $idFilm, null, null,
                null, null, null, null, true);
            $locandina = FPersistentManager::loadLocandina($film, true);

            $visto = false;
            $ha_scritto = false;
            if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
                //se è un admin pazienza, tanto restituisce false
                $username = SessionHelper::getUtente()->getUsername();
                $visto = FPersistentManager::loHaiVisto($username, $idFilm);
                $ha_scritto = FPersistentManager::exist("ERecensione", $idFilm, $username, null,
                    null, null, null, null, null);
            }
            $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti(5);
            $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

            $view->avviaPaginaFilm($film, $visto, $ha_scritto, $locandina, $filmPiuVisti, $locandineFilmPiuVisti);
        }
        else {
            $view = new VErrore();
            $view->error(3);
        }
    }

    /*
     questo metodo verra' chiamato quando un utente registrato vorra' scrivere una recensione
    ad un film. I dati verranno generati da una form. Sara' associato una url del tipo
    localhost/film/scrivi-recensione/id
    */
    /**
     * Metodo che, presi in ingresso i dati necessari per scrivere una recensione,
     * crea una nuova recensione dell'utente loggato nel database
     * @param int $idFilm
     * @return void
     * @throws SmartyException
     */
    public static function scriviRecensione(int $idFilm): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            if(FPersistentManager::exist("EFilm", $idFilm, null, null, null, null, null,
                null, null)) {
                $username = SessionHelper::getUtente()->getUsername(); //sarà lo username autore
                $view = new VFilmSingolo();
                $array_post = $view->scriviRecensione();
                $voto = $array_post[1];
                $testo = $array_post[0];
                $data = new DateTime();

                if($voto != null && !FPersistentManager::exist("ERecensione", $idFilm, $username, null, null, null, null,
                        null, null)) {
                    $recensione = new ERecensione($idFilm, $username, $voto, $testo, $data, null);
                    FPersistentManager::store($recensione, null, null, null, null, null,
                        null, null);

                    header("Location: https://" . VUtility::getRootDir() . "/film/carica-film/" . $idFilm);//qui reinderizzo alla pagina del film di cui ho scritto la recensione
                }
                else {
                    $view = new VErrore();
                    $view->error(9);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    //localhost/film/mostra-recensione/id/usernameAutore

    /**
     * Metodo che chiama la view adibita a far visualizzare la
     * pagina della recensione cliccata dall'utente
     * @param int $idFilm
     * @param string $usernameAutore
     * @return void
     * @throws SmartyException
     */
    public static function mostraRecensione(int $idFilm, string $usernameAutore): void {

        //fa vedere il template associato
        if(FPersistentManager::exist("ERecensione", $idFilm, $usernameAutore, null, null, null, null,
            null, null)) {
            $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore,
                null, null, null, null, null, true);
            $view = new VRecensione();
            $view->avviaPaginaRecensione($recensione);
        }
        else{
            $view = new VErrore();
            $view->error(3);
        }
    }


    //localhost/film/modifica-recensione/id/usernameAutore

    /**
     * Metodo che chiama la view adibita a far visualizzare la
     * pagina per modificare la recensione cliccata dall'utente
     * @param int $idFilm
     * @param string $usernameAutore
     * @return void
     * @throws SmartyException
     */
    public static function modificaRecensione(int $idFilm, string $usernameAutore): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERecensione", $idFilm, $usernameAutore, null, null,
                null, null, null, null)) {
                $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore,
                    null, null, null, null, null, false);
                $view = new VRecensione();
                $view->avviaPaginaModificaRecensione($recensione);
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }


    //localhost/film/salva-recensione/id/usernameAutore

    /**
     * Metodo che, una volta presi i dati necessari, modifica e salva
     * la recensione cliccata dall'utente
     * @param int $idFilm
     * @param string $usernameAutore
     * @return void
     * @throws SmartyException
     */
    public static function salvaRecensione(int $idFilm, string $usernameAutore): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //metto required a testo recensione?
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERecensione", $idFilm, $usernameAutore, null, null, null, null,
                null, null)) {
                $view = new VRecensione();
                $array_modifica = $view->modificaRecensione();
                $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore, null,
                    null, null, null, null, false);
                if($array_modifica[0] == null) { //se il testo nuovo è null modifico solo il voto

                    $updatedVote = $array_modifica[1];
                    FPersistentManager::update($recensione, "voto", $updatedVote, null, null,
                        null, null, null);
                }
                else{ //se tutti e due sono pieni, modifico tutte e due
                    $updatedText = $array_modifica[0];
                    $updatedVote = $array_modifica[1];
                    FPersistentManager::update($recensione, "testo", $updatedText, null, null,
                        null, null, null);
                    FPersistentManager::update($recensione, "voto", $updatedVote, null, null,
                        null, null, null);
                }

                header("Location: https://" . VUtility::getRootDir() . "/film/mostra-recensione/" . $idFilm . "/" . $usernameAutore);
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*metodo che verra' chiamato quando si vuole eliminare una recensione,
    url localhost/film/elimina-recensione/id
     */

    /**
     * Metodo che elimina una recensione scelta e scritta dall'utente
     * @param int $idFilm
     * @param string $usernameAutore
     * @return void
     * @throws SmartyException
     */
    public static function eliminaRecensione(int $idFilm, string $usernameAutore): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERecensione", $idFilm, $usernameAutore, null, null, null, null,
                null, null)) {

                FPersistentManager::delete("ERecensione", $usernameAutore, null, null, $idFilm, null);
                header("Location: https://" . VUtility::getRootDir() . "/film/carica-film/" . $idFilm);

            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /* metodo che verra' chiamato quando un utente registrato vuole rispondere ad una recensione, sara' chiamato da una url
    localhost/film/scrivi-risposta/usernameAutoreRecensione/data
    i dati come nella recensione vengono passati con una form */

    /**
     * Metodo che, presi in ingresso i dati necessari per scrivere una risposta,
     * crea una nuova risposta dell'utente loggato nel database
     * @param int $idFilm
     * @param string $usernameAutoreRecensione
     * @return void
     * @throws SmartyException
     */
    public static function scriviRisposta(int $idFilm, string $usernameAutoreRecensione): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            if(FPersistentManager::exist("ERecensione", $idFilm, $usernameAutoreRecensione, null, null,
                null, null, null, null)) {
                if(!FPersistentManager::userBannato($usernameAutoreRecensione)) {
                    $view = new VRecensione();
                    $date = new DateTime(); //il format giusto viene fatto in Foundation
                    $usernameAutoreRisposta = SessionHelper::getUtente()->getUsername();
                    $testo = $view->scriviRisposta();
                    if ($testo != null) {
                        $risposta = new ERisposta($usernameAutoreRisposta, $date, $testo, $idFilm, $usernameAutoreRecensione);
                        FPersistentManager::store($risposta, null, null, null, null, null,
                            null, null);
                        //notifica che sto a salva le robe
                        header("Location: https://" . VUtility::getRootDir() . "/film/mostra-recensione/" . $idFilm . "/" . $usernameAutoreRecensione);
                        //qui reinderizzo alla pagina della recensione di cui ho scritto la risposta
                    } else {
                        $view = new VErrore();
                        $view->error(9);
                    }
                }
                else{
                    $view = new VErrore();
                    $view->error(16);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /**
     * Metodo che elimina una risposta scelta e scritta dall'utente
     * @param string $usernameAutore
     * @param string $data
     * @return void
     * @throws SmartyException
     */
    public static function eliminaRisposta(string $usernameAutore, string $data): void {

        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //in teoria qua sarebbe meglio passare anche lo username dell'autore per fare un controllo
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERisposta", null, $usernameAutore, null, null,
                null, null, null, ERisposta::ConvertiFormatoUrlInData($data))) {

                //nel caso dovesse servire, tanto è gratis
                //$visto = FPersistentManager::loHaiVisto($usernameAutore, $idFilm);
                $oggetto_data = ERisposta::ConvertiFormatoUrlInData($data);
                $risposta = FPersistentManager::load("ERisposta", null, $usernameAutore, null, null,
                    null, null, $oggetto_data, false);
                $idFilm = $risposta->getIdFilmRecensito();
                $usernameAutoreRecensione = $risposta->getUsernameAutoreRecensione();
                FPersistentManager::delete("ERisposta", $usernameAutore, null, null, null, $oggetto_data);
                //notifica che sto a salva le robe
                header("Location: https://" . VUtility::getRootDir() . "/film/mostra-recensione/" .
                    $idFilm . "/" . $usernameAutoreRecensione); //qui dove reinderizzo? dato che abbiamo lo username autore, nel suo profilo?
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    //url localhost/film/modifica-risposta/usernameAutoreRecensione/data

    /**
     * Metodo che chiama la view adibita a far visualizzare la
     * pagina per modificare la risposta cliccata dall'utente
     * @param string $usernameAutore
     * @param string $data
     * @return void
     * @throws SmartyException
     */
    public static function modificaRisposta(string $usernameAutore, string $data): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERisposta", null, $usernameAutore, null, null,
                null, null, null, ERisposta::ConvertiFormatoUrlInData($data))) {
                $oggetto_data = ERisposta::ConvertiFormatoUrlInData($data);
                $risposta = FPersistentManager::load("ERisposta", null, $usernameAutore,
                    null, null, null, null, $oggetto_data, false);
                $view = new VRecensione();
                $view->avviaPaginaModificaRisposta($risposta);
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
    metodo che serve effettivamente a salvare la risposta modificata dal member
    url localhost/film/salva-risposta/usernameAutoreRecensione/data
    */
    /**
     * Metodo che, una volta presi i dati necessari, modifica e salva
     * la risposta cliccata dall'utente
     * @param string $usernameAutore
     * @param string $data
     * @return void
     * @throws SmartyException
     */
    public static function salvaRisposta(string $usernameAutore, string $data): void {

        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            if(FPersistentManager::exist("ERisposta", null, $usernameAutore, null, null,
                null, null, null, ERisposta::ConvertiFormatoUrlInData($data))) {
                $view = new VRecensione();
                $oggetto_data = ERisposta::ConvertiFormatoUrlInData($data);
                $updatedText = $view->modificaRisposta(); //in teoria lo passo sempre pieno: ho messo required nell'html
                $risposta = FPersistentManager::load("ERisposta", null, $usernameAutore, null, null,
                    null, null, $oggetto_data, false);
                if($updatedText != null) {
                    $updatedText = addslashes($updatedText);
                    FPersistentManager::update($risposta, null, $updatedText, null,
                        null, null, null, null);
                }
                header("Location: https://" . VUtility::getRootDir() . "/film/mostra-recensione/" .
                    $risposta->getIdFilmRecensito() . "/" . $risposta->getUsernameAutoreRecensione());
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
     * metodo che che parte quando si vuole aggiungere il film alla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/vedi-film/id
    */
    /**
     * Metodo che aggiunge alla lista dei film visti dall'utente
     * il film cliccato e selezionato dallo stesso
     * @param int $idFilm
     * @return void
     * @throws SmartyException
     */
    public static function vediFilm(int $idFilm): void {

        //controllo se utente è loggato
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            if(FPersistentManager::exist("EFilm", $idFilm, null, null, null, null, null,
                null, null)) {
                //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
                $username = SessionHelper::getUtente()->getUsername();
                $visto = FPersistentManager::loHaiVisto($username, $idFilm);
                if(!$visto) {
                    $film = FPersistentManager::load("EFilm", $idFilm, null, null,
                        null, null, null, null, false);
                    $member = FPersistentManager::load("EMember", null, $username, null, null,
                        null, null, null, false);
                    FPersistentManager::vediFilm($member, $film);
                    header("Location: https://" . VUtility::getRootDir() . "/film/carica-film/" . $idFilm);
                } else { //FA UN PO' CAGARE COME SINTASSI PERò SPERO SIA OK
                    $view = new VErrore();
                    $view->error(11);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
     metodo che che parte quando si vuole rimuovere il film dalla lista di quelli visti
    propongo anche qui una url particolare: localhost/rimuovi-film/id
    */
    /**
     * Metodo che rimuove dalla lista dei film visti dall'utente
     * il film cliccato e selezionato dallo stesso
     * @param int $idFilm
     * @return void
     * @throws SmartyException
     */
    public static function rimuoviFilm(int $idFilm): void {

        //controllo se utente è loggato
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Member") {
            if(FPersistentManager::exist("EFilm", $idFilm, null, null, null, null, null,
                null, null)) {
                $username = SessionHelper::getUtente()->getUsername();
                $visto = FPersistentManager::loHaiVisto($username, $idFilm);
                if($visto) {
                    $film = FPersistentManager::load("EFilm", $idFilm, null, null,
                        null, null, null, null, false);
                    $member = FPersistentManager::load("EMember", null, $username, null, null,
                        null, null, null, false);
                    FPersistentManager::rimuoviFilmVisto($member, $film);
                    header("Location: https://" . VUtility::getRootDir() . "/film/carica-film/" . $idFilm);
                }
                else {
                    $view = new VErrore();
                    $view->error(11);
                }
            }
            else {
                $view = new VErrore();
                $view->error(3);
            }
        }
        else {
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /* metodo associato al bottone per caricare la pagina dove ci sono tutti i film
    sara' una semplice get con url localhost/film/carica-films
    */
    /**
     * Metodo che, recuperando alcune informazioni soprattutto dei film dal database, chiama la
     * view adibita a far visualizzare la pagina nota come "Films"
     * @return void
     * @throws SmartyException
     */
    public static function caricaFilms(): void {

        $numero_estrazioni = 5;

        $filmVotoMedioPiuAlto = FPersistentManager::caricaFilmConVotoMedioPiuAlto($numero_estrazioni);
        $locandineVotoMedioPiuAlto = FPersistentManager::loadLocandineFilms($filmVotoMedioPiuAlto, false);

        $utentiPiuSeguiti=FPersistentManager::caricaUtentiConPiuFollower($numero_estrazioni);
        $immaginiUtentiSeguiti = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuSeguiti, false);

        $filmPiuRecenti = FPersistentManager::caricaFilmRecenti(8);
        $locandineFilmRecenti = FPersistentManager::loadLocandineFilms($filmPiuRecenti, true);

        $recensioni = FPersistentManager::caricaUltimeRecensioniScritte($numero_estrazioni);

        //$filmPiuRecensiti = FPersistentManager::caricaFilmPiuRecensiti($numero_estrazioni);
        //$filmVotoMedioPiuAlto = FPersistentManager::caricaFilmConVotoMedioPiuAlto($numero_estrazioni);

        $view = new VFilms();

        //far fare il display della pagina alla view
        $view->avviaPaginaFilms($filmVotoMedioPiuAlto, $locandineVotoMedioPiuAlto, $utentiPiuSeguiti, $immaginiUtentiSeguiti,
            $filmPiuRecenti, $locandineFilmRecenti, $recensioni);
    }
}