<?php

class FRecensione {

    private static string $nomeClasse = "FRecensione";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "recensione";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1Tabella = "IdFilmRecensito";   // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2Tabella = "UsernameAutore";   // da cambiare se cambia il nome della chiave2 in DB
    private static string $nomeAttributoVoto = "Voto";
    private static string $nomeAttributoTesto = "Testo";
    private static string $nomeAttributoDataScrittura = "DataScrittura";

    private static string $nomeTabellaRisposta = "risposta";  // da cambiare se cambia il nome della tabella Risposta in DB
    private static string $chiave1TabellaRisposta = "UsernameAutore";   // da cambiare se cambia il nome della chiave1 di Risposta in DB
    private static string $chiave2TabellaRisposta = "DataScrittura";   // da cambiare se cambia il nome della chiave2 di Risposta in DB
    private static string $nomeAttributoTestoRisposta = "Testo";    // da cambiare se cambia il nome dell'attributo di testo in Risposta in DB
    private static string $nomeFK1Tabella = "IdFilmRecensito";    // da cambiare se cambia il nome della FK1 di Risposta in DB
    private static string $nomeFK2Tabella = "UsernameAutoreRecensione";   // da cambiare se cambia il nome della FK2 di Risposta in DB

    // metodo che verifica l'esistenza di una recensione in DB inserendo il valore della $chiaveTabella1 e $chiaveTabella2
    public static function exist(int $idFilmRecensito, string $usernameAutore): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


// recupero dati dal DB per creazione oggetto recensione passando come parametro la $chiaveTabella1 e $chiaveTabella2
// settando il parametro $risposte a true si caricheranno anche tutte le risposte della recensione
    public static function load(int $idFilmRecensito, string $usernameAutore, bool $risposte): ?ERecensione {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "'" .
                " AND " . self::$chiave2Tabella . " = '" . $usernameAutore . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // se si è settato a true $risposte verranno caricate anche tutte le risposte e assegnate al costruttore
            $risposteResult = array();
            if($risposte) {
                $risposteResult = self::loadRisposte($idFilmRecensito, $usernameAutore);
            }
            // verificato sul DB, questo $queryResult è un array multidimensionale di un elemento in posto di chiave [0]
            if($queryResult) {
                return new ERecensione($queryResult[0][self::$chiave1Tabella], $queryResult[0][self::$chiave2Tabella],
                    $queryResult[0][self::$nomeAttributoVoto], $queryResult[0][self::$nomeAttributoTesto],
                    new DateTime( $queryResult[0][self::$nomeAttributoDataScrittura]), $risposteResult);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // ritorna un array di tutte le risposte di una recensione passando le sue chiavi per parametro
    // TODO considerare un numero limite di risposte da caricare, da passare per parametro (le prime $n)
    public static function loadRisposte(int $idFilmRecensito, string $usernameAutoreRecensione): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
                " ORDER BY " . self::$chiave2TabellaRisposta . " DESC;";
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto recensione sul DB
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nInserimento annullato!";
            }
        }
    }


    // aggiorna l'oggetto recensione nella tabella del DB
    public static function update(int $idFilmRecensito, string $usernameAutore, string $nomeAttributo, $nuovoValore): void {

        if((FRecensione::exist($idFilmRecensito, $usernameAutore))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "'" .
                    " WHERE " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "'" .
                    " AND " . self::$chiave2Tabella . " = '" . $usernameAutore . "';";
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


    // cancella una recensione dal DB passando la $chiaveTabella1 e $chiaveTabella2
    public static function delete(int $idFilmRecensito, string $usernameAutore): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FRecensione::exist($idFilmRecensito, $usernameAutore)) {
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiave1Tabella . " = '" . $idFilmRecensito . "'" .
                    " AND " . self::$chiave2Tabella . " = '" . $usernameAutore . "';";
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