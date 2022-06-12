<?php

class FMember {

    private static string $nomeClasse = "FMember"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "member";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoBio = "Bio";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoWarning = "Warning";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoDataIscrizione = "DataIscrizione";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoImmagineProfilo = "ImmagineProfilo";
    private static string $nomeAttributoTipoImmagineProfilo = "TipoImmagineProfilo";
    private static string $nomeAttributoSizeImmagineProfilo = "SizeImmagineProfilo";

    private static string $nomeTabellaRisposta = "risposta";
    private static string $chiave1TabellaRisposta = "UsernameAutore";
    private static string $nomeAttributoRispostaDataScrittura = "DataScrittura";
    private static string $nomeAttributoRispostaTesto = "Testo";
    private static string $nomeAttributoRispostaUsernameAutoreRecensione = "UsernameAutoreRecensione";
    private static string $nomeAttributoRispostaIdFilmRecensito = "IdFilmRecensito";

    private static string $nomeTabellaUser = "user";
    private static string $chiaveTabellaUser = "Username"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoUserPassword = "Password";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoUserRuolo = "Ruolo";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoUserRuolo = "Member";   // da cambiare se cambia il nome del valore in DB

    private static string $nomeTabellaParteSocial = "partesocial";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaParteSocial = "UtenteFollower";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaParteSocial = "UtenteSeguito";   // da cambiare se cambia il nome della chiave2 in DB

    private static string $nomeTabellaRecensione = "recensione"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaRecensione = "IdFilmRecensito";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaRecensione = "UsernameAutore";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeAttributoRecensioneVoto = "Voto";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRecensioneTesto = "Testo";// da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRecensioneDataScrittura = "DataScrittura";   // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaFilm = "film";  // da cambiare se cambia il nome della tabella Film in DB
    private static string $chiaveTabellaFilm = "IdFilm";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoFilmTitolo = "Titolo";  // nome dell'attributo titolo nel DB
    private static string $nomeAttributoFilmAnno = "Anno";  // nome dell'attributo anno nel DB
    private static string $nomeAttributoFilmDurata = "Durata";  // nome dell'attributo anno nel DB
    private static string $nomeAttributoFilmSinossi = "Sinossi";  // nome dell'attributo anno nel DB
    private static string $nomeAttributoFilmVotoMedio = "VotoMedio";  // nome dell'attributo voto nel DB

    private static string $nomeTabellaFilmVisti = "filmvisti";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaFilmVisti = "IdFilmVisto";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaFilmVisti = "UtenteCheHaVisto";   // da cambiare se cambia il nome della chiave2 in DB

    // si userà l'exist di User per verificare l'esistenza di un member

