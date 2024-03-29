<?php

class FMember {

    private static int $maxSizeImmagineProfilo = 524288; // corrisponde ad mezzo Mebibyte, circa mezzo Megabyte (sui 16MiB di size massima consentita)

    // private static string $nomeClasse = "FMember"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "member";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoPassword = "Password";  // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoBio = "Bio";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoWarning = "Warning";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoDataIscrizione = "DataIscrizione";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoImmagineProfilo = "ImmagineProfilo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoTipoImmagineProfilo = "TipoImmagineProfilo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoSizeImmagineProfilo = "SizeImmagineProfilo";    // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaRisposta = "risposta";    // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaRisposta = "UsernameAutore";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoRispostaDataScrittura = "DataScrittura";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRispostaTesto = "Testo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRispostaUsernameAutoreRecensione = "UsernameAutoreRecensione";  // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRispostaIdFilmRecensito = "IdFilmRecensito";    // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaUser = "user";    // da cambiare se cambia il nome della tabella in DB
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
    // private static string $nomeAttributoFilmVotoMedio = "VotoMedio";  // nome dell'attributo voto nel DB

    private static string $nomeTabellaFilmVisti = "filmvisti";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaFilmVisti = "IdFilmVisto";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaFilmVisti = "UtenteCheHaVisto";   // da cambiare se cambia il nome della chiave2 in DB

    // si userà l'exist di User per verificare l'esistenza di un member
    // autenticazione con FUser::userRegistrato e FUser::tipoUserRegistrato
    // con i parametri booleani si caricheranno anche gli array che fanno da attributo
    /**
     * Metodo che carica un member dal DB
     * @param string $username
     * @param bool $listaFilmVisti
     * @param bool $listaFollower
     * @param bool $listaFollowing
     * @param bool $recensioniScritte
     * @return EMember|null
     * @throws Exception
     */
    public static function load(string $username, bool $listaFilmVisti, bool $listaFollower, bool $listaFollowing,
                                bool $recensioniScritte): ?EMember {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameSlash = addslashes($username);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $usernameSlash . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            // caricamento lista film se $listaFilmVisti è settato a true
            $queryResultFilmVisti = array();
            if($listaFilmVisti)
                $queryResultFilmVisti = FMember::loadListaFilmVisti($username);

            // caricamento lista follower se $listaFollower è settato a true
            $queryResultFollower = array();
            if($listaFollower)
                $queryResultFollower = FMember::loadListaFollower($username);

            // caricamento lista following se $listaFollowing è settato a true
            $queryResultFollowing = array();
            if($listaFollowing)
                $queryResultFollowing = FMember::loadListaFollowing($username);

            // caricamento lista recensioni se $recensioniScritte è settato a true
            $queryResultRecensioni = array();
            if($recensioniScritte)
                $queryResultRecensioni = FMember::loadListaRecensioni($username);

            if($queryResult) {
                return new EMember($queryResult[self::$chiaveTabella], new DateTime($queryResult[self::$nomeAttributoDataIscrizione]),
                    $queryResult[self::$nomeAttributoBio], $queryResult[self::$nomeAttributoWarning],
                    $queryResultFilmVisti, $queryResultFollower, $queryResultFollowing, $queryResultRecensioni);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica la lista dei film visti
     * @param $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFilmVisti($username): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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

            // array di EFilm
            $filmResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $numeroViews = FFilm::loadNumeroViews($row[self::$chiaveTabellaFilm]);
                    $votoMedio = FFilm::loadVotoMedio($row[self::$chiaveTabellaFilm]);
                    $filmResult[] = new EFilm($row[self::$chiaveTabellaFilm], $row[self::$nomeAttributoFilmTitolo],
                        new DateTime($row[self::$nomeAttributoFilmAnno]), $row[self::$nomeAttributoFilmDurata],
                        $row[self::$nomeAttributoFilmSinossi], $numeroViews, $votoMedio, null,
                        null, null);
                }
            }
            return $filmResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che verifica se un member ha visto un film
     * @param string $username
     * @param int $idFilm
     * @return bool|null
     * @throws Exception
     */
    public static function loHaiVisto(string $username, int $idFilm): ?bool {

        $filmVisti = FMember::loadListaFilmVisti($username);
        foreach ($filmVisti as $film) {
            if($idFilm == $film->getId())
                return true;
        }
        return false;
    }


