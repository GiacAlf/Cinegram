<?php

class FStatisticheFilm {

    // private static string $nomeClasse = "FStatisticheFilm";
    private static string $nomeTabellaFilm = "film";
    private static string $nomeTabellaRecensioni = "recensione";
    private static string $nomeAttributoIdFilmRecensito = "IdFilmRecensito";
    private static string $nomeAttributoTitolo = "Titolo";
    private static string $nomeAttributoDurata = "Durata";
    private static string $nomeAttributoVoto = "Voto";
    private static string $nomeAttributoAnno = "Anno";
    private static string $nomeAttributoSinossi = "Sinossi";
    private static string $nomeTabellaFilmVisti = "filmvisti";
    private static string $nomeAttributoIdFilmFilmVisti = "IdFilmVisto";
    private static string $nomeAttributoIdFilm = "IdFilm";


    /**
     * Metodo che restituisce i film più visti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmPiuVisti(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try{
            $query =
                "WITH NumeroViste AS (SELECT " . self::$nomeAttributoIdFilmFilmVisti . "," .
                " COUNT(*) AS NumVis FROM " . self::$nomeTabellaFilmVisti .
                " GROUP BY " . self::$nomeAttributoIdFilmFilmVisti . ")" .
                " SELECT " . self::$nomeAttributoTitolo . ", NumVis, ".self::$nomeAttributoAnno . "," .
                self::$nomeAttributoDurata . "," . self::$nomeAttributoSinossi . "," . self::$nomeAttributoIdFilm .
                " FROM NumeroViste nv JOIN " . self::$nomeTabellaFilm . " f ON " . self::$nomeAttributoIdFilmFilmVisti .
                " = " . self::$nomeAttributoIdFilm .
                " ORDER BY NumVis DESC LIMIT " . $numeroDiEstrazioni . ";";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risultatoFilm = array();

            foreach ($queryResult as $ris) {
                $filmResult = new EFilm($ris[self::$nomeAttributoIdFilm], $ris[self::$nomeAttributoTitolo],
                    new DateTime($ris[self::$nomeAttributoAnno]), $ris[self::$nomeAttributoDurata], $ris[self::$nomeAttributoSinossi],
                    $ris["NumVis"], null, null, null, null);

                $avg = FFilm::loadVotoMedio($filmResult->getId());
                $filmResult->setVotoMedio($avg);
                $risultatoFilm[] = $filmResult;
            }
            return $risultatoFilm;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che restituisce i film più recensiti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmPiuRecensiti(int $numeroDiEstrazioni): ?array {

        $pdo=FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH NumeroRecensioni AS ( SELECT " . self::$nomeAttributoIdFilmRecensito . "," .
                " COUNT(*) AS NumRece FROM " . self::$nomeTabellaRecensioni .
                " GROUP BY " . self::$nomeAttributoIdFilmRecensito . " ) 
                   SELECT NumRece, " . self::$nomeAttributoIdFilm . ", "
                . self::$nomeAttributoTitolo. " , ". self::$nomeAttributoAnno. " , " . self::$nomeAttributoDurata . ", "
                . self::$nomeAttributoSinossi.
                " FROM NumeroRecensioni JOIN " . self::$nomeTabellaFilm
                ." ON " . self::$nomeAttributoIdFilmRecensito . " = " . self::$nomeAttributoIdFilm .
                " ORDER BY NumRece DESC LIMIT " . $numeroDiEstrazioni;
            $stmt=$pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risultatoFilm = array();

            foreach ($queryResult as $ris) {
                    $filmResult = new EFilm($ris[self::$nomeAttributoIdFilm], $ris[self::$nomeAttributoTitolo],
                        new DateTime($ris[self::$nomeAttributoAnno]), $ris[self::$nomeAttributoDurata], $ris[self::$nomeAttributoSinossi],
                        0, null, null, null, null);

                    $views = FFilm::loadNumeroViews($filmResult->getId());
                    $votoMedio = FFilm::loadVotoMedio($filmResult->getId());

                    $filmResult->setNumeroViews($views);
                    $filmResult->setVotoMedio($votoMedio);
                    $risultatoFilm[] = $filmResult;
            }
            return $risultatoFilm;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che restituisce i film con voto medio più alto
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmConVotoMedioPiuAlto(int $numeroDiEstrazioni): ?array {
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "WITH MediaVoti AS (SELECT " . self::$nomeAttributoIdFilmRecensito . " , " .
                "AVG( " . self::$nomeAttributoVoto . ") " . "AS VotoMedio 
                FROM " . self::$nomeTabellaRecensioni .
                " GROUP BY " . self::$nomeAttributoIdFilmRecensito . ") " .
                "SELECT " . self::$nomeAttributoTitolo .
                ", VotoMedio, " . self::$nomeAttributoIdFilm . ", " .
                self::$nomeAttributoAnno . " , " . self::$nomeAttributoDurata . ", " . self::$nomeAttributoSinossi .
                " FROM " . self::$nomeTabellaFilm . " JOIN MediaVoti" .
                " ON " . self::$nomeAttributoIdFilmRecensito . " = " .
                self::$nomeAttributoIdFilm .
                " ORDER BY VotoMedio DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risultatoFilm = array();

            foreach ($queryResult as $ris) {
                $filmResult = new EFilm($ris[self::$nomeAttributoIdFilm], $ris[self::$nomeAttributoTitolo],
                    new DateTime($ris[self::$nomeAttributoAnno]), $ris[self::$nomeAttributoDurata], $ris[self::$nomeAttributoSinossi],
                    0, $ris["VotoMedio"], null, null, null);

                $views = FFilm::loadNumeroViews($filmResult->getId());
                $filmResult->setNumeroViews($views);
                $risultatoFilm[] = $filmResult;
            }
            return $risultatoFilm;
        }
        catch (PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che restituisce i film recenti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmRecenti(int $numeroDiEstrazioni): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . self::$nomeAttributoTitolo . "," . self::$nomeAttributoAnno . "," .
                self::$nomeAttributoIdFilm . "," . self::$nomeAttributoDurata . "," . self::$nomeAttributoSinossi .
                " FROM " . self::$nomeTabellaFilm .
                " ORDER BY " . self::$nomeAttributoAnno .
                " DESC LIMIT " . $numeroDiEstrazioni;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $risultatoFilm = array();

            foreach ($queryResult as $ris) {
                $filmResult = new EFilm($ris[self::$nomeAttributoIdFilm], $ris[self::$nomeAttributoTitolo],
                    new DateTime($ris[self::$nomeAttributoAnno]), $ris[self::$nomeAttributoDurata], $ris[self::$nomeAttributoSinossi],
                    0, 0, null, null, null);

                $views = FFilm::loadNumeroViews($filmResult->getId());
                $avg = FFilm::loadVotoMedio($filmResult->getId());
                $filmResult->setNumeroViews($views);
                $filmResult->setVotoMedio($avg);
                $risultatoFilm[] = $filmResult;
            }
            return $risultatoFilm;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }
}