<?php

class CAdmin {

    /*
       una volta che l'admin è loggato per andare alla sua pagina,
       url localhost/admin/carica-amministrazione
     */
    public static function caricaAmministrazione(): void {
        //controllare se sei l'admin
        $view = new VAdmin();
        // $admin dalla sessione
        //$view->avviaPaginaAdmin($admin);
    }

    //TODO: ricontrolla le url
    //deve solo mostrare il template -> la url sarà localhost/mostra-film/id (?)
    public static function mostraFilm(int $idfilm): void{
        //carico le info del film
        $film = FPersistentManager::load("EFilm",$idfilm,null,null,
            null,null,null,null,false);
        $view = new VAdmin();
        $view->avviaPaginaModificaFilm($film);
    }

    //deve solo mostrare il template -> la url sarà localhost/mostra-member/username (?)
    public static function mostraMember(string $username): void{
        //carico le info del member
        $member = FPersistentManager::load("EMember",null,$username,null,null,
            null,null,null,false);
        $view = new VAdmin();
        $view->avviaPaginaModeraUtente($member);
    }

    /*
      metodo che serve all'admin per caricare un film nella piattaforma, metodo in post, url
    localhost/admin/carica-film
    */
    public static function caricaFilm(): void {
        //prendere dalla view le informazioni del film
        //verifica che sei l'admin
        $titolo = "prova";
        $data = new DateTime('now'); // da cambiare in data presa
        $durata = 120;
        $sinossi = "un bel film di prova";
        $listaRegisti = array();
        $listaAttori = array();
        $immagine = "prova";
        $tipoImmagine = "jpeg";
        $sizeImmagine = "1920x1080";

        $film = new EFilm(null, $titolo , $data , $durata , $sinossi , null , null,
            $listaRegisti , $listaAttori , null );

        FPersistentManager::store($film , $film ,null , null ,null ,
            $immagine , $tipoImmagine , $sizeImmagine);
    }


    /*
    L'admin vuole modificare un attributo di un film,
    url localhost/admin/modifica-film/id
    */
    public static function modificaFilm(int $id): void {
        //verifica che sei l'admin

        /*possiamo fare una checkbox dove l'admin seleziona l'attributo da eliminare*/

        $id = 2;
        $film = FPersistentManager::load("EFilm" , $id ,null ,null ,
            null , null , null ,null ,false);

        $nuovoValore = array();
        $nomeAttributo = "sinossi";

        if($nomeAttributo == "data") {
            FPersistentManager::update($film, null, null, null, null,
                $nuovoValore, null, null);
            return;
        }

        if($nomeAttributo == "attori") {
            FPersistentManager::update($film, null, null, null,
                null, null, $nuovoValore, null);
            return;
        }

        if($nomeAttributo == "registi")
            FPersistentManager::update($film, null, null, null,
                null, null, null, $nuovoValore);

        else {
            FPersistentManager::update($film , $nomeAttributo , $nuovoValore , null ,
            null , null , null , null);
        }
        //da rivedere non mi piace per nulla
    }

    /*
     metodo che serve all'admin quando vuole eliminare una recensione di un member.
    Url localhost/admin/rimuovi-recensione fatta in post i dati vengono inviati nel body della richiesta
    */
    public static function rimuoviRecensione(): void {

        //verifica che sei l'admin
        //dati che qualcuno mi dara'
        $idFilm = 2;
        $usernameAutore = "pippo";
        FPersistentManager::delete("ERecensione", $usernameAutore,null,null, $idFilm,null);
        //notifica che sto eliminando la recensione.
    }

     //idem come sopra() url localhost/admin/rimuovi-risposta
    public static function rimuoviRisposta(): void {

        //qualcuno mi procurera' i dati
        $idFilm = 1;
        $data = new DateTime();
        $usernameAutore = "matteo";
        FPersistentManager::delete("ERisposta", $usernameAutore,null,null,null, $data);
        //notifica che ho eliminato la risposta
    }

    /*
    metodo che permette all'admin di ammonire il member,
    url localhost/admin/ammonisci-user/username
    */
    public static function ammonisciUser(String $username): void {

        //verifica che sei l'admin
        //recupero lo username dell'admin dalla sessione
        $username = "admin";
        $usernameMember = "matteo";
        if(!FPersistentManager::userBannato($usernameMember)) {
            $memberDaAmmonire = FPersistentManager::load("EMember",null,$usernameMember,null,
                null, null ,null, null, false);

            $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();
            if($warningMemberDaAmmonire < EAdmin::$warningMassimi) {
                FPersistentManager::incrementaWarning($usernameMember);
                if($memberDaAmmonire->getWarning() == EAdmin::$warningMassimi) {
                    FPersistentManager::bannaUser($memberDaAmmonire->getUsername());
                }
            }
        }
        else
            print("Utente bannato");
    }


    /*
      metodo che permette all'admin di sbannare il member o l'admin
    url localhost/admin/sbanna-user/username
     */

    public static function sbannaUser(String $username): void {
        //verifica che sei l'admin

        $username = "giangiacomo";
        $usernameAdmin = "alberto";

        if(FPersistentManager::userBannato($username)) {
            if(FPersistentManager::tipoUserRegistrato($username)=="Admin")
                FPersistentManager::sbannaUser($username);
            else {
                FPersistentManager::sbannaUser($username);
                FPersistentManager::decrementaWarning($username);
            }
        }
        else
            print ("l'utente non è bannato");
    }

    /*
     metodo che permette di decrementare un warning al member
    url localhost/admin/togli-ammonizione/username
    */
    public static function togliAmmonizione($username): void {

        //verifica che sei l'admin
        $usernameAdmin = "alberto";
        $memberDaAmmonire = FPersistentManager::load("EMember",null,$username,null,
            null, null ,null, null, false);
        // calcolo dei warning attuali
        $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();

        if(!FPersistentManager::userBannato($username) && $warningMemberDaAmmonire>0) {
            if(FPersistentManager::tipoUserRegistrato($username)=="Member")
                FPersistentManager::decrementaWarning($username);
        }
        else
            print ("l'utente è bannato");
    }
}