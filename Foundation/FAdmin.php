<?php

class FAdmin {

    private static string $nomeClasse = "FAdmin"; // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "admin";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabella = "Username"; // da cambiare se cambia il nome della chiave in DB

    private static string $nomeTabellaUser = "user";   // da cambiare se cambia il nome della tabella in DB
    private static string $chiaveTabellaUser = "Username"; // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoUserPassword = "Password";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $nomeAttributoUserRuolo = "Ruolo";   // da cambiare se cambia il nome dell'attributo in DB
    private static string $valoreAttributoUserRuolo = "Admin";   // da cambiare se cambia il nome del valore in DB

    // si userà l'exist di User per verificare l'esistenza di un member

    // recupero dati dal DB per creazione oggetto admin passando come parametro la chiave username, da fare dopo
    // autenticazione con FUser::userRegistrato e FUser::tipoUserRegistrato
    // questo metodo ha senso se si inseriranno in futuro altri attributi tipici di EAdmin, altrimenti si può
    // costruire subito un EAdmin con lo username passato e bypassare del tutto questo metodo
    public static function load(string $username): ?EAdmin {

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

            if($queryResult) {
                return new EAdmin($queryResult[self::$chiaveTabella]);
            }
        }
        catch(PDOException $e) {
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto admin sul DB
    public static function store(EAdmin $admin, string $password): void {

        // si controlla se l'admin non sia già presente in DB prima di procedere
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
                    ":Password" => $password,
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nInserimento annullato!";
            }
        }
    }


    // aggiorna l'admin nel DB, per ora la sola cosa che si può aggiornare è la password visto che il resto è il ruolo
    // e lo username, che non è modificabile
    public static function updatePassword(EAdmin $admin, string $nuovaPassword): void {

        if(FUser::exist($admin->getUsername())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabellaUser .
                    " SET " . self::$nomeAttributoUserPassword . " = '" . $nuovaPassword . "'" .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $admin->getUsername() . "';";
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


    // cancella un Admin dalla tabella Admin del DB, da usare insieme a FUser::delete, oppure usare anche il codice
    // commentato
    public static function delete(string $username): void {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            if(FUser::exist($username)) {
                // cancellazione dalla tabella User
                $query =
                    "DELETE FROM " . self::$nomeTabellaUser .
                    " WHERE " . self::$chiaveTabellaUser . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();

                /* cancellazione dalla tabella Admin, serve se non ci fossero le FK
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella . " = '" . $username . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
                */
            }
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            echo "\nCancellazione annullata!";
        }
    }
}