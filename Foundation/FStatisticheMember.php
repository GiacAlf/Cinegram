<?php

class FStatisticheMember {

    private static string $nomeClasse = "FStatisticheMember";
    private static string $nomeTabellaFilmVisti = "filmvisti";
    private static string $nomeAttributoUtenteCheHaVistoFilm = "UtenteCheHaVisto";
    private static string $nomeTabellaMember = "member";
    private static string $nomeTabellaRisposta = "risposta";
    private static string $nomeAttributoDataScrittura = "DataScrittura";
    private static string $nomeAttributoDataScritturaTabellaRisposta = "DataScrittura";
    private static string $nomeAttributoUsernameAutoreRecensioneTabellaRisposta = "UsernameAutoreRecensione";
    private static string $nomeAttributoUsername = "Username";
    private static string $nomeTabellaParteSocial = "partesocial";
    private static string $nomeAttributoUtenteSeguito = "UtenteSeguito";
    private static string $nomeAttributoUtenteFollower = "UtenteFollower";
    private static string $nomeAttributoBio = "Bio";
    private static string $nomeAttributoWarning = "Warning";
    private static string $nomeAttributoDataIscrizione = "DataIscrizione";
    private static string $nomeTabellaRecensione = "recensione";
    private static string $nomeAttributoUsernameAutore = "UsernameAutore";
    private static string $nomeAttributoUsernameAutoreTabellaRisposta = "UsernameAutore";
    private static string $nomeAttributoVoto = "Voto";
    private static string $nomeAttributoTesto = "Testo";
    private static string $nomeAttributoDataScritturaTabellaRecensione = "DataScrittura";
    private static string $nomeAttributoIdFilmRecensitoTabellaRecensione = "IdFilmRecensito";
    private static string $nomeAttributoIdFilmRecensitoTabellaRisposta = "IdFilmRecensito";


