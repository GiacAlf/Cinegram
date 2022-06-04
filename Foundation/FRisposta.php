<?php

class FRisposta {

    private static string $nomeClasse = "FRisposta";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "risposta";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella1 = "UsernameAutore";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiaveTabella2 = "DataScrittura";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeAttributoTesto = "Testo";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeFK1Tabella = "IdFilmRecensito";   // da cambiare se cambia il nome della FK1 in DB
    private static string $nomeFK2Tabella = "UsernameAutoreRecensione"; // da cambiare se cambia il nome della FK2 in DB

    // metodo che verifica l'esistenza di una risposta in DB inserendo il valore della $chiaveTabella1 e $chiaveTabella2
    public static function exist(string $usernameAutore, DateTime $dataScrittura): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // recupero dati dal DB per creazione oggetto risposta passando come parametro la $chiaveTabella1 e $chiaveTabella2
    public static function load(string $usernameAutore, DateTime $dataScrittura): ?ERisposta {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto risposta sul DB
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nInserimento annullato!";
            }
        }
    }


    // aggiorna l'oggetto risposta nella tabella del DB
    public static function update(string $usernameAutore, DateTime $dataScrittura, string $nomeAttributo, $nuovoValore): void {

        if((FRisposta::exist($usernameAutore, $dataScrittura))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "'" .
                    " WHERE " . self::$chiaveTabella1 . " = '" . $usernameAutore . "'" .
                    " AND " . self::$chiaveTabella2 . " = '" . $dataScrittura->format("Y-m-d H:i:s") . "';";
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


    // cancella una risposta dal DB passando la $chiaveTabella1 e $chiaveTabella2
    public static function delete(string $usernameAutore, DateTime $dataScrittura): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FRisposta::exist($usernameAutore, $dataScrittura)) {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }
}