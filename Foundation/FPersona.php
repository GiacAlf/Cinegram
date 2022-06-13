<?php

class FPersona {

    private static string $nomeClasse = "FPersona";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "persona";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "idPersona";   // da cambiare se cambia il nome della chiave in DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave1 in DB
    private static string $chiave2TabellaPersoneFilm = "IdFilm"; // da cambiare se cambia il nome della chiave2 in DB


    // metodo che verifica l'esistenza di una persona in db inserendo il valore della chiave idPersona
    public static function exist(int $idPersona): ?bool {

        // connessione al DB con oggetto $pdo
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che verifica l'esistenza di una persona nella tabella personefilm associato a un particolare idFilm
    // poichè possono esserci diverse associazioni tra la stessa persona e diversi film
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }



    // metodo che restituisce un array di film in cui l'attore o il regista hanno partecipato
    public static function loadFilmByNomeECognome(string $nome, string $cognome): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            // si assume come al solito che non ci siano omonimi tra gli attori o tra i registi
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }



    // cancella una persona dalla tabella persona del DB
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }


    // cancella una persona dalla tabella personafilm del DB
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }
}