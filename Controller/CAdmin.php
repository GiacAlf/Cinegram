<?php

class CAdmin {

    /*
       una volta che l'admin è loggato per andare alla sua pagina,
       url localhost/admin/carica-amministrazione
     */
    public static function caricaAmministrazione(): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            //controllare se sei l'admin
            $view = new VAdmin();
            $username = SessionHelper::getUtente()->getUsername();
            $view->avviaPaginaAdmin($username);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    //TODO: ricontrolla le url
    //deve solo mostrare il template -> la url sarà localhost/mostra-film/id (?)
    public static function mostraFilm(int $idfilm): void{
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $film = FPersistentManager::load("EFilm", $idfilm, null, null,
                null, null, null, null, true);
            $locandina = FPersistentManager::loadLocandina($film, false);
            $admin = SessionHelper::getUtente()->getUsername();
            $view = new VAdmin();
            $view->avviaPaginaModificaFilm($film, $locandina, $admin);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    //deve solo mostrare il template -> la url sarà localhost/mostra-member/username (?)
    public static function mostraMember(string $username): void{
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            //carico le info del member
            $member = FPersistentManager::load("EMember", null, $username, null, null,
                null, null, null, false);
            $bannato = FPersistentManager::userBannato($username);
            $admin = SessionHelper::getUtente()->getUsername();
            $view = new VAdmin();
            $view->avviaPaginaModeraUtente($member, $bannato, $admin);
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }

    /*
      metodo che serve all'admin per caricare un film nella piattaforma, metodo in post, url
    localhost/admin/carica-film
    */
    public static function caricaFilm(): void {
        //prendere dalla view le informazioni del film
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $view = new VAdmin();
            $titolo = "prova"; //$view->getTitolo();
            $data = new DateTime('now'); ////$view->getData();
            $durata = 120; //$view->getDurata();
            $sinossi = "un bel film di prova"; //$view->getSinossi();
            $listaRegisti = array(); //$view->getRegisti();
            $listaAttori = array(); //$view->getAttori();
            $array_immagini = $view->getLocandina();
            $immagine = "prova"; // = $array_immagini['tmp_name'];
            $tipoImmagine = "jpeg"; // = $array_immagini['type'];
            $sizeImmagine = "1920x1080"; // = $array_immagini['size'];
            //il ragionamento che si può fare è: se mettiamo tutto required nel template allora se anche SOLO
            //un campo manca c'è qualcosa che non va:
            //inoltre, volendo, si può fare il controllo se l'admin idiota sta caricando tipo il padrino un'altra volta
            //possiamo usare l'existByTitoloeAnno?
            if($titolo != null && !FPersistentManager::exist("EFilm", null, null, null, null, null,
                $titolo, $data->format('Y'), null)) {
                $film = new EFilm(null, $titolo, $data, $durata, $sinossi, null, null,
                    $listaRegisti, $listaAttori, null);

                FPersistentManager::store($film, $film, null, null, null,
                    $immagine, $tipoImmagine, $sizeImmagine);
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
    L'admin vuole modificare un attributo di un film,
    url localhost/admin/modifica-film/id
    */
    public static function modificaFilm(int $id): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $id = 2;
            $view = new VAdmin();
            //se il film non è completo dà problemi con l'eventuale update di lista attori o registi
            //ad esempio?
            $film = FPersistentManager::load("EFilm", $id, null, null,
                null, null, null, null, true);
            $array_modifiche = $view->getElementidaModificare();
            //l'idea è controllare se sono settati i valori strani da modificare poi andare con un ciclo
            //oppure in maniera più safe procedere con gli isset
            if(isset($array_modifiche['data'])){
                FPersistentManager::update($film, null, null, null, null,
                    $array_modifiche['data'], null, null);
            }
            if(isset($array_modifiche['attori'])){
                FPersistentManager::update($film, null, null, null,
                    null, null, $array_modifiche['attori'], null);
            }
            if(isset($array_modifiche['registi'])){
                FPersistentManager::update($film, null, null, null,
                    null, null, null, $array_modifiche['registi']);
            }
            if(isset($array_modifiche['locandina'])){
                FPersistentManager::updateLocandina($film, $array_modifiche['locandina']['tmp_name'],
                    $array_modifiche['locandina']['type'], $array_modifiche['locandina']['size']);
            }
            if(isset($array_modifiche['titolo'])){
                FPersistentManager::update($film , 'titolo' , $array_modifiche['titolo'] , null ,
                    null , null , null , null);
            }
            if(isset($array_modifiche['durata'])){
                FPersistentManager::update($film , 'durata' , $array_modifiche['durata'] , null ,
                    null , null , null , null);
            }
            if(isset($array_modifiche['sinossi'])){
                FPersistentManager::update($film , 'sinossi' , $array_modifiche['sinossi'] , null ,
                    null , null , null , null);
            }
            //reinderizzo alla pagina dell'admin (?) -> caricaAmministrazione
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    /*
     metodo che serve all'admin quando vuole eliminare una recensione di un member.
    Url localhost/admin/rimuovi-recensione fatta in post i dati vengono inviati nel body della richiesta
    */
    public static function rimuoviRecensione(int $idFilm, string $usernameAutore): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $idFilm = 2;
            $usernameAutore = "pippo";
            FPersistentManager::delete("ERecensione", $usernameAutore, null, null, $idFilm, null);
            //notifica che sto eliminando la recensione. -> alla pagina dell'admin
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

     //idem come sopra() url localhost/admin/rimuovi-risposta
    public static function rimuoviRisposta(string $usernameAutore, string $data): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            //qualcuno mi procurera' i dati
            $idFilm = 1;
            $data_oggetto = ERisposta::ConvertiFormatoUrlInData($data);
            $usernameAutore = "matteo";
            FPersistentManager::delete("ERisposta", $usernameAutore, null, null, null, $data_oggetto);
            //notifica che ho eliminato la risposta -> alla pagina dell'admin
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    /*
    metodo che permette all'admin di ammonire il member,
    url localhost/admin/ammonisci-user/username
    */
    public static function ammonisciUser(string $usernameMember): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $usernameMember = "matteo";
            //in teoria si clicca su ammonisci user quando non è bannato
            if (!FPersistentManager::userBannato($usernameMember)) {
                $memberDaAmmonire = FPersistentManager::load("EMember", null, $usernameMember, null,
                    null, null, null, null, false);

                $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();
                if ($warningMemberDaAmmonire < EAdmin::$warningMassimi) {
                    FPersistentManager::incrementaWarning($usernameMember);
                    if ($memberDaAmmonire->getWarning() == EAdmin::$warningMassimi) {
                        FPersistentManager::bannaUser($memberDaAmmonire->getUsername());
                    }
                }
                //reinderizzo alla pagina del modera-utente
            }

            else {
                //print("Utente bannato");
                $view = new VErrore();
                $view->error(13);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }


    /*
      metodo che permette all'admin di sbannare il member o l'admin
    url localhost/admin/sbanna-user/username
     */

    public static function sbannaUser(string $username): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            $username = "giangiacomo";


            //in teoria qua avevamo pensato di togliere la moderazione degli admin
            //e lasciare solo quella dei member, ma per non far casini lascio così per ora
            if (FPersistentManager::userBannato($username)) {
                    FPersistentManager::sbannaUser($username);
                    FPersistentManager::decrementaWarning($username);
                    //reinderizzo alla pagina del modera-utente
            }
            else {
                //print ("l'utente non è bannato");
                $view = new VErrore();
                $view->error(14);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }
    }

    /*
     metodo che permette di decrementare un warning al member
    url localhost/admin/togli-ammonizione/username
    */
    public static function togliAmmonizione(string $username): void {
        if(SessionHelper::isLogged() && SessionHelper::getUtente()->chiSei() == "Admin") {
            //verifica che sei l'admin
            $admin = SessionHelper::getUtente()->getUsername();
            $memberDaAmmonire = FPersistentManager::load("EMember", null, $username, null,
                null, null, null, null, false);
            // calcolo dei warning attuali
            $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();

            if (!FPersistentManager::userBannato($username) && $warningMemberDaAmmonire > 0) {
                    FPersistentManager::decrementaWarning($username);
                //reinderizzo alla pagina del modera-utente
            }
            else {
                //print ("l'utente è bannato");
                $view = new VErrore();
                $view->error(13);
            }
        }
        else{
            //forse un po' drastico far apparire una schermata di errore però per ora ok
            $view = new VErrore();
            $view->error(8);
        }

    }
}