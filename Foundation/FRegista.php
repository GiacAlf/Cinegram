<?php

class FRegista {

    // private static string $nomeClasse = "FRegista"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "persona"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "IdPersona"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoNome = "Nome";  // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoCognome = "Cognome";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRuolo = "Ruolo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoRuolo = "Regista";    // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    // private static string $chiave1TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave1 in DB
    // private static string $chiave2TabellaPersoneFilm = "IdFilm"; // da cambiare se cambia il nome della chiave2 in DB


    // existById e delete saranno quelli di FPersona
    /**
     * Metodo che verifica la presenza del regista nel DB
     * @param string $nome
     * @param string $cognome
     * @return bool|null
     */
    public static function exist(string $nome, string $cognome): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $nome = addslashes($nome);
            $cognome = addslashes($cognome);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica il regista dal DB
     * @param int $idPersona
     * @return ERegista|null
     */
    public static function loadById(int $idPersona): ?ERegista {

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

            if($queryResult)
                return new ERegista($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica il regista dal DB
     * @param string $nome
     * @param string $cognome
     * @return ERegista|null
     */
    public static function loadByNomeECognome(string $nome, string $cognome): ?ERegista {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $nome = addslashes($nome);
            $cognome = addslashes($cognome);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoNome . " = '" . $nome . "'" .
                " AND " . self::$nomeAttributoCognome . " = '" . $cognome . "'" .
                " AND " . self::$nomeAttributoRuolo . " = '" . self::$valoreAttributoRuolo . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult)
                return new ERegista($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che salva il regista nel DB
     * @param ERegista $regista
     * @return void
     */
    public static function store(ERegista $regista): void {

        if(!(FRegista::exist($regista->getNome(), $regista->getCognome()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (null, :Nome, :Cognome, :Ruolo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Nome" => $regista->getNome(),
                    ":Cognome" => $regista->getCognome(),
                    ":Ruolo" => $regista->chiSei()));
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
     * Metodo che salva il regista nel DB legandolo a un film
     * @param ERegista $regista
     * @param EFilm $film
     * @return void
     */
    public static function storePersoneFilm(ERegista $regista, EFilm $film): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "INSERT INTO " . self::$nomeTabellaPersoneFilm .
                " VALUES (:IdPersona, :IdFilm);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                ":IdPersona" => $regista->getId(),
                ":IdFilm" => $film->getId()));
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
     * Metodo che aggiorna un attributo del regista con uno nuovo
     * @param ERegista $regista
     * @param string $nomeAttributo
     * @param string $nuovoValore
     * @return void
     */
    public static function update(ERegista $regista, string $nomeAttributo, string $nuovoValore): void {

        if(FRegista::exist($regista->getNome(), $regista->getCognome())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nomeAttributo = addslashes($nomeAttributo);
                $nuovoValore = addslashes($nuovoValore);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "'" .
                    " WHERE " . self::$nomeAttributoNome . " = '" . $regista->getNome() . "'" .
                    " AND " . self::$nomeAttributoCognome . " = '" . $regista->getCognome() . "'" .
                    " AND " . self::$nomeAttributoRuolo . " = '" . $regista->chiSei() . "';";
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