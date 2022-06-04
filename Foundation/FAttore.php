<?php

class FAttore {

    private static string $nomeClasse = "FAttore"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "persona"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "IdPersona"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoNome = "Nome";  // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoCognome = "Cognome";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRuolo = "Ruolo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoRuolo = "Attore";    // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaPersoneFilm = "IdFilm"; // da cambiare se cambia il nome della chiave2 in DB


    // per l'exist per id e il delete si userà quello di FPersona
    // metodo che verifica l'esistenza di un attore in db inserendo il valore dei valori nome, cognome e ruolo
    public static function exist(string $nome, string $cognome): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoNome . " = '" . $nome . "'" .
                " AND " . self::$nomeAttributoCognome . " = '" . $cognome . "'" .
                " AND " . self::$nomeAttributoRuolo . " = '" . self::$valoreAttributoRuolo . "';";
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


    // recupero dati dal DB per creazione oggetto attore passando come parametro la chiave idPersona
    public static function loadById(int $idPersona): ?EAttore {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $idPersona . "'" .
                " AND " . self::$nomeAttributoRuolo . " = '" . self::$valoreAttributoRuolo . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult) {
                return new EAttore($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // recupero dati dal DB per creazione oggetto attore passando come parametro la chiave idPersona
    public static function loadByNomeECognome(string $nome, string $cognome): ?EAttore {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoNome . " = '" . $nome . "'" .
                " AND " . self::$nomeAttributoCognome . " = '" . $cognome . "'" .
                " AND " . self::$nomeAttributoRuolo . " = '" . self::$valoreAttributoRuolo . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult) {
                return new EAttore($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto attore nella tabella persone del DB, da usare insieme a storePersoneFilm
    public static function store(EAttore $attore): void {

        // si controlla se l'attore non sia già presente in DB prima di procedere
        if(!(FAttore::exist($attore->getNome(), $attore->getCognome()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (null, :Nome, :Cognome, :Ruolo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Nome" => $attore->getNome(),
                    ":Cognome" => $attore->getCognome(),
                    ":Ruolo" => $attore->chiSei()));
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


    // salva l'oggetto attore nella tabella PersoneFilm del DB, da usare insieme alla store
    public static function storePersoneFilm(EAttore $attore, EFilm $film): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "INSERT INTO " . self::$nomeTabellaPersoneFilm .
                " VALUES (:IdPersona, :IdFilm);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                ":IdPersona" => $attore->getId(),
                ":IdFilm" => $film->getId()));
            $pdo->commit();
            echo "\nInserimento avvenuto con successo!";
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nInserimento annullato!";
        }
    }


    // aggiorna l'oggetto attore nella tabella Persona del DB
    public static function update(EAttore $attore, string $nomeAttributo, string $nuovoValore): void {

        if(FAttore::exist($attore->getNome(), $attore->getCognome())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "'" .
                    " WHERE " . self::$nomeAttributoNome . " = '" . $attore->getNome() . "'" .
                    " AND " . self::$nomeAttributoCognome . " = '" . $attore->getCognome() . "'" .
                    " AND " . self::$nomeAttributoRuolo . " = '" . $attore->chiSei() . "';";
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