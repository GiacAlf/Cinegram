<?php

class FPersona {

    // private static string $nomeClasse = "FPersona";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "persona";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "idPersona";   // da cambiare se cambia il nome della chiave in DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaPersoneFilm = "IdFilm"; // da cambiare se cambia il nome della chiave2 in DB


    /**
     * Metodo che verifica l'esistenza della persona nel DB
     * @param int $idPersona
     * @return bool|null
     */
    public static function exist(int $idPersona): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $idPersona . "';";
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
     * Metodo che verifica l'esistenza della persona nel DB legata ad un film particolare
     * @param int $idPersona
     * @param int $idFilm
     * @return bool|null
     */
    public static function existPersoneFilm(int $idPersona, int $idFilm): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaPersoneFilm .
                " WHERE " . self::$chiave1TabellaPersoneFilm . " = '" . $idPersona . "'" .
                " AND " . self::$chiave2TabellaPersoneFilm . " = '" . $idFilm . "';";
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
     * Metodo che restituisce i film in cui la persona ha partecipato
     * @param string $nome
     * @param string $cognome
     * @return array|null
     * @throws Exception
     */
    public static function loadFilmByNomeECognome(string $nome, string $cognome): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            // si assume per semplicità che non ci siano omonimi tra gli attori o tra i registi
            // ma può esserci un attore che è anche un regista e che quindi hanno id diversi
            $attore = FAttore::loadByNomeECognome($nome, $cognome);
            $regista = FRegista::loadByNomeECognome($nome, $cognome);

            $query =
                "SELECT " . self::$chiave2TabellaPersoneFilm . " FROM " . self::$nomeTabellaPersoneFilm .
                " WHERE " . self::$chiave1TabellaPersoneFilm . " = '" . $attore->getId() . "'" .
                " OR " . self::$chiave1TabellaPersoneFilm . " = '" . $regista->getId() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            $arrayFilmResult = array();
            if($queryResult) {
                foreach ($queryResult as $arrrayIdFilm) {
                    $arrayFilmResult[] = FFilm::loadById($arrrayIdFilm[self::$chiave2TabellaPersoneFilm], false, false, false);
                }
                $arrayFilmResult = array_unique($arrayFilmResult, SORT_REGULAR);
            }
            return $arrayFilmResult;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che cancella una persona dal DB
     * @param int $idPersona
     * @return void
     */
    public static function delete(int $idPersona): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FPersona::exist($idPersona)) {
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella . " = '" . $idPersona . "';";
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
     * Metodo che cancella una persona, legata a un film, dal DB
     * @param int $idPersona
     * @param int $idFilm
     * @return void
     */
    public static function deletePersoneFilm(int $idPersona, int $idFilm): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FPersona::exist($idPersona)) {
                $query =
                    "DELETE FROM " . self::$nomeTabellaPersoneFilm .
                    " WHERE " . self::$chiave1TabellaPersoneFilm . " = '" . $idPersona . "'" .
                    " AND " . self::$chiave2TabellaPersoneFilm . " = '" . $idFilm . "';";
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
}