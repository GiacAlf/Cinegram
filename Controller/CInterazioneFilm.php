<?php

class CInterazioneFilm {

    /* questo sara' il metodo associato alla ricerca del film per titolo avra' una URL
    del tipo localhost/film?titolo=titanic
    io ricordo che questo viene chiamato a causa dell'URL modificata dalla scelta della checkbox dell'HTML, dunque se l'url è
    tipo localhost/member/.... chiamo il cercaMember -> da fare per ora*/
    public static function cercaFilm(): void{
        /*il titolo lo recuperiamo dalla view dato che arrivera nell'array $get */
        //$view = new VRicerca();
        //$titolo = $view->eseguiRicerca();
        //$tipo = $view->tipoRicerca(); //non serviva più questo vero, non me lo ricordo ahaha -> in realtà sì per discriminare tra ricerca
        //per film o per persone

        $titolo="suspiria";
        print("ciao");
        /*$films = array();
        if ($tipo == "Film") {
            $films = FPersistentManager::load("EFilm", null, null, null,
                null, null, $titolo, null, null, false);
            //caricare le locandine dell'array di film ricevute
        }
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
        }
        /*dovro' adesso dare questi film alla view che si occupa della visualizzazione dei risultati
        della ricerca

        $view->avviaPaginaRicerca($films);*/
    }


    /*questo metodo verra' chiamato quando l'utente clicca su uno specifico film,
    sara' associata una url (secondo lo standard Restful) fatta in get del tipo localhost/film/id
    ,parsificando la stringa il front controller passera' l'id come parametro
     */
    public static function CaricaFilm(int $id): void{
        //restituzione del film completo
        $view = new VFilmSingolo();
        $film = FPersistentManager::load("EFilm",$id,null,null,
        null,null,null,null,true);
        //$locandina=FPersistentManager::loadLocandina($film,true);
        //print_r($film);
        /*qui dovro' passare alla view che fara' il display della pagina
        del film singolo
         */
        if(SessionHelper::getUtente()->chiSei() == "Admin"){ //ma se ho un utente non registrato che succede?
            $view_admin = new VAdmin();
            $view_admin->avviaPaginaModificaFilm($film);
        }
        else {
            //TODO if($user:chiSei == "Admin") chiama la VAdmin sennò la VFilms
            $view->avviaPaginaFilm($film);
        }
    }

    /*questo metodo verra' chiamato quando un utente registrato vorra' scrivere una recensione
    ad un film. I dati verranno generati da una form. Sara' associato una url del tipo
    localhost/recensione   */
    public static function ScriviRecensione(int $idFilm): void{

        //verificare se lo username è loggato, dopo vedro' come fare.
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        //chiamo la view che mi restituisce i dati per la creazione della recensione(presi dalla form)
        /* idfilm verra' restituito cosi' come il voto ed il testo
           la data viene creato in questo metodo al momento
           lo username è preso dalla sessione(?)
           $username=$SESSION["username"]
        */
        //prova
         //prova
        $view = new VFilmSingolo();
        $idFilm = 2; //l'id del film viene preso dall'URL perché per ora abbiamo stabilito che la recensione la possiamo scrivere
        //solo nella pagina del film singolo
        $username = "damiano"; //lo si prende dalla sessione
        $array_post = $view->scriviRecensione();
        $testo = "prova"; //$testo = $array_post[0]
        $voto = 3; //$voto = $array_post[1]
        $data = new DateTime();
        $recensione = new ERecensione($idFilm, $username, $voto, $testo, $data,null);
        FPersistentManager::store($recensione,null,null,null,null,null,
            null,null);
        //notifica che sto a salva le robe
        header("Location  localhost/film/?id=" . $idFilm); //qui reinderizzo alla pagina del film di cui ho scritto la recensione
    }

    /* metodo che verra' chiamato quando un utente registrato vuole rispondere ad una recensione, sara' chiamato da una url
    localhost/risposta/?usernameAutoreRecensione=...&id=.. i dati come nella recensione vengono passati con una form */

    public static function ScriviRisposta(): void{
        //anche qui dobbiamo verificare se l'utente è loggato

        //chiamo la view che mi restituisce i dati per la creazione della risposta(presi dalla form)
        /* idfilm verra' restituito cosi' come il testo e lo usernameautorerecensione
           la data viene creato in questo metodo al momento
           lo usernameautore è preso dalla sessione(?)
           $username=$SESSION["username"]*/
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        //prova
        $view = new VFilmSingolo();
        $date = new DateTime();
        $usernameAutore = "damiano"; //dalle sessioni
        $testo = $view->scriviRisposta();
        $testo = "prova risposta";
        $idFilm = 2; //presa dall'url
        $usernameAutoreRecensione = "matteo"; //dall'url (?)

        $risposta = new ERisposta($usernameAutore, $date, $testo, $idFilm, $usernameAutoreRecensione);
        FPersistentManager::store($risposta,null,null,null,null,null,
            null,null);
        //notifica che sto a salva le robe
        header("Location  localhost/film/?id=" . $idFilm); //qui reinderizzo alla pagina del film di cui ho scritto la recensione
    }

