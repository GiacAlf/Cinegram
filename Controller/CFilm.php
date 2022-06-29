<?php

class CFilm {

    //TODO: OGNI VOLTA CHE SI STAMPA LA VFILMSINGOLO BISOGNA VEDERE SE L'UTENTE DELLA SESSIONE HA VISTO IL FILM O MENO: VAR BOOL

    /* questo sara' il metodo associato alla ricerca del film per titolo avra' una URL
    del tipo localhost/film/cerca-film/titolo

    io ricordo che questo viene chiamato a causa dell'URL modificata dalla scelta della checkbox dell'HTML, dunque se l'url è
    tipo localhost/member/.... chiamo il cercaMember
    */
    public static function cercaFilm(): void{
        /*il titolo lo recuperiamo dalla view dato che arrivera nell'array $get */
        $view = new VRicerca();
        $titolo = $view->eseguiRicerca();
        //$tipo = $view->tipoRicerca(); //non serviva più questo vero, non me lo ricordo ahaha -> in realtà sì per discriminare tra ricerca
        //per film o per persone

        //$titolo="suspiria";
        $films = array();
        if($titolo == null){ //qua o si mette in foundation che l'argomento username può essere null
            //oppure si fa così, oppure ancora si usa il required nell'html
            $films = FPersistentManager::load("EFilm", null, null, null,
                null, "", 1, null, false);
        }
        else {
            $films = FPersistentManager::load("EFilm", null, null, null,
                null, $titolo, null, null, false);
        }
        $locandine = FPersistentManager::loadLocandineFilms($films, false);
        // CI ERAVAMO DETTI POI DI TOGLIE STA ROBA CHE è UNA PALLA IMMENSA COME CODICE
        /*
        else{
            //qua dato che ci stanno nome e cognome devo stare attento, specie se uno, tipo Francis Ford Coppola, ha più nomi
            $array = explode(" ", $titolo); // TODO mettere carattere spazio query e gestione casi strani J.J.Abrams
            if(count($array) > 2){
                $nome = $array[0] . " " . $array[1];
                $cognome = $array[2];
            }
            else {
                $nome = $array[0];
                $cognome = $array[1];
            }
            $films = FPersistentManager::loadFilmByNomeECognome($nome, $cognome);
        }*/
        $view->avviaPaginaRicerca($films, $locandine);
    }


    /*
     * questo metodo verra' chiamato quando l'utente clicca su uno specifico film,
    sara' associata una url (secondo lo standard Restful) fatta in get del tipo localhost/film/carica-film/id
    ,parsificando la stringa il front controller passera' l'id come parametro
     */
    public static function caricaFilm(int $id): void{
        //restituzione del film completo
        $view = new VFilmSingolo();
        $film = FPersistentManager::load("EFilm",$id,null,null,
        null,null,null,null,true);
        $locandina = FPersistentManager::loadLocandina($film, true);
        //$locandina=FPersistentManager::loadLocandina($film,true)
        /*qui dovro' passare alla view che fara' il display della pagina
        del film singolo
         */
        $visto = false;
        if(SessionHelper::isLogged()){
            $username = SessionHelper::getUtente()->getUsername();
            $visto = FPersistentManager::loHaiVisto($username, $id);
        }
        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti(5);
        $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

        /* CHIUNQUE SIA L'UTENTE SUL SITO COMPARE LA PAGINA DEL FILM, POI L'ADMIN CLICCA SU
        "MODIFICA FILM" PER MODIFICARE E TUTTO IL RESTO

        if(SessionHelper::getUtente()->chiSei() == "Admin"){ //ma se ho un utente non registrato che succede?
            $view_admin = new VAdmin();
            $view_admin->avviaPaginaModificaFilm($film);
        }
        else {
            //TODO if($user:chiSei == "Admin") chiama la VAdmin sennò la VFilms
            $visto = false;
            if(SessionHelper::isLogged()){
                $username = SessionHelper::getUtente()->getUsername();
                $visto = FPersistentManager::loHaiVisto($username, $id);
            }
            $view->avviaPaginaFilm($film, $visto, $locandina);
        } */
        $view->avviaPaginaFilm($film, $visto, $locandina, $filmPiuVisti, $locandineFilmPiuVisti);
    }