    public static function caricaUtentiConPiuFilmVisti(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroViste AS (SELECT " . self::$nomeAttributoUtenteCheHaVistoFilm . " , " .
                " COUNT(*) AS NumVis " .
                " FROM " . self::$nomeTabellaFilmVisti . " GROUP BY " . self::$nomeAttributoUtenteCheHaVistoFilm . " ) " .
                " SELECT " . self::$nomeAttributoUsername . " , " . self::$nomeAttributoBio . " , " . self::$nomeAttributoWarning .
                " , " . self::$nomeAttributoDataIscrizione . ",NumVis FROM NumeroViste " . " JOIN " . self::$nomeTabellaMember .
                " ON " . self::$nomeAttributoUtenteCheHaVistoFilm. " = " . self::$nomeAttributoUsername .
                " ORDER BY NumVis DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $members = array();

            foreach ($queryResult as $ris) {
                $member = new EMember($ris[self::$nomeAttributoUsername], new DateTime($ris[self::$nomeAttributoDataIscrizione]),
                $ris[self::$nomeAttributoBio], $ris[self::$nomeAttributoWarning],null,null,
                    null,null,);
                $members[] = $member;
            }
            return $members;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function caricaUtentiConPiuRecensioni(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroRecensioniScritte AS (SELECT " . self::$nomeAttributoUsernameAutore . " , " .
                " COUNT(*) AS NumRece " .
                " FROM " . self::$nomeTabellaRecensione . " GROUP BY " . self::$nomeAttributoUsernameAutore . " ) " .
                " SELECT " . self::$nomeAttributoUsername . " , " . self::$nomeAttributoBio . " , " . self::$nomeAttributoWarning .
                " , " . self::$nomeAttributoDataIscrizione . ",
                NumRece FROM NumeroRecensioniScritte " . " JOIN " . self::$nomeTabellaMember .
                " ON " . self::$nomeAttributoUsernameAutore . " = " . self::$nomeAttributoUsername .
                " ORDER BY NumRece DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $members = array();

            foreach ($queryResult as $ris) {
                $member = new EMember($ris[self::$nomeAttributoUsername], new DateTime($ris[self::$nomeAttributoDataIscrizione]),
                    $ris[self::$nomeAttributoBio], $ris[self::$nomeAttributoWarning],null,null,
                    null,null,);
                $members[] = $member;
            }
            return $members;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function caricaUtentiConPiuRisposteRecenti(int $numeroDiEstrazioni): ?array {

        $data = FStatisticheMember::convertiDataAttualeinDataPrecedente();
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroRisposteAvute AS ( SELECT " . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta .
                " , COUNT(*) AS NumRisp " .
                " FROM " . self::$nomeTabellaRisposta .
                " WHERE " . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta .
                " != " . self::$nomeAttributoUsernameAutoreTabellaRisposta .
                " AND " . self::$nomeAttributoDataScrittura . " > '" . $data->format('Y-m-d H:i:s').
                "' GROUP BY " . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta . " ) " .
                " SELECT " . self::$nomeAttributoUsername . " , " . self::$nomeAttributoBio . " , " . self::$nomeAttributoWarning .
                " , " . self::$nomeAttributoDataIscrizione. ", NumRisp FROM NumeroRisposteAvute " .
                " JOIN " . self::$nomeTabellaMember .
                " ON " . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta. " = " . self::$nomeAttributoUsername .
                " ORDER BY NumRisp DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $members = array();

            foreach ($queryResult as $ris) {
                $member = new EMember($ris[self::$nomeAttributoUsername], new DateTime($ris[self::$nomeAttributoDataIscrizione]),
                    $ris[self::$nomeAttributoBio], $ris[self::$nomeAttributoWarning],null,null,
                    null,null,);
                $members[] = $member;
            }
            return $members;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function caricaUtentiConPiuFollower(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroFollower AS ( SELECT " . self::$nomeAttributoUtenteSeguito . " , COUNT(*) AS NumFoll " .
                " FROM " . self::$nomeTabellaParteSocial . " GROUP BY " . self::$nomeAttributoUtenteSeguito." ) " .
                " SELECT " . self::$nomeAttributoUsername . " , " . self::$nomeAttributoBio . " , " . self::$nomeAttributoWarning .
                " , " . self::$nomeAttributoDataIscrizione . ",
                NumFoll FROM NumeroFollower " . " JOIN " . self::$nomeTabellaMember .
                " ON " . self::$nomeAttributoUtenteSeguito. " = " . self::$nomeAttributoUsername .
                " ORDER BY NumFoll DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $members = array();

            foreach ($queryResult as $ris) {
                $member = new EMember($ris[self::$nomeAttributoUsername], new DateTime($ris[self::$nomeAttributoDataIscrizione]),
                    $ris[self::$nomeAttributoBio], $ris[self::$nomeAttributoWarning],null,null,
                    null,null,);
                $members[] = $member;
            }
            return $members;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    public static function caricaUtentiConPiuFollowing(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroFollower AS ( SELECT " . self::$nomeAttributoUtenteFollower . " , COUNT(*) AS NumFoll " .
                " FROM " . self::$nomeTabellaParteSocial . " GROUP BY " . self::$nomeAttributoUtenteFollower." ) " .
                " SELECT " . self::$nomeAttributoUsername . " , " . self::$nomeAttributoBio . " , " . self::$nomeAttributoWarning .
                " , " . self::$nomeAttributoDataIscrizione . ",
                NumFoll FROM NumeroFollower " . " JOIN " . self::$nomeTabellaMember .
                " ON " . self::$nomeAttributoUtenteFollower. " = " . self::$nomeAttributoUsername .
                " ORDER BY NumFoll DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $members = array();

            foreach ($queryResult as $ris) {
                $member = new EMember($ris[self::$nomeAttributoUsername], new DateTime($ris[self::$nomeAttributoDataIscrizione]),
                    $ris[self::$nomeAttributoBio], $ris[self::$nomeAttributoWarning],null,null,
                    null,null,);
                $members[] = $member;
            }
            return $members;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // a partire dalla data attuale crea una data con giorno = 1 e il mese precedente all'attuale
    private static function convertiDataAttualeInDataPrecedente(): DateTime {

        $data = new Datetime();
        $s = $data->format('d-m-Y');
        $dateArray = explode("-",$s);
        if($dateArray[1] != 1) {
            $giorno = 1;
            $mese = $dateArray[1]-1;
            $anno = $dateArray[2];
        }
        else {
            $giorno = 1;
            $mese = 12;
            $anno = $dateArray[2]-1;
        }
        $finalDate = new Datetime();
        $finalDate->setDate($anno, $mese, $giorno);
        $finalDate->setTime(0,0,0);
        return ($finalDate);
    }


    public static function caricaUtentiPiuPopolari(int $numeroDiEstrazioni): ?array {

        $arrayFollower = FStatisticheMember::caricaUtentiConPiuFollower($numeroDiEstrazioni);
        $arrayRisposteRecenti = FStatisticheMember::caricaUtentiConPiuRisposteRecenti($numeroDiEstrazioni);
        // si definisce l'array utilizzato nel merge successivo a opera del for
        $arrayPopolari = array();
        // si uniscono i due array caricati da DB prendendo un elemento da uno e uno dall'altro partendo dall'indice
        // più basso e fino a esaurire tutti gli elementi
        for($i = 0; $i < $numeroDiEstrazioni; $i++) {
            $arrayPopolari[] = $arrayFollower[$i];
            $arrayPopolari[] = $arrayRisposteRecenti[$i];
        }
        $arrayPopolari = array_unique($arrayPopolari, SORT_REGULAR);
        // si prendono i primi $numeroDiEstrazioni elementi
        $arrayPopolari = array_slice($arrayPopolari, 0, $numeroDiEstrazioni, false);
        shuffle($arrayPopolari);
        return $arrayPopolari;
    }


    // carica un array delle ultime recensioni scritte sul forum
    public static function caricaUltimeRecensioniScritte(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . self::$nomeAttributoVoto . "," . self::$nomeAttributoTesto . "," .
                self::$nomeAttributoDataScritturaTabellaRecensione . "," .
                self::$nomeAttributoUsernameAutore . "," . self::$nomeAttributoIdFilmRecensitoTabellaRecensione .
                " FROM " . self::$nomeTabellaRecensione .
                " ORDER BY " . self::$nomeAttributoDataScritturaTabellaRecensione .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $recensioni = array();

            foreach ($queryResult as $res) {
                $recensione = new ERecensione($res[self::$nomeAttributoIdFilmRecensitoTabellaRecensione],
                    $res[self::$nomeAttributoUsernameAutore], $res[self::$nomeAttributoVoto], $res[self::$nomeAttributoTesto],
                    new DateTime($res[self::$nomeAttributoDataScritturaTabellaRecensione]),null);
                $recensioni[] = $recensione;
            }
            return $recensioni;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // carica un array delle ultime risposte scritte sul forum
    public static function caricaUltimeRisposteScritte(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT "."ri." . self::$nomeAttributoTesto . ",ri." . self::$nomeAttributoDataScritturaTabellaRisposta.
                ",ri." . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta.
                ",ri." . self::$nomeAttributoUsernameAutoreTabellaRisposta . ",ri." .
                self::$nomeAttributoIdFilmRecensitoTabellaRisposta .
                " FROM " . self::$nomeTabellaRisposta . " ri " .
                " JOIN " . self::$nomeTabellaRecensione . " re 
                ON ri." . self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta .
                " = " . "re." . self::$nomeAttributoUsernameAutore .
                " AND ri." . self::$nomeAttributoIdFilmRecensitoTabellaRisposta .
                " = " . "re." . self::$nomeAttributoIdFilmRecensitoTabellaRecensione .
                " ORDER BY " . "ri." . self::$nomeAttributoDataScritturaTabellaRisposta .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risposte = array();

            foreach ($queryResult as $ris) {
                 $risposta = new ERisposta($ris[self::$nomeAttributoUsernameAutoreTabellaRisposta],
                     new DateTime($ris[self::$nomeAttributoDataScritturaTabellaRisposta]), $ris[self::$nomeAttributoTesto],
                     $ris[self::$nomeAttributoIdFilmRecensitoTabellaRisposta],
                     $ris[self::$nomeAttributoUsernameAutoreRecensioneTabellaRisposta]);
                 $risposte[] = $risposta;
            }
        return $risposte;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // inserire come $numeroDiEstrazioni un numero pari!
    public static function caricaUltimeAttivita(int $numeroDiEstrazioni): ?array {

        $arrayRecensioni = FStatisticheMember::caricaUltimeRecensioniScritte($numeroDiEstrazioni/2);
        $arrayRisposte = FStatisticheMember::caricaUltimeRisposteScritte($numeroDiEstrazioni/2);
        $arrayUltimeAttivita = array_merge($arrayRecensioni, $arrayRisposte);
        // shuffle($arrayUltimeAttivita);
        return $arrayUltimeAttivita;
    }
}