    // recupero dati dal DB per creazione oggetto member passando come parametro la chiave username, da fare dopo
    // autenticazione con FUser::userRegistrato e FUser::tipoUserRegistrato
    // con i parametri booleani si caricheranno anche gli array che fanno da attributo
    public static function load(string $username, bool $listaFilmVisti, bool $listaFollower, bool $listaFollowing,
                                bool $recensioniScritte): ?EMember {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            // caricamento lista film se $listaFilmVisti è settato a true
            $queryResultFilmVisti = array();
            if($listaFilmVisti) $queryResultFilmVisti = FMember::loadListaFilmVisti($username);

            // caricamento lista follower se $listaFollower è settato a true
            $queryResultFollower = array();
            if($listaFollower) $queryResultFollower = FMember::loadListaFollower($username);

            // caricamento lista following se $listaFollowing è settato a true
            $queryResultFollowing = array();
            if($listaFollowing) $queryResultFollowing = FMember::loadListaFollowing($username);

            // caricamento lista recensioni se $recensioniScritte è settato a true
            $queryResultRecensioni = array();
            if($recensioniScritte) $queryResultRecensioni = FMember::loadListaRecensioni($username);

            if($queryResult) {
                return new EMember($queryResult[self::$chiaveTabella], new DateTime($queryResult[self::$nomeAttributoDataIscrizione]),
                    $queryResult[self::$nomeAttributoBio], $queryResult[self::$nomeAttributoWarning],
                    $queryResultFilmVisti, $queryResultFollower, $queryResultFollowing, $queryResultRecensioni);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    public static function loadListaFilmVisti($username): ?array {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "f." . self::$chiaveTabellaFilm . ", f." . self::$nomeAttributoFilmTitolo .
                ", f." . self::$nomeAttributoFilmAnno . ", f." . self::$nomeAttributoFilmDurata .
                ", f." . self::$nomeAttributoFilmSinossi .
                " FROM " . self::$nomeTabellaFilm . " f " .
                " JOIN " . self::$nomeTabellaFilmVisti . " fv " .
                " ON " . "f." . self::$chiaveTabellaFilm . " = " . "fv." . self::$chiave1TabellaFilmVisti .
                " JOIN " . self::$nomeTabella . " m " .
                " ON " . "m." . self::$chiaveTabella . " = " . "fv." . self::$chiave2TabellaFilmVisti .
                " WHERE " . " m." . self::$chiaveTabella . " = '" . $username . "'" .
                " ORDER BY " . "f." . self::$nomeAttributoFilmTitolo . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // quì si potrebbero caricare anche il numero di views e il voto medio di ciascun film ma necessiterebbe
            // probabilmente molto tempo, facendo un for di load da DB. Allora si costruiscono film con null come
            // valore in questi due campi e, all'eventuale click, si associerà il load by id che carica anche il numero
            // views e il voto medio

            // array di EFilm
            $filmResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $filmResult[] = new EFilm($row[self::$chiaveTabellaFilm], $row[self::$nomeAttributoFilmTitolo],
                        new DateTime($row[self::$nomeAttributoFilmAnno]), $row[self::$nomeAttributoFilmDurata],
                        $row[self::$nomeAttributoFilmSinossi], null, null, null,
                        null, null);
                }
            }
            return $filmResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // restituisce un array di member follower dello username inserito per parametro
    public static function loadListaFollower($username): ?array {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "f." . self::$chiaveTabella . ", f." . self::$nomeAttributoBio .
                ", f." . self::$nomeAttributoDataIscrizione . ", f." . self::$nomeAttributoWarning .
                " FROM " . self::$nomeTabella . " f " .
                " JOIN " . self::$nomeTabellaParteSocial . " p " .
                " ON " . "p." . self::$chiave1TabellaParteSocial . " = " . "f." . self::$chiaveTabella .
                " JOIN " . self::$nomeTabella . " m " .
                " ON " . "m." . self::$chiaveTabella . " = " . "p." . self::$chiave2TabellaParteSocial .
                " WHERE " . " m." . self::$chiaveTabella . " = '" . $username . "'" .
                " ORDER BY " . "f." . self::$chiaveTabella . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di EMember
            $memberResult = array();
           if($queryResult) {
                foreach($queryResult as $row) {
                    $memberResult[] = new EMember($row[self::$chiaveTabella], new DateTime($row[self::$nomeAttributoDataIscrizione]),
                        $row[self::$nomeAttributoBio], $row[self::$nomeAttributoWarning],
                        null, null, null, null);
                }
            }
            return $memberResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // restituisce un array di member che lo username inserito per parametro segue
    public static function loadListaFollowing($username): ?array {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "f." . self::$chiaveTabella . ", f." . self::$nomeAttributoBio .
                ", f." . self::$nomeAttributoDataIscrizione . ", f." . self::$nomeAttributoWarning .
                " FROM " . self::$nomeTabella . " f " .
                " JOIN " . self::$nomeTabellaParteSocial . " p " .
                " ON " . "p." . self::$chiave2TabellaParteSocial . " = " . "f." . self::$chiaveTabella .
                " JOIN " . self::$nomeTabella . " m " .
                " ON " . "m." . self::$chiaveTabella . " = " . "p." . self::$chiave1TabellaParteSocial .
                " WHERE " . " m." . self::$chiaveTabella . " = '" . $username . "'" .
                " ORDER BY " . "f." . self::$chiaveTabella . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di EMember
            $memberResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $memberResult[] = new EMember($row[self::$chiaveTabella], new DateTime($row[self::$nomeAttributoDataIscrizione]),
                        $row[self::$nomeAttributoBio], $row[self::$nomeAttributoWarning], null, null,
                        null, null);
                }
            }
            return $memberResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    public static function loadListaRecensioni($username): ?array {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "r." . self::$chiave1TabellaRecensione . ", r." . self::$chiave2TabellaRecensione .
                ", r." . self::$nomeAttributoRecensioneVoto . ", r." . self::$nomeAttributoRecensioneTesto .
                ", r." . self::$nomeAttributoRecensioneDataScrittura .
                " FROM " . self::$nomeTabellaRecensione . " r " .
                " JOIN " . self::$nomeTabella . " m " .
                " ON " . "m." . self::$chiaveTabella . " = " . "r." . self::$chiave2TabellaRecensione .
                " WHERE " . " m." . self::$chiaveTabella . " = '" . $username . "'" .
                " ORDER BY " . "r." . self::$nomeAttributoRecensioneDataScrittura . " DESC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di ERecensioni
            $recensioniResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $recensioniResult[] = new ERecensione($row[self::$chiave1TabellaRecensione],
                        $row[self::$chiave2TabellaRecensione],
                        $row[self::$nomeAttributoRecensioneVoto], $row[self::$nomeAttributoRecensioneTesto],
                        new DateTime( $row[self::$nomeAttributoRecensioneDataScrittura]),null);
                }
            }
            return $recensioniResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto member sul DB insieme alla sua immagine profilo, se non si vuole salvare l'immagine del profilo
    // per il momento inserire null nei 3 parametri relativi a essa
    public static function store(EMember $member, string $password, ?string $immagineProfilo, ?string $tipoImmagineProfilo,
                                 ?string $sizeImmagineProfilo): void {

        // si controlla se il member non sia già presente in DB prima di procedere
        if(!(FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                // salvataggio nella tabella User
                $query =
                    "INSERT INTO " . self::$nomeTabellaUser .
                    " VALUES (:Username, :Password, :Ruolo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $member->getUsername(),
                    ":Password" => $password,
                    ":Ruolo" => self::$valoreAttributoUserRuolo));

                // salvataggio nella tabella Member
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (:Username, :Bio, :Warning, :DataIscrizione, :ImmagineProfilo, :TipoImmagineProfilo, 
                    :SizeImmagineProfilo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $member->getUsername(),
                    ":Bio" => $member->getBio(),
                    ":Warning" => $member->getWarning(),
                    ":DataIscrizione" => $member->getDataIscrizione()->format('Y-m-d'),
                    ":ImmagineProfilo" => $immagineProfilo,
                    ":TipoImmagineProfilo" => $tipoImmagineProfilo,
                    ":SizeImmagineProfilo" => $sizeImmagineProfilo));