    /*
     questo metodo verra' chiamato quando un utente registrato vorra' scrivere una recensione
    ad un film. I dati verranno generati da una form. Sara' associato una url del tipo
    localhost/film/scrivi-recensione/id
    */
    public static function scriviRecensione(int $idFilm): void{
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //verificare se lo username è loggato, dopo vedro' come fare.
        if(SessionHelper::isLogged()) {
            $username = SessionHelper::getUtente()->getUsername(); //sarà lo username autore
            $view = new VFilmSingolo();
            //l'id del film viene preso dall'URL perché per ora abbiamo stabilito che la recensione la possiamo scrivere
            //solo nella pagina del film singolo
            $array_post = $view->scriviRecensione();
            $testo = "prova"; //$testo = $array_post[0]
            $data = new DateTime();
            //nel caso dovesse servire, tanto è gratis
            //$visto = FPersistentManager::loHaiVisto($username, $idFilm);
            $voto = 3; //$voto = $array_post[1]
            if($voto != null) {
                $recensione = new ERecensione($idFilm, $username, $voto, $testo, $data, null);
                FPersistentManager::store($recensione, null, null, null, null, null,
                    null, null);
                //notifica che sto a salva le robe
                header("Location: localhost/film/carica-film/" . $idFilm);//qui reinderizzo alla pagina del film di cui ho scritto la recensione
            }
            else{
                $view = new VErrore();
                $view->error(9);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    //localhost/film/mostra-recensione/id/usernameAutore
    public static function mostraRecensione(int $idFilm, string $usernameAutore){
        //fa vedere il template associato
        $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore,
            null, null, null, null, null, true);
        $view = new VRecensione();
        $view->avviaPaginaRecensione($recensione);
    }

    //localhost/film/modifica-recensione/id/usernameAutore
    public static function modificaRecensione(int $idFilm, string $usernameAutore){
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //se l'utente è loggato ed è l'autore -> roba che c'è anche in smarty
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore,
                null, null, null, null, null, false);
            $view = new VRecensione();
            $view->avviaPaginaModificaRecensione($recensione);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }


    //localhost/film/salva-recensione/id/usernameAutore
    public static function salvaRecensione(int $idFilm, string $usernameAutore){
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //se ricevo il valore di testo allora salvo quello
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            $view = new VRecensione();
            $array_modifica = $view->modificaRecensione();
            //la prendo completa perché, per ora, alla fine del metodo visualizziamo la sua pagina
            $recensione = FPersistentManager::load("ERecensione", $idFilm, $usernameAutore, null
                , null, null, null, null, true);
            if ($array_modifica[1] == null && $array_modifica[0] != null) { //se il voto è null modifico solo il testo
                $updatedText = "prova aggiornamento"; // = $array_modifica[0];
                FPersistentManager::update($recensione, "testo", $updatedText, null, null,
                    null, null, null);
            } elseif ($array_modifica[0] == null && $array_modifica[1] != null) { //se il testo nuovo è null modifico solo il voto
                //se ricevo il voto aggiorno quello
                $updatedVote = 3; // = $array_modifica[1];
                FPersistentManager::update($recensione, "voto", $updatedVote, null, null,
                    null, null, null);
            } elseif ($array_modifica[0] != null && $array_modifica[1] != null) { //se tutti e due sono pieni, modifico tutte e due
                $updatedText = "prova aggiornamento"; // = $array_modifica[0];
                $updatedVote = 3; // = $array_modifica[0];
                FPersistentManager::update($recensione, "testo", $updatedText, null, null,
                    null, null, null);
                FPersistentManager::update($recensione, "voto", $updatedVote, null, null,
                    null, null, null);
            }
            //così se tutti e due i campi sono null faccio rivedere direttamente la pagina della recensione
            //poi rifacciamo vedere la pagina della recensione?
            header("Location: localhost/film/mostra-recensione/" . $idFilm . "/" .$usernameAutore);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*metodo che verra' chiamato quando si vuole eliminare una recensione,
    url localhost/film/elimina-recensione/id
     */

    public static function eliminaRecensione(int $idFilm): void{
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //in teoria qua sarebbe meglio passare anche lo username dell'autore per fare un controllo
        //come sopra
        if(SessionHelper::isLogged()) {

            //$idFilm = 2; //recupero da Url
            $usernameAutore = "pippo"; //SessionHelper::getUtente()->getUsername();
            //nel caso dovesse servire, tanto è gratis
            //$visto = FPersistentManager::loHaiVisto($usernameAutore, $idFilm);
            FPersistentManager::delete("ERecensione", $usernameAutore, null, null, $idFilm, null);
            //notifica che sto a salva le robe
            header("Location:  localhost/film/carica-film/" . $idFilm); //qui reinderizzo alla pagina del film di cui ho scritto la recensione
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /* metodo che verra' chiamato quando un utente registrato vuole rispondere ad una recensione, sara' chiamato da una url
    localhost/film/scrivi-risposta/usernameAutoreRecensione/data
    i dati come nella recensione vengono passati con una form */

    public static function scriviRisposta(int $idFilm, string $usernameAutoreRecensione): void{
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        if(SessionHelper::isLogged()) {
            //prova
            $view = new VRecensione();
            $date = new DateTime(); //il format giusto viene fatto in Foundation
            $usernameAutore = "damiano"; // SessionHelper::getUtente()->getUsername();
            $testo = $view->scriviRisposta();
            $testo = "prova risposta";
            //nel caso dovesse servire, tanto è gratis
            //$visto = FPersistentManager::loHaiVisto($usernameAutore, $idFilm);
            //$idFilm = 2; //presa dall'url
            //$usernameAutoreRecensione = "matteo"; //dall'url (?)
            if($testo != null) {
                $risposta = new ERisposta($usernameAutore, $date, $testo, $idFilm, $usernameAutoreRecensione);
                FPersistentManager::store($risposta, null, null, null, null, null,
                    null, null);
                //notifica che sto a salva le robe
                header("Location  localhost/film/?id=" . $idFilm); //qui reinderizzo alla pagina della recensione di cui ho scritto la recensione
            }
            else{
                $view = new VErrore();
                $view->error(9);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    /*
      metodo che verra' chiamato quando si vuole eliminare una risposta
    , propongo di associare ,localhost/film/elimina-risposta/data, come fatto sopra.
     */

    public static function eliminaRisposta(string $data): void{
        //QUESTO METODO PUò PARTIRE SOLO SE L'UTENTE è LOGGATO
        //in teoria qua sarebbe meglio passare anche lo username dell'autore per fare un controlloo
        if(SessionHelper::isLogged()) {
            $usernameAutore = SessionHelper::getUtente()->getUsername();

            //$idFilm = 1; //non serve questo qui, giusto?
            $usernameAutore = "matteo"; //recupero da sessione
            //nel caso dovesse servire, tanto è gratis
            //$visto = FPersistentManager::loHaiVisto($usernameAutore, $idFilm);
            $oggetto_data = ERisposta::ConvertiFormatoUrlInData($data);
            FPersistentManager::delete("ERisposta", $usernameAutore, null, null, null, $oggetto_data);
            //notifica che sto a salva le robe
            header("Location  localhost/film/?id=" ); //qui dove reinderizzo? dato che abbiamo lo username autore, nel suo profilo?
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }

    //url localhost/film/modifica-risposta/usernameAutoreRecensione/data

    public static function modificaRisposta(string $usernameAutore, string $data){
        if(SessionHelper::isLogged()) {
            $data = ERisposta::ConvertiFormatoUrlInData($data);
            $risposta = FPersistentManager::load("ERisposta", null, $usernameAutore,
                null, null, null, null, $data, false);
            $view = new VRecensione();
            $view->avviaPaginaModificaRisposta($risposta);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }



    /*
    metodo che serve effettivamente a salvare la risposta modificata dal member
    url localhost/film/salva-risposta/usernameAutoreRecensione/data
    */
    public static function salvaRisposta(string $usernameAutore, string $data){
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->getUsername() == $usernameAutore) {
            $view = new VRecensione();
            $oggetto_data = ERisposta::ConvertiFormatoUrlInData($data);
            $updatedText = $view->modificaRisposta(); //in teoria lo passo sempre pieno: ho messo required nell'html
            $updatedText = "prova aggiornamento";
            if($updatedText != null) {
                $risposta = FPersistentManager::load("ERisposta", null, $usernameAutore, null, null,
                    null, null, $oggetto_data, false);
                FPersistentManager::update($risposta, null, $updatedText, null,
                    null, null, null, null);
                //dove reinderizzo? dato che abbiamo lo username autore, nel suo profilo?
            }
            else{
                $view = new VErrore();
                $view->error(9);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
    supponendo ci sia un pulsante per caricare le risposte della recensione
    allora associamo una url localhost/film/carica-risposte/usernameAutoreRecensione/idFilm
     */
    //METODO UTILE UNA VOLTA ORA INUTILE
    public static function caricaRisposte(string $usernameAutoreRecensione, int $id): void{

        //leggere dalla view corrispondente i dati inviati, saranno la chiave che identifica la recensione
        //quindi usernameAutore e idfilm

        $usernameAutore = "damiano"; //vengono dall'url questi due paramentri
        $idFilm = 2;

        $risposte = FPersistentManager::loadRisposte($idFilm, $usernameAutore);
        // print_r($risposte);

        /* semplicemente
        cliccando sul buttone parte un js che carica una finestra (?) ,non ne ho idea
        Sì, dovrebbe essere il js a fare sta roba, si spera*/
    }

    /*
     * metodo che che parte quando si vuole aggiungere il film alla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/vedi-film/id
    */
    public static function vediFilm(int $id): void{
        //controllo se utente è loggato
        if(SessionHelper::isLogged()) {

            //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
            $id = 3; //dall'url
            $username = "matteo"; //SessionHelper::getUtente()->getUsername();
            $visto = FPersistentManager::loHaiVisto($username, $id);
            if(!$visto) {
                $film = FPersistentManager::load("EFilm", $id, null, null,
                    null, null, null, null, false);
                $member = FPersistentManager::load("EMember", null, $username, null, null,
                    null, null, null, false);
                FPersistentManager::vediFilm($member, $film);
                //qua grazie al js, in teoria, non devi reindirizzare nulla
            }
            else{ //FA UN PO' CAGARE COME SINTASSI PERò SPERO SIA OK
                $view = new VErrore();
                $view->error(5);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /*
     metodo che che parte quando si vuole rimuovere il film dalla lista di quelli visti
    propongo anche qui una url particolare: localhost/rimuovi-film/id
    */
    public static function rimuoviFilm(int $id): void{
        //controllo se utente è loggato
        if(SessionHelper::isLogged()) {
            //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
            $id = 1; //dall'url
            $username = "matteo"; //SessionHelper::getUtente()->getUsername();
            $visto = FPersistentManager::loHaiVisto($username, $id);
            if($visto) {
                $film = FPersistentManager::load("EFilm", $id, null, null,
                    null, null, null, null, false);
                $member = FPersistentManager::load("EMember", null, $username, null, null,
                    null, null, null, false);
                FPersistentManager::rimuoviFilmVisto($member, $film);
            }
            else{
                $view = new VErrore();
                $view->error(5);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }


    /* metodo associato al bottone per caricare la pagina dove ci sono tutti i film
    sara' una semplice get con url localhost/film/carica-films
    */
    public static function caricaFilms(): void{
        $numero_estrazioni = 5;

        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti($numero_estrazioni);
        $locandineFilmPiuVisti = FPersistentManager::loadLocandineFilms($filmPiuVisti, false);

        $utentiPiuSeguiti=FPersistentManager::caricaUtentiConPiuFollower($numero_estrazioni);
        $immaginiUtentiSeguiti = FPersistentManager::loadImmaginiProfiloMembers($utentiPiuSeguiti, false);


        $filmPiuRecenti = FPersistentManager::caricaFilmRecenti($numero_estrazioni);
        $locandineFilmRecenti = FPersistentManager::loadLocandineFilms($filmPiuRecenti, true);

        $recensioni = FPersistentManager::caricaUltimeRecensioniScritte($numero_estrazioni);

        //$filmPiuRecensiti = FPersistentManager::caricaFilmPiuRecensiti($numero_estrazioni);
        //$filmVotoMedioPiuAlto = FPersistentManager::caricaFilmConVotoMedioPiuAlto($numero_estrazioni);


        $view = new VFilms();

        //far fare il display della pagina alla view
        $view->avviaPaginaFilms($filmPiuVisti, $locandineFilmPiuVisti, $utentiPiuSeguiti, $immaginiUtentiSeguiti,
            $filmPiuRecenti, $locandineFilmRecenti, $recensioni);

    }


}