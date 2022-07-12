<?php

class FRisposta {

    // private static string $nomeClasse = "FRisposta";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "risposta";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella1 = "UsernameAutore";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiaveTabella2 = "DataScrittura";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeAttributoTesto = "Testo";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeFK1Tabella = "IdFilmRecensito";   // da cambiare se cambia il nome della FK1 in DB
    private static string $nomeFK2Tabella = "UsernameAutoreRecensione"; // da cambiare se cambia il nome della FK2 in DB


    /**
     * Metodo che verifica l'esistenza della risposta nel DB
     * @param string $usernameAutore
     * @param DateTime $dataScrittura
     * @return bool|null
     */
    public static function exist(string $usernameAutore, DateTime $dataScrittura): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutore = addslashes($usernameAutore);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella1 . " = '" . $usernameAutore . "'" .
                " AND " . self::$chiaveTabella2 . " = '" . $dataScrittura->format("Y-m-d H:i:s") . "';";
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


    /**
     * Metodo che carica la risposta dal DB
     * @param string $usernameAutore
     * @param DateTime $dataScrittura
     * @return ERisposta|null
     * @throws Exception
     */
    public static function load(string $usernameAutore, DateTime $dataScrittura): ?ERisposta {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutore = addslashes($usernameAutore);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella1 . " = '" . $usernameAutore . "'" .
                " AND " . self::$chiaveTabella2 . " = '" . $dataScrittura->format("Y-m-d H:i:s") . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult) {
                return new ERisposta($queryResult[self::$chiaveTabella1], new DateTime( $queryResult[self::$chiaveTabella2]),
                    $queryResult[self::$nomeAttributoTesto], $queryResult[self::$nomeFK1Tabella],
                    $queryResult[self::$nomeFK2Tabella]);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che salva la risposta nel DB
     * @param ERisposta $risposta
     * @return void
     */
    public static function store(ERisposta $risposta): void {

        if(!(FRisposta::exist($risposta->getUsernameAutore(), $risposta->getDataScrittura()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (:UsernameAutore, :DataScrittura, :Testo, :IdFilmRecensito, :UsernameAutoreRecensione);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":UsernameAutore" => $risposta->getUsernameAutore(),
                    ":DataScrittura" => $risposta->getDataScrittura()->format('Y-m-d H:i:s'),
                    ":Testo" => $risposta->getTesto(),
                    ":IdFilmRecensito" => $risposta->getIdFilmRecensito(),
                    ":UsernameAutoreRecensione" => $risposta->getUsernameAutoreRecensione()));
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
     * Metodo che aggiorna il testo della risposta
     * @param ERisposta $risposta
     * @param string|null $nuovoTesto
     * @return void
     */
    public static function updateTesto(ERisposta $risposta, ?string $nuovoTesto): void {

        if((FRisposta::exist($risposta->getUsernameAutore(), $risposta->getDataScrittura()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nuovoTesto = addslashes($nuovoTesto);
                $nuovaData = new DateTime();
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoTesto . " = '" . $nuovoTesto . "', " .
                        self::$chiaveTabella2 . " = '" . $nuovaData->format("Y-m-d H:i:s") . "'" .
                    " WHERE " . self::$chiaveTabella1 . " = '" . $risposta->getUsernameAutore() . "'" .
                    " AND " . self::$chiaveTabella2 . " = '" . $risposta->getDataScrittura()->format("Y-m-d H:i:s") . "';";
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
     * Metodo che cancella la risposta dal DB
     * @param string $usernameAutore
     * @param DateTime $dataScrittura
     * @return void
     */
    public static function delete(string $usernameAutore, DateTime $dataScrittura): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FRisposta::exist($usernameAutore, $dataScrittura)) {
                $usernameAutore = addslashes($usernameAutore);
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella1 . " = '" . $usernameAutore . "'" .
                    " AND " . self::$chiaveTabella2 . " = '" . $dataScrittura->format("Y-m-d H:i:s") . "';";
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


    // metodo inserito per ovviare al fatto che non c'è la FK a fare lo stesso lavoro
    /**
     * Metodo che cancella le risposte di una recensione
     * @param string $usernameAutoreRecensione
     * @param int $idFilmRecensito
     * @return void
     */
    public static function deleteRisposteDellaRecensione(string $usernameAutoreRecensione, int $idFilmRecensito): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $usernameAutoreRecensione = addslashes($usernameAutoreRecensione);
            $query =
                "DELETE FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeFK2Tabella . " = '" . $usernameAutoreRecensione . "'" .
                " AND " . self::$nomeFK1Tabella . " = '" . $idFilmRecensito . "';";
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
}