                $pdo->commit();
                echo "\nInserimento avvenuto con successo!";
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nInserimento annullato!";
            }
        }
    }


    // salva il film con id $idFilm guardato dal member $username nella tabella filmVisti
    public static function vediFilm(EMember $member, EFilm $film): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            // salvataggio nella tabella filmVisti
            $query =
                "INSERT INTO " . self::$nomeTabellaFilmVisti .
                " VALUES (:IdFilmVisto, :UtenteCheHaVisto);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                ":IdFilmVisto" => $film->getId(),
                ":UtenteCheHaVisto" => $member->getUsername()));
            $pdo->commit();
            echo "\nInserimento avvenuto con successo!";
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nInserimento annullato!";
        }
    }


    // rimuove il film con $idFilm guardato dal member $username dalla tabella filmVisti
    public static function rimuoviFilmVisto(EMember $member, EFilm $film): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "DELETE FROM " . self::$nomeTabellaFilmVisti .
                " WHERE " . self::$chiave1TabellaFilmVisti . " = '" . $film->getId() . "'" .
                " AND " . self::$chiave2TabellaFilmVisti . " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $pdo->commit();
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }



    // da usare quando l'EMember usa il metodo follow verso uno $usernameFollowing
    // inserisce uno $usernameFollower nella tabella parteSocial del DB che seguirà lo $usernameFollowing
    public static function follow(EMember $follower, EMember $following): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($following->getUsername())) {
                $query =
                    "INSERT INTO " . self::$nomeTabellaParteSocial .
                    " VALUES (:UtenteFollower, :UtenteFollowing);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":UtenteFollower" => $follower->getUsername(),
                    ":UtenteFollowing" => $following->getUsername()));
                $pdo->commit();
                echo "\nInserimento avvenuto con successo!";
            }
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nInserimento annullato!";
        }
    }


    // da usare quando l'EMember usa il metodo unfollow
    // cancella un $usernameFollowing dalla tabella partesocial del DB che figura come following del $usernameFollower
    public static function unfollow(EMember $follower, EMember $following): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($following->getUsername())) {
                $query =
                    "DELETE FROM " . self::$nomeTabellaParteSocial .
                    " WHERE " . self::$chiave1TabellaParteSocial . " = '" . $follower->getUsername() .  "'" .
                    " AND " . self::$chiave2TabellaParteSocial . " = '" . $following->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }


    // update da usare per aggiornare l'attributo Bio
    public static function updateBio(EMember $member, ?string $nuovaBio): void {

        if((FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoBio . " = '" . $nuovaBio . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // update da usare per aumentare il numero dei warning del member e si verifica anche che non sia già bannato
    public static function incrementaWarning(EMember $member): void {

        if(FUser::exist($member->getUsername()) && !FUser::userBannato($member->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoWarning . " = " . self::$nomeAttributoWarning . " +1" .
                    " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // update da usare per diminuire il numero dei warning del member e si verifica anche che non sia già bannato
    public static function decrementaWarning(EMember $member): void {

        if(FUser::exist($member->getUsername()) && !FUser::userBannato($member->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoWarning . " = " . self::$nomeAttributoWarning . " -1" .
                    " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // aggiorna la password del member nella tabella User del DB
    public static function updatePassword(EMember $member, string $nuovaPassword): void {

        if(FUser::exist($member->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabellaUser .
                    " SET " . self::$nomeAttributoUserPassword . " = '" . $nuovaPassword . "'" .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // cancella un Member dalla tabella user del DB e,  grazie alle FK, anche da tutte le altre dove potrebbe comparire
    public static function delete(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($username)) {
                // eliminazione dalla tabella user
                $query =
                    "DELETE FROM " . self::$nomeTabellaUser .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }


    public static function calcolaNumeroFilmVisti(EMember $member): ?int {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
               " SELECT COUNT(*) AS NumeroFilmVisti FROM " . self::$nomeTabella .
               " JOIN " . self::$nomeTabellaFilmVisti .
               " ON " . self::$chiaveTabella .
               " = " . self::$chiave2TabellaFilmVisti .
               " WHERE " . self::$chiaveTabellaUser .
               " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroFilmVisti"];
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function calcolaNumeroFollowing(EMember $member): ?int {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                " SELECT COUNT(*) AS NumeroFollowing 
                FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaParteSocial .
                " ON " . self::$chiaveTabella .
                " = " . self::$chiave1TabellaParteSocial.
                " WHERE " . self::$chiaveTabellaUser .
                " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroFollowing"];
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function calcolaNumeroFollower(EMember $member): ?int {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                " SELECT COUNT(*) AS NumeroFollower
                FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaParteSocial .
                " ON " . self::$chiaveTabella . " = " . self::$chiave2TabellaParteSocial .
                " WHERE " . self::$chiaveTabellaUser .
                " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroFollower"];
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function calcolaNumeroRecensioni(EMember $member): ?int {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                " SELECT COUNT(*) AS NumeroRecensioni 
                FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaRecensione .
                " ON " . self::$chiaveTabella .
                " = " . self::$chiave2TabellaRecensione .
                " WHERE " . self::$chiaveTabellaUser .
                " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroRecensioni"];
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function calcolaNumeroRisposte(EMember $member): ?int {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                " SELECT COUNT(*) AS NumeroRisposte 
                FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaRisposta .
                " ON " . self::$chiaveTabella .
                " = " . self::$chiave1TabellaRisposta .
                " WHERE " . self::$chiaveTabellaUser .
                " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroRisposte"];
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // metodo che restituisce un array contenente le ultime Recensioni scritte dal member passato come parametro
    public static function caricaUltimeRecensioniScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaRecensione.
                " WHERE " . self::$chiave2TabellaRecensione .
                " = '" . $member->getUsername(). "'" .
                " ORDER BY " . self::$nomeAttributoRecensioneDataScrittura .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $recensioni = array();

            foreach ($queryResult as $res){
                $recensione = new ERecensione($res[self::$chiave1TabellaRecensione], $res[self::$chiave2TabellaRecensione],
                    $res[self::$nomeAttributoRecensioneVoto], $res[self::$nomeAttributoRecensioneTesto],
                    new DateTime($res[self::$nomeAttributoRecensioneDataScrittura]),null);
                $recensioni[] = $recensione;
            }
            return $recensioni;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // metodo che restituisce un array contenente le ultime risposte scritte dal member passato come parametro
    public static function caricaUltimeRisposteScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "ri." . self::$nomeAttributoRispostaTesto . ",ri." . self::$nomeAttributoRispostaDataScrittura .
                ",ri." . self::$nomeAttributoRispostaUsernameAutoreRecensione .
                ",ri." . self::$chiave1TabellaRisposta . ",ri." . self::$nomeAttributoRispostaIdFilmRecensito .
                " FROM " . self::$nomeTabellaRisposta . " ri " .
                " JOIN " . self::$nomeTabellaRecensione . " re
                ON ri." . self::$nomeAttributoRispostaUsernameAutoreRecensione .
                " = " . "re." . self::$chiave2TabellaRecensione .
                " WHERE ri." . self::$chiave1TabellaRisposta .   " = '" . $member->getUsername() . "'" .
                " AND ri." . self::$nomeAttributoRispostaIdFilmRecensito .
                " = " . "re." . self::$nomeAttributoRispostaIdFilmRecensito .
                " ORDER BY " . "ri." . self::$nomeAttributoRispostaDataScrittura .
                " ASC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risposte = array();

            foreach ($queryResult as $ris) {
                $risposta = new ERisposta($ris[self::$chiave1TabellaRisposta], new DateTime($ris[self::$nomeAttributoRispostaDataScrittura]),
                    $ris[self::$nomeAttributoRispostaTesto], $ris[self::$nomeAttributoRispostaIdFilmRecensito],
                    $ris[self::$nomeAttributoRispostaUsernameAutoreRecensione]);
                $risposte[] = $risposta;
            }
            return $risposte;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    //metodo che carica le ultime attivita' svolte dal member passato come parametro
    public static function caricaUltimeAttivitaMember( EMember $member, int $numeroDiEstrazioni): ?array {

        $arrayRecensioni = FMember::caricaUltimeRecensioniScritteUtente($member,$numeroDiEstrazioni/2);
        $arrayRisposte = FMember::caricaUltimeRisposteScritteUtente($member,$numeroDiEstrazioni/2);
        $arrayUltimeAttivita = array_merge($arrayRecensioni, $arrayRisposte);
        // shuffle($arrayUltimeAttivita);
        return $arrayUltimeAttivita;
    }


    // metodo che restituisce un array contenente le ultime Risposte scritte dai membri seguiti dal membro
    // passato come parametro
    public static function caricaUltimeRecensioniScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaRecensione.
                " INNER JOIN ".self::$nomeTabellaParteSocial .
                " ON " . self::$chiave2TabellaRecensione .
                " = ". self::$chiave2TabellaParteSocial .
                " WHERE " . self::$chiave1TabellaParteSocial .
                " = '" . $member->getUsername(). "'" .
                " ORDER BY " . self::$nomeAttributoRecensioneDataScrittura .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $recensioni = array();

            foreach ($queryResult as $res){
                $recensione = new ERecensione($res[self::$chiave1TabellaRecensione], $res[self::$chiave2TabellaRecensione],
                    $res[self::$nomeAttributoRecensioneVoto], $res[self::$nomeAttributoRecensioneTesto],
                    new DateTime($res[self::$nomeAttributoRecensioneDataScrittura]),null);
                $recensioni[] = $recensione;
            }
            return $recensioni;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    //metodo che restituisce un array contenente le ultime Recensioni scritte dai membri seguiti dal membro
    // passato come parametro
    public static function caricaUltimeRisposteScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {

        if(!(FUser::exist($member->getUsername()))) {
            print("Questo member non esiste");
            return null;
        }
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaRisposta.
                " INNER JOIN ".self::$nomeTabellaParteSocial .
                " ON " . self::$chiave1TabellaRisposta.
                " = ". self::$chiave2TabellaParteSocial .
                " WHERE " . self::$chiave1TabellaParteSocial .
                " = '" . $member->getUsername(). "'" .
                " ORDER BY " . self::$nomeAttributoRecensioneDataScrittura .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risposte= array();

            foreach ($queryResult as $res){
                $risposta = new ERisposta($res[self::$chiave1TabellaRisposta], new DateTime($res[self::$nomeAttributoRispostaDataScrittura]),
                    $res[self::$nomeAttributoRispostaTesto], $res[self::$nomeAttributoRispostaIdFilmRecensito],
                    $res[self::$nomeAttributoRispostaUsernameAutoreRecensione]);
                $risposte[] = $risposta;
            }
            return $risposte;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // metodo che carica le ultime attività dei membri seguiti dal member passato come parametro
    // passare un $numeroDiEstrazioni pari!!
    public static function caricaUltimeAttivitaUtentiSeguiti( EMember $member, int $numeroDiEstrazioni): ?array {

        $arrayRecensioni = FMember::caricaUltimeRecensioniScritteUtentiSeguiti($member,$numeroDiEstrazioni/2);
        $arrayRisposte = FMember::caricaUltimeRisposteScritteUtentiSeguiti($member,$numeroDiEstrazioni/2);
        $arrayUltimeAttivita = array_merge($arrayRecensioni, $arrayRisposte);
        // shuffle($arrayUltimeAttivita);
        return $arrayUltimeAttivita;
    }


    // metodo che verifica se per un dato member è presente la sua immagine profilo
    public static function existImmagineProfilo(EMember $member): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "'" .
                " AND " . self::$nomeAttributoImmagineProfilo . " IS NOT NULL;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult) return true;
            return false;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che carica l'immagine profilo di un dato member, restituisce un array con i dati dell'immagine, il tipo e
    // la sua size
    // se si setta il bool $grande a true si carica la corrispettiva immagine in formato grande, piccola se false
    public static function loadImmagineProfilo(EMember $member, bool $grande): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResultMember = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResultMember) {
                // se $grande è settato a false si caricherà la locandina piccola
                if(!$grande)
                    $immagineProfilo = EMember::resizeImmagineProfilo($queryResultMember[self::$nomeAttributoImmagineProfilo]); //TODO

                return array($immagineProfilo, $queryResultMember[self::$nomeAttributoTipoImmagineProfilo],
                    $queryResultMember[self::$nomeAttributoSizeImmagineProfilo]);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che inserisce una nuova immagine profilo
    public static function updateImmagineProfilo(EMember $member, string $nuovaImmagine, string $nuovoTipoImmagine,
                                           string $nuovaSizeImmagine): void {

        if((FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoImmagineProfilo . " = '" . $nuovaImmagine . "', " .
                    self::$nomeAttributoTipoImmagineProfilo . " = '" . $nuovoTipoImmagine . "', " .
                    self::$nomeAttributoSizeImmagineProfilo . " = '" . $nuovaSizeImmagine . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // metodo che cancella un'immagine profilo facendo "update a null"
    public static function deleteImmagineProfilo(EMember $member): void {

        if((FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoImmagineProfilo . " = null, " .
                    self::$nomeAttributoTipoImmagineProfilo . " = null, "  .
                    self::$nomeAttributoSizeImmagineProfilo . " = null " .
                    " WHERE " . self::$chiaveTabella . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }
}