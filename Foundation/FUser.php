<?php

class FUser {

    private static string $nomeClasse = "FUser";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "user";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoPassword = "Password";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRuolo = "Ruolo";   // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaBan = "ban";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabellaBan = "UtenteBannato";   // da cambiare se cambia il nome della chiave in DB

    // Questa classe avrà solo exist e delete, gli altri saranno demandati a FAdmin e FMember
    // la load, lo store e l'update verranno fatti dal FMember e FAdmin
    // metodo che verifica l'esistenza di uno User in db inserendo il valore della chiave Username
    public static function exist(string $username): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
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


    // metodo che verifica l'esistenza di uno User registrato in db inserendo il valore della chiave Username
    // e l'attributo password
    public static function userRegistrato(string $username, string $password): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "'" .
                " AND BINARY " . self::$nomeAttributoPassword . " = '" . $password . "';";
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


    // metodo che restituisce il ruolo dello user inserendo il valore della chiave Username e l'attributo password
    public static function tipoUserRegistrato(string $username, string $password): ?string {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . self::$nomeAttributoRuolo .
                " FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "'" .
                " AND BINARY " . self::$nomeAttributoPassword . " = '" . $password . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult) {
                return $queryResult[self::$nomeAttributoRuolo];
            }
            return false;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // verifica se uno User (Member o Admin) è stato bannato
    public static function userBannato(string $username): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaBan .
                " WHERE " . self::$chiaveTabellaBan . " = '" . $username . "';";
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


    // mette lo user nella tabella Ban del DB
    public static function bannaUser(string $username): void {

        if(FUser::exist($username)) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                // salvataggio nella tabella Member
                $query =
                    "INSERT INTO " . self::$nomeTabellaBan .
                    " VALUES (:Username);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $username));
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


    // toglie uno User (Member o Admin) dalla tabella Ban del DB
    public static function sbannaUser(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::userBannato($username)) {
                $query =
                    "DELETE FROM " . self::$nomeTabellaBan .
                    " WHERE " . self::$chiaveTabellaBan . " = '" . $username . "';";
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


    // cancella uno User dal DB, per cancellare un member o un admin usare la loro delete
    public static function delete(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($username)) {
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
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