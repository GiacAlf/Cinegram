<?php

class FAttore {

    // private static string $nomeClasse = "FAttore"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "persona"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "IdPersona"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoNome = "Nome";  // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoCognome = "Cognome";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRuolo = "Ruolo";    // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoRuolo = "Attore";    // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    // private static string $chiave1TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave1 in DB
    // private static string $chiave2TabellaPersoneFilm = "IdFilm"; // da cambiare se cambia il nome della chiave2 in DB


    // existById e delete si faranno con quelli di FPersona
    /**
     * Metodo che verifica l'esistenza di un attore nel DB
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
     * Metodo che carica un attore dal DB
     * @param int $idPersona
     * @return EAttore|null
     */
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

            if($queryResult)
                return new EAttore($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica un attore dal DB
     * @param string $nome
     * @param string $cognome
     * @return EAttore|null
     */
    public static function loadByNomeECognome(string $nome, string $cognome): ?EAttore {

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
                return new EAttore($queryResult[self::$chiaveTabella], $queryResult[self::$nomeAttributoNome],
                    $queryResult[self::$nomeAttributoCognome]);
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // se l'attore che si sta salvando è associato a un film, usare anche storePersoneFilm
    /**
     * Metodo che salva un attore nel DB
     * @param EAttore $attore
     * @return void
     */
    public static function store(EAttore $attore): void {

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
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nInserimento annullato!";
            }
        }
    }


    /**
     * Metodo che salva un attore nel DB legandolo a un film in particolare
     * @param EAttore $attore
     * @param EFilm $film
     * @return void
     */
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nInserimento annullato!";
        }
    }


    /**
     * Metodo che aggiorna un attributo di un attore nel DB
     * @param EAttore $attore
     * @param string $nomeAttributo
     * @param string $nuovoValore
     * @return void
     */
    public static function update(EAttore $attore, string $nomeAttributo, string $nuovoValore): void {

        if(FAttore::exist($attore->getNome(), $attore->getCognome())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nomeAttributo = addslashes($nomeAttributo);
                $nuovoValore = addslashes($nuovoValore);
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
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nUpdate annullato!";
            }
        }
    }
}