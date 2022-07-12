<?php

class FRecensione {

    // private static string $nomeClasse = "FRecensione";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "recensione";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1Tabella = "IdFilmRecensito";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2Tabella = "UsernameAutore";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeAttributoVoto = "Voto";  // da cambiare se cambia il nome dell'attributo voto di Recensione nel DB
    private static string $nomeAttributoTesto = "Testo";    // da cambiare se cambia il nome dell'attributo testo di Recensione nel DB
    private static string $nomeAttributoDataScrittura = "DataScrittura";    // da cambiare se cambia il nome dell'attributo data scrittura di Recensione nel DB

    private static string $nomeTabellaRisposta = "risposta";  // da cambiare se cambia il nome della tabella Risposta in DB
    private static string $chiave1TabellaRisposta = "UsernameAutore";   // da cambiare se cambia il nome della chiave1 di Risposta in DB
    private static string $chiave2TabellaRisposta = "DataScrittura";   // da cambiare se cambia il nome della chiave2 di Risposta in DB
    private static string $nomeAttributoTestoRisposta = "Testo";    // da cambiare se cambia il nome dell'attributo testo in Risposta in DB
    private static string $nomeFK1Tabella = "IdFilmRecensito";    // da cambiare se cambia il nome della FK1 di Risposta in DB
    private static string $nomeFK2Tabella = "UsernameAutoreRecensione";   // da cambiare se cambia il nome della FK2 di Risposta in DB


    /**
     * Metodo che verifica l'esistenza della recensione nel DB
     * @param int $idFilmRecensito
     * @param string $usernameAutore
     * @return bool|null
     */
    public static function exist(int $idFilmRecensito, string $usernameAutore): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutore = addslashes($usernameAutore);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "'" .
                " AND " . self::$chiave2Tabella . " = '" . $usernameAutore . "'";
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


    // settando il parametro $risposte a true si caricheranno anche tutte le risposte della recensione
    /**
     * Metodo che carica la recensione dal DB
     * @param int $idFilmRecensito
     * @param string $usernameAutore
     * @param bool $risposte
     * @return ERecensione|null
     * @throws Exception
     */
    public static function load(int $idFilmRecensito, string $usernameAutore, bool $risposte): ?ERecensione {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutoreSlash = addslashes($usernameAutore);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "'" .
                " AND " . self::$chiave2Tabella . " = '" . $usernameAutoreSlash . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // se si è settato a true $risposte verranno caricate anche tutte le risposte e assegnate al costruttore
            $risposteResult = array();

            if($risposte)
                $risposteResult = self::loadRisposte($idFilmRecensito, $usernameAutore);

            // verificato sul DB, questo $queryResult è un array multidimensionale di un elemento in posto di chiave [0]
            if($queryResult) {
                return new ERecensione($queryResult[0][self::$chiave1Tabella], $queryResult[0][self::$chiave2Tabella],
                    $queryResult[0][self::$nomeAttributoVoto], $queryResult[0][self::$nomeAttributoTesto],
                    new DateTime( $queryResult[0][self::$nomeAttributoDataScrittura]), $risposteResult);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica le risposte della recensione
     * @param int $idFilmRecensito
     * @param string $usernameAutoreRecensione
     * @return array|null
     * @throws Exception
     */
    public static function loadRisposte(int $idFilmRecensito, string $usernameAutoreRecensione): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutoreRecensione = addslashes($usernameAutoreRecensione);
            $query =
                "SELECT " . "ri." . self::$chiave1TabellaRisposta . ", ri." . self::$chiave2TabellaRisposta .
                ", ri." . self::$nomeAttributoTestoRisposta . ", ri." . self::$nomeFK1Tabella .
                ", ri." . self::$nomeFK2Tabella .
                " FROM " . self::$nomeTabellaRisposta . " ri" .
                " JOIN " . self::$nomeTabella . " re" .
                " ON" . " re." . self::$chiave1Tabella . " = " . "ri." . self::$nomeFK1Tabella .
                " AND " . "re." . self::$chiave2Tabella . " = " . "ri." . self::$nomeFK2Tabella .
                " WHERE " . "ri." . self::$nomeFK1Tabella . " = '" . $idFilmRecensito . "'" .
                " AND " . "ri." . self::$nomeFK2Tabella . " = '" . $usernameAutoreRecensione . "'" .
                " ORDER BY " . self::$chiave2TabellaRisposta . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risposteResult = array();

            if($queryResult) {
                foreach ($queryResult as $row) {
                    $risposteResult[] = new ERisposta($row[self::$chiave1TabellaRisposta],
                        new DateTime($row[self::$chiave2TabellaRisposta]), $row[self::$nomeAttributoTestoRisposta],
                        $row[self::$nomeFK1Tabella], $row[self::$nomeFK2Tabella]);
                }
            }
            return $risposteResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che salva la recensione nel DB
     * @param ERecensione $recensione
     * @return void
     */
    public static function store(ERecensione $recensione): void {

        if(!(FRecensione::exist($recensione->getIdFilmRecensito(), $recensione->getUsernameAutore()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (:IdFilmRecensito, :UsernameAutore, :Voto, :Testo, :DataScrittura);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":IdFilmRecensito" => $recensione->getIdFilmRecensito(),
                    ":UsernameAutore" => $recensione->getUsernameAutore(),
                    ":Voto" => $recensione->getVoto(),
                    ":Testo" => $recensione->getTesto(),
                    ":DataScrittura" => $recensione->getDataScrittura()->format('Y-m-d H:i:s')));
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
     * Metodo che aggiorna un attributo di recensione con uno nuovo
     * @param ERecensione $recensione
     * @param string $nomeAttributo
     * @param string|null $nuovoValore
     * @return void
     */
    public static function update(ERecensione $recensione, string $nomeAttributo, ?string $nuovoValore): void {

        if((FRecensione::exist($recensione->getIdFilmRecensito(), $recensione->getUsernameAutore()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nomeAttributo = addslashes($nomeAttributo);
                $nuovoValore = addslashes($nuovoValore);
                $nuovaData = new DateTime();
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "', " .
                        self::$nomeAttributoDataScrittura . " = '" . $nuovaData->format("Y-m-d H:i:s") . "'" .
                    " WHERE " . self::$chiave1Tabella . " = '" . $recensione->getIdFilmRecensito() . "'" .
                    " AND " . self::$chiave2Tabella . " = '" . $recensione->getUsernameAutore() . "';";
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
     * Metodo che cancella una recensione dal DB
     * @param int $idFilmRecensito
     * @param string $usernameAutore
     * @return void
     */
    public static function delete(int $idFilmRecensito, string $usernameAutore): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FRecensione::exist($idFilmRecensito, $usernameAutore)) {
                $usernameAutore = addslashes($usernameAutore);
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiave2Tabella . " = '" . $usernameAutore . "'" .
                    " AND " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }

            // si occupa di cancellare tutte le risposte della recensione cancellata
            FRisposta::deleteRisposteDellaRecensione($usernameAutore, $idFilmRecensito);
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }
}