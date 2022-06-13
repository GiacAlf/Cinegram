<?php

// if(file_exists("configDB.php")) require_once "configDB.php";

class FConnectionDB {

    public static function connect(): ?object {

        try {
            return new PDO("mysql:host=" . $GLOBALS["hostname"] . ";dbname=" . $GLOBALS["database"],
                $GLOBALS["username"], $GLOBALS["password"]);
        }
        catch(PDOException $e) {
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
            return null;
        }
    }
}