    /**
     * Metodo che verifica se un member ne segue un altro
     * @param string $username
     * @param string $usernameFollowing
     * @return bool|null
     * @throws Exception
     */
    public static function loSegui(string $username, string $usernameFollowing): ?bool {

        $listaFollowing = FMember::loadListaFollowing($username);
        foreach ($listaFollowing as $following) {
            if($usernameFollowing == $following->getUsername())
                return true;
        }
        return false;
    }


    /**
     * Metodo che restituisce la lista dei follower del member
     * @param $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFollower($username): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica la lista dei following del member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFollowing(string $username): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica le lista delle recensioni del member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaRecensioni(string $username): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }

    // se non si vuole salvare l'immagine del profilo inserire null nei 3 parametri relativi a essa
    // la password verrà criptata
    /**
     * Metodo che salva il member nel DB
     * @param EMember $member
     * @param string $password
     * @param string|null $immagineProfiloPath
     * @param string|null $tipoImmagineProfilo
     * @param string|null $sizeImmagineProfilo
     * @return void
     */
    public static function store(EMember $member, string $password, ?string $immagineProfiloPath, ?string $tipoImmagineProfilo,
                                 ?string $sizeImmagineProfilo): void {

        if(!(FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                if($sizeImmagineProfilo > self::$maxSizeImmagineProfilo) {
                    print("Il file caricato è troppo grande!");
                    return;
                }

                if($immagineProfiloPath != null) {
                    // ricavo l'array con le info dell'immagine
                    $arrayGetImageSize = getimagesize($immagineProfiloPath);

                    // si accettano solo jpeg e png
                    if ($arrayGetImageSize['mime'] == !"image/jpeg" || $arrayGetImageSize['mime'] == "image/png")
                        return;

                    // si recupera il file da $_FILES['file']['tmp_name'] sottoforma di stringa
                    $immagineProfilo = file_get_contents($immagineProfiloPath);
                }
                else {
                    $immagineProfilo = null;
                    $arrayGetImageSize['mime'] = null;
                }
                // salvataggio nella tabella User
                $query =
                    "INSERT INTO " . self::$nomeTabellaUser .
                    " VALUES (:Username, :Password, :Ruolo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $member->getUsername(),
                    ":Password" => EMember::criptaPassword($password),
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
                    ":TipoImmagineProfilo" => $arrayGetImageSize['mime'],
                    ":SizeImmagineProfilo" => $sizeImmagineProfilo));

                $pdo->commit();
                echo "\nInserimento avvenuto con successo!";
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nInserimento annullato!";
            }
        }
    }


    /**
     * Metodo che salva la visione di un film da parte del member nel DB
     * @param EMember $member
     * @param EFilm $film
     * @return void
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nInserimento annullato!";
        }
    }


    /**
     * Metodo che rimuove la visione di un film da parte del member nel DB
     * @param EMember $member
     * @param EFilm $film
     * @return void
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }


    // inserisce uno $usernameFollower nella tabella parteSocial del DB che seguirà lo $usernameFollowing
    /**
     * Metodo che salva il segui del member nei confronti di un altro member
     * @param EMember $follower
     * @param EMember $following
     * @return void
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nInserimento annullato!";
        }
    }


    // cancella un $usernameFollowing dalla tabella partesocial del DB che figura come following del $usernameFollower
    /**
     * Metodo che rimuove il segui del member nei confronti di un altro member
     * @param EMember $follower
     * @param EMember $following
     * @return void
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }


    /**
     * Metodo che aggiorna la bio del member
     * @param EMember $member
     * @param string|null $nuovaBio
     * @return void
     */
    public static function updateBio(EMember $member, ?string $nuovaBio): void {

        if((FUser::exist($member->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nuovaBio = addslashes($nuovaBio);
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
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }


    /**
     * Metodo che incrementa i warning del member
     * @param string $username
     * @return void
     */
    public static function incrementaWarning(string $username): void {

        if(FUser::exist($username) && !FUser::userBannato($username)) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $username = addslashes($username);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoWarning . " = " . self::$nomeAttributoWarning . " +1" .
                    " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }


    /**
     * Metodo che decrementa i warning del member
     * @param string $username
     * @return void
     */
    public static function decrementaWarning(string $username): void {

        if(FUser::exist($username) && !FUser::userBannato($username)) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $username = addslashes($username);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoWarning . " = " . self::$nomeAttributoWarning . " -1" .
                    " WHERE " . self::$chiaveTabella . " = '" . $username. "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }


    /**
     * Metodo che aggiorna la password del member
     * @param EMember $member
     * @param string $nuovaPassword
     * @return void
     */
    public static function updatePassword(EMember $member, string $nuovaPassword): void {

        if(FUser::exist($member->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabellaUser .
                    " SET " . self::$nomeAttributoUserPassword . " = '" . EMember::criptaPassword($nuovaPassword) . "'" .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $member->getUsername() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }


    // razie alle FK, viene rimosso anche da tutte le altre dove potrebbe comparire
    /**
     * Metodo che rimuove il member dal DB
     * @param string $username
     * @return void
     */
    public static function delete(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($username)) {
                // eliminazione dalla tabella user
                $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }


    /**
     * Metodo che verifica l'esistenza di un member registrato ne DB
     * @param string $username
     * @param string $password
     * @return bool|null
     */
    public static function memberRegistrato(string $username, string $password): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
            $query =
                "SELECT * FROM " . self::$nomeTabellaUser .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "'" .
                " AND " . self::$nomeAttributoUserRuolo . " = '" . self::$valoreAttributoUserRuolo . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            // verificaPassword controlla se la password inserita corrisponde alla password hash recuperata da DB
            if($queryResult && EMember::verificaPassword($password, $queryResult[self::$nomeAttributoPassword])) return true;
            return false;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che restituisce il numero dei film visti dal member
     * @param EMember $member
     * @return int|null
     */
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


    /**
     * Metodo che restituisce il numero dei following del member
     * @param EMember $member
     * @return int|null
     */
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


    /**
     * Metodo che restituisce il numero dei follower del member
     * @param EMember $member
     * @return int|null
     */
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


    /**
     * Metodo che restituisce il numero delle recensioni del member
     * @param EMember $member
     * @return int|null
     */
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


    /**
     * Metodo che restituisce il numero delle risposte del member
     * @param EMember $member
     * @return int|null
     */
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


    /**
     * Metodo che restituisce le ultime recensioni scritte dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
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


    /**
     * Metodo che restituisce le ultime risposte scritte dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
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


    /**
     * Metodo che restituisce le ultime attività del member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeAttivitaMember(EMember $member, int $numeroDiEstrazioni): ?array {

        $arrayRecensioni = FMember::caricaUltimeRecensioniScritteUtente($member,$numeroDiEstrazioni/2);
        $arrayRisposte = FMember::caricaUltimeRisposteScritteUtente($member,$numeroDiEstrazioni/2);
        return array_merge($arrayRecensioni, $arrayRisposte);
    }


    /**
     * Metodo che restituisce le ultime recensioni scritte dagli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
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


    /**
     * Metodo che restituisce le ultime risposte scritte dagli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
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


    // passare un $numeroDiEstrazioni pari!!
    /**
     * Metodo che restituisce le ultime attività degli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeAttivitaUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {

        $arrayRecensioni = FMember::caricaUltimeRecensioniScritteUtentiSeguiti($member,$numeroDiEstrazioni/2);
        $arrayRisposte = FMember::caricaUltimeRisposteScritteUtentiSeguiti($member,$numeroDiEstrazioni/2);
        return array_merge($arrayRecensioni, $arrayRisposte);
    }


    /**
     * Metodo che verifica l'esistenza dell'immagine profilo del member
     * @param EMember $member
     * @return bool|null
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // Restituisce un array con i dati dell'immagine in base64, il tipo e la sua size.
    // Se si setta il bool $grande a true si carica la corrispettiva immagine in formato grande, piccola se false
    /**
     * Metodo che carica l'immagine profilo del member
     * @param EMember $member
     * @param bool $grande
     * @return array|null
     */
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
                // se $grande è settato a true si caricherà l'immagine profilo grande
                // $immagineProfilo sarà una stringa, presa dal db come blob
                if($grande) {
                    $immagineProfilo = EMember::resizeImmagineProfilo($queryResultMember[self::$nomeAttributoImmagineProfilo],
                        true);
                    $size = "width='" . EMember::$larghezzaGrande . "' " . "height='" . EMember::$altezzaGrande . "'";
                }
                else {
                    $immagineProfilo = EMember::resizeImmagineProfilo($queryResultMember[self::$nomeAttributoImmagineProfilo],
                        false);
                    $size = "width='" . EMember::$larghezzaPiccola . "' " . "height='" . EMember::$altezzaPiccola . "'";
                }
                // si procede all'encode come richiesto per il display dell'immagine
                $immagineProfilo = EMember::base64Encode($immagineProfilo);

                /* si è considerato che la query potrebbe restituire un immagine profilo null, in quel caso faremo un
                display di una immagine neutra, il classico omino in bianco e nero */
                return array($immagineProfilo, $queryResultMember[self::$nomeAttributoTipoImmagineProfilo], $size);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // L'array ha come chiavi gli username e valori array d'immagini profilo, tipo e size
    // se si setta il bool $grande a true si carica la corrispettiva immagine profilo in formato grande, piccola se false
    /**
     * Metodo che restituisce le immagini profilo di più member
     * @param array $arrayMembers
     * @param bool $grande
     * @return array|null
     */
    public static function loadImmaginiProfiloMembers(array $arrayMembers, bool $grande): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        // questo array avrà come chiave lo username e come valore un array d'immagini profilo, tipo e size
        $arrayUsernameImmagineProfilo = array();

        foreach($arrayMembers as $member) {
            $arrayUsernameImmagineProfilo[$member->getUsername()] = FMember::loadImmagineProfilo($member, $grande);;
        }
        $pdo->commit();
        return $arrayUsernameImmagineProfilo;
    }


    // quì il controllore, chiedendo alla view, fornisce a questo metodo il valore associato a
    // questo $_FILES['file']['tmp_name'], cioè la $nuovaImmagine appena caricata, con $_FILES['file']['type'] il
    // $nuovoTipoImmagine dell'immagine e con $_FILES['file']['size'] la sua $nuovaSizeImmagine
    /**
     * Metodo che aggiorna l'immagine profilo
     * @param string $username
     * @param string $nuovaImmaginePath
     * @param string $nuovoTipoImmagine
     * @param string $nuovaSizeImmagine
     * @return void
     */
    public static function updateImmagineProfilo(string $username, string $nuovaImmaginePath, string $nuovoTipoImmagine,
                                                 string $nuovaSizeImmagine): void {

        if($nuovaSizeImmagine > self::$maxSizeImmagineProfilo) {
            print("Il file caricato è troppo grande!");
            return;
        }
        if($nuovaImmaginePath != null) {
            // ricavo l'array con le info dell'immagine
            $arrayGetImageSize = getimagesize($nuovaImmaginePath);

            // si accettano solo jpeg e png
            if ($arrayGetImageSize['mime'] == !"image/jpeg" || $arrayGetImageSize['mime'] == "image/png") {
                print("Formato non valido!");
                return;
            }
            // si recupera il file da $_FILES['file']['tmp_name'] sottoforma di stringa
            $nuovaImmagineStringa = file_get_contents($nuovaImmaginePath);
            // eseguo l'escape
            $nuovaImmagineStringa = addslashes($nuovaImmagineStringa);
        }
        else {
            $nuovaImmagineStringa = null;
            $arrayGetImageSize['mime'] = null;
        }

        if((FUser::exist($username))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $username = addslashes($username);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoImmagineProfilo . " = '" . $nuovaImmagineStringa . "', " .
                    self::$nomeAttributoTipoImmagineProfilo . " = '" . $arrayGetImageSize['mime'] . "', " .
                    self::$nomeAttributoSizeImmagineProfilo . " = '" . $arrayGetImageSize[3] . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }


    // si procede facendo update a null
    /**
     * Metodo che cancella l'immagine profilo del member
     * @param string $username
     * @return void
     */
    public static function deleteImmagineProfilo(string $username): void {

        if((FUser::exist($username))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $username = addslashes($username);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoImmagineProfilo . " = null, " .
                    self::$nomeAttributoTipoImmagineProfilo . " = null, "  .
                    self::$nomeAttributoSizeImmagineProfilo . " = null " .
                    " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }
}