    /*metodo che verra' chiamato quando si vuole eliminare una recensione, adesso pero' dobbiamo fare
    delle considerazioni per quanto riguarda la URL da associare. Htlm prevede solo i metodi get e post quindi
    possiamo fare richieste solo con questi due, propongo di associargli localhost/recensione/id=.../-1 (sappiamo grazie
    a -1 che chiameremo questo metodo), ovviamente in post -> qua la URL ha una sola chiave di recensione, ma poi dovrà avere
    anche l'altra chiave della recensione e cioè lo username autore per farla eliminare dall'admin */

    public static function EliminaRecensione(): void{

        //verificare se utente è loggato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        /*avendo inviato in post la richiesta dovremmo sempre leggere
        dalla view
        ci facciamo inviare l'id del film ,che insieme allo usernameAutore(letto dalla sessione)
        formano la chiave primaria che identifica la recensione */

        $idFilm = 2; //recupero da Url
        $usernameAutore = "pippo"; //recupero dalla sessione
        FPersistentManager::delete("ERecensione", $usernameAutore,null,null, $idFilm,null);
        //notifica che sto a salva le robe
        header("Location  localhost/film/?id=" . $idFilm); //qui reinderizzo alla pagina del film di cui ho scritto la recensione
    }


    /*metodo che verra' chiamato quando si vuole eliminare una risposta
    , propongo di associare ,localhost/risposta/data/elimina, come fatto sopra. (sappiamo grazie
   a -1 che chiameremo questo metodo), ovviamente in post-> qua la URL ha una sola chiave di risposta, ma poi dovrà avere
    anche l'altra chiave della risposta e cioè lo username autore per farla eliminare dall'admin */

    public static function EliminaRisposta(DateTime $data): void{

        //verificare utente loggato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}

        //recupero dalla view i dati inviati dal client in post
        /* ci facciamo inviare la data e lo username lo prendiamo dalla sessione
        */
        $idFilm = 1; //non serve questo qui, giusto?
        $data = new DateTime(); //recupero da url
        $usernameAutore = "matteo"; //recupero da sessione
        FPersistentManager::delete("ERisposta", $usernameAutore,null,null,null, $data);
        //notifica che sto a salva le robe
        header("Location  localhost/film/?id=" . $idFilm); //qui reinderizzo alla pagina del film di cui ho scritto la recensione

    }


    /* supponendo ci sia un pulsante per caricare le risposte della recensione (Vedi risposte)
    allora associamo una url localhost/risposte/id=...&username=.... in post */
    public static function caricaRisposte(): void{

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

    /*metodo che che parte quando si vuole aggiungere il film alla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/id=.../-1 , non possiamo scrivere /localhost/film/id si confonde
    con caricafilm , metodo post*/
    public static function vediFilm(): void{
        //controllo se utente è loggato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}
        //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
        $id = 3; //dall'url
        $username = "matteo"; //dalla sessione
        $film = FPersistentManager::load("EFilm",$id,null,null,
            null,null,null,null,null,false);
        $member = FPersistentManager::load("EMember",null, $username,null,null,
        null,null,null,null,false);
        FPersistentManager::vediFilm($member, $film);
    }


    /*metodo che che parte quando si vuole rimuovere il film dalla lista di quelli visti
    propongo anche qui una url particolare: localhost/film/id=.../-2 , non possiamo scrivere /localhost/film/id si confonde
    con caricafilm ,metodo post */
    public static function rimuoviFilmVisto(): void{
        //controllo se utente è loggato
        //if(SessionHelper::isLogged()){
        //  $username = SessionHelper::getUtente()->getUsername();
        //}
        //recupero dalla view il dato che è solo l'id del film visto che lo username lo prendiamo dalla sessione
        $id = 1; //dall'url
        $username = "matteo"; //dalla sessione
        $film = FPersistentManager::load("EFilm",$id,null,null,
            null,null,null,null,null,false);
        $member = FPersistentManager::load("EMember",null,$username,null,null,
            null,null,null,null,false);
        FPersistentManager::rimuoviFilmVisto($member,$film);
    }


    /* metodo associato al bottone per caricare la pagina dove ci sono tutti i film
    sara' una semplice get con url localhost/films */
    public static function caricaFilms(): void{
        $numero_estrazioni = 5;
        $filmPiuVisti = FPersistentManager::caricaFilmPiuVisti($numero_estrazioni);
        $filmPiuRecensiti = FPersistentManager::caricaFilmPiuRecensiti($numero_estrazioni);
        $filmPiuRecenti = FPersistentManager::caricaFilmRecenti($numero_estrazioni);
        $filmVotoMedioPiuAlto = FPersistentManager::caricaFilmConVotoMedioPiuAlto($numero_estrazioni);

        //caricare le locandine piccole dei film

        //passare questi array alla view che gestisce i films (damiano l'ha chiamata proprio films)
        $view = new VFilms();
        /*
        print_r($filmPiuRecensiti);
        print_r($filmPiuRecenti);
        print_r($filmVotoMedioPiuAlto);
        print_r($filmPiuVisti);
        */
        //far fare il display della pagina alla view
        $view->avviaPaginaFilms($filmPiuVisti, $filmPiuRecensiti, $filmVotoMedioPiuAlto, $filmPiuRecenti);
    }
}