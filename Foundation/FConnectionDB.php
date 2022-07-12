<?php

class FConnectionDB {

    public static function connect(): ?object {

        try {
            return new PDO("mysql:host=" . $GLOBALS["hostname"] . ";dbname=" . $GLOBALS["database"],
                $GLOBALS["username"], $GLOBALS["password"]);
        }
        catch(PDOException $e) {
            echo "\nAttenzione errore: " . $e->getMessage();
            return null;
        }
    }
}