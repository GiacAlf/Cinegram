<?php

class FAdmin {

    // private static string $nomeClasse = "FAdmin"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "admin";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username"; // da cambiare se cambia il nome della chiave in DB

    private static string $nomeTabellaUser = "user";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabellaUser = "Username"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoUserPassword = "Password";   // da cambiare se cambia il nome dell'attributo in DB
    // private static string $nomeAttributoUserRuolo = "Ruolo";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoUserRuolo = "Admin";   // da cambiare se cambia il nome del valore in DB


    // si userà il metodo FUser::exist per verificare l'esistenza di un member
    /**
     * Metodo che carica un Admin nel DB
     * @param string $username
     * @return EAdmin|null
     */
    public static function load(string $username): ?EAdmin {

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

            if($queryResult)
                return new EAdmin($queryResult[self::$chiaveTabella]);
        }
        catch(PDOException $e) {
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che salva un Admin nel DB, con criptazione password
     * @param EAdmin $admin
     * @param string $password
     * @return void
     */
    public static function store(EAdmin $admin, string $password): void {

        if(!(FUser::exist($admin->getUsername()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                // salvataggio nella tabella User
                $query =
                    "INSERT INTO " . self::$nomeTabellaUser .
                    " VALUES (:Username, :Password, :Ruolo);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $admin->getUsername(),
                    ":Password" => EAdmin::criptaPassword($password),
                    ":Ruolo" => self::$valoreAttributoUserRuolo));

                // salvataggio nella tabella Admin
                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (:Username);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Username" => $admin->getUsername()));
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
     * Metodo che permette l'aggiornamento della password dell'Admin, la password sarà criptata
     * @param EAdmin $admin
     * @param string $nuovaPassword
     * @return void
     */
    public static function updatePassword(EAdmin $admin, string $nuovaPassword): void {

        if(FUser::exist($admin->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabellaUser .
                    " SET " . self::$nomeAttributoUserPassword . " = '" . EAdmin::criptaPassword($nuovaPassword) . "'" .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $admin->getUsername() . "';";
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
     * Metodo che cancella un Admin dal DB
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
                    "DELETE FROM " . self::$nomeTabellaUser .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $username . "';";
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