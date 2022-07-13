<?php

class FUser {

    // private static string $nomeClasse = "FUser";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "user";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoPassword = "Password";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoRuolo = "Ruolo";   // da cambiare se cambia il nome dell'attributo in DB

    private static string $nomeTabellaBan = "ban";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabellaBan = "UtenteBannato";   // da cambiare se cambia il nome della chiave in DB


    // la load, lo store e l'update verranno fatti da FMember e FAdmin
    /**
     * Metodo che verifica l'esistenza di uno user nel DB
     * @param string $username
     * @return bool|null
     */
    public static function exist(string $username): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che verifica l'esistenza di uno user registrato nel DB
     * @param string $username
     * @param string $password
     * @return bool|null
     */
    public static function userRegistrato(string $username, string $password): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            // verificaPassword controlla se la password inserita corrisponde alla password hash recuperata da DB
            if($queryResult && EUser::verificaPassword($password, $queryResult[self::$nomeAttributoPassword]))
                return true;
            return false;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che restituisce il tipo dello user
     * @param string $username
     * @return string|null
     */
    public static function tipoUserRegistrato(string $username): ?string {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
            $query =
                "SELECT " . self::$nomeAttributoRuolo .
                " FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResult)
                return $queryResult[self::$nomeAttributoRuolo];

            return false;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che verifica se uno user è bannato
     * @param string $username
     * @return bool|null
     */
    public static function userBannato(string $username): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che banna uno user
     * @param string $username
     * @return void
     */
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
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nInserimento annullato!";
            }
        }
    }


    /**
     * Metodo che sbanna uno user
     * @param string $username
     * @return void
     */
    public static function sbannaUser(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::userBannato($username)) {
                $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }


    /**
     * Metodo che cancella uno user dal DB
     * @param string $username
     * @return void
     */
    public static function delete(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($username)) {
                $username = addslashes($username);
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
            echo "\nAttenzione errore: " . $e->getMessage();
            echo "\nCancellazione annullata!";
        }
    }
}