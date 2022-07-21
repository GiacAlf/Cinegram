<?php

class FFilm {

    private static int $maxSizeImmagineLocandina = 524288; // corrisponde ad mezzo Mebibyte, circa mezzo Megabyte (sui 16MiB di size massima consentita)

    // private static string $nomeClasse = "FFilm";  // ci potrebbe essere utile con il FPersistentManager
    private static string $nomeTabella = "film";  // da cambiare se cambia il nome della tabella Film in DB
    private static string $chiaveTabella = "IdFilm";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoTitolo = "Titolo";  // nome dell'attributo titolo nel DB
    private static string $nomeAttributoAnno = "Anno";  // nome dell'attributo data nel DB
    private static string $nomeAttributoDurata = "Durata";
    private static string $nomeAttributoSinossi = "Sinossi";
    private static string $nomeAttributoVotoMedio = "Voto";  // nome dell'attributo voto nel DB
    private static string $nomeAttributoLocandina = "Locandina";
    private static string $nomeAttributoTipoLocandina = "TipoLocandina";
    private static string $nomeAttributoSizeLocandina = "SizeLocandina";

    private static string $nomeTabellaRecensione = "recensione";    // da cambiare se cambia il nome della tabella Recensione in DB
    private static string $chiave1TabellaRecensione = "IdFilmRecensito";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoRecensioneUsernameAutore = "UsernameAutore";
    private static string $nomeAttributoRecensioneVoto = "Voto";
    private static string $nomeAttributoRecensioneTesto = "Testo";
    private static string $nomeAttributoRecensioneDataScrittura = "DataScrittura";  // nome dell'attributo Data Scrittura nel DB

    private static string $nomeTabellaRisposta = "risposta";
    private static string $nomeAttributoRispostaIdFilmRecensito = "IdFilmRecensito";

    private static string $nomeTabellaFilmVisti = "filmvisti";  // da cambiare se cambia il nome della tabella in DB
    private static string $chiave1TabellaFilmVisti = "idFilmVisto";   // da cambiare se cambia il nome della chiave in DB

    private static string $nomeTabellaRegisti = "persona";   // da cambiare se cambia il nome della tabella in DB
    private static string $nomeTabellaAttori = "persona";
    private static string $nomeChiaveTabellaRegisti = "IdPersona";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeChiaveTabellaAttori = "IdPersona";   // da cambiare se cambia il nome della chiave in DB
    private static string $nomeAttributoPersonaCognome = "Cognome";    // nome dell'attributo Cognome nel DB
    private static string $nomeAttributoPersonaNome = "Nome";    // nome dell'attributo Cognome nel DB
    private static string $nomeAttributoPersonaRuolo = "Ruolo";    // nome dell'attributo Cognome nel DB
    private static string $valoreAttributoPersonaAttore = "Attore";    // nome dell'attributo Cognome nel DB
    private static string $valoreAttributoPersonaRegista = "Regista";    // nome dell'attributo Cognome nel DB

    private static string $nomeTabellaPersoneFilm = "personefilm"; // da cambiare se cambia il nome della tabella in DB
    private static string $nomeChiave1TabellaPersoneFilm = "IdFilm";    // da cambiare se cambia il nome della chiave in DB
    private static string $nomeChiave2TabellaPersoneFilm = "IdPersona"; // da cambiare se cambia il nome della chiave in DB


    /**
     * Metodo che verifica l'esistenza di un film nel DB
     * @param int $idFilm
     * @return bool|null
     */
    public static function existById(int $idFilm): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $idFilm . "';";
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
     * Metodo che verifica l'esistenza di un film nel DB
     * @param string $titolo
     * @return bool|null
     */
    public static function existByTitolo(string $titolo): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $titolo = addslashes($titolo);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoTitolo . " = '" . $titolo . "';";
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
     * Metodo che verifica l'esistenza di un film nel DB
     * @param string $titolo
     * @param int $anno
     * @return bool|null
     */
    public static function existByTitoloEAnno(string $titolo, int $anno): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $titolo = addslashes($titolo);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoTitolo . " = '" . $titolo . "'" .
                " AND YEAR( " . self::$nomeAttributoAnno . " ) = '" . $anno . "';";
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


    // settando i valori bool a true si farà il load anche degli array dei rispettivi attributi del film
    /**
     * Metodo che carica un film dal DB
     * @param int $id
     * @param bool $registi
     * @param bool $attori
     * @param bool $recensioni
     * @return EFilm|null
     * @throws Exception
     */
    public static function loadById(int $id, bool $registi, bool $attori, bool $recensioni): ?EFilm {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $id . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResultFilm = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            // caricamento del numero delle views
            $queryResultViews = FFilm::loadNumeroViews($id);

            // caricamento del voto medio
            $queryResultVoto = FFilm::loadVotoMedio($id);

            // caricamento lista registi se $registi è settato a true
            $queryResultRegisti = array();
            if($registi) $queryResultRegisti = FFilm::loadListaRegisti($id);

            // caricamento lista attori se $attori è settato a true
            $queryResultAttori = array();
            if($attori) $queryResultAttori = FFilm::loadListaAttori($id);

            // caricamento lista recensioni se $recensioni è settato a true
            $queryResultRecensioni = array();
            if($recensioni) $queryResultRecensioni = FFilm::loadListaRecensioniFilm($id);

            if($queryResultFilm) {
                return new EFilm($queryResultFilm[self::$chiaveTabella], $queryResultFilm[self::$nomeAttributoTitolo],
                    new DateTime($queryResultFilm[self::$nomeAttributoAnno]), $queryResultFilm[self::$nomeAttributoDurata],
                    $queryResultFilm[self::$nomeAttributoSinossi], $queryResultViews, $queryResultVoto,
                    $queryResultRegisti, $queryResultAttori, $queryResultRecensioni);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica un film dal DB
     * @param string $titolo
     * @return array|null
     * @throws Exception
     */
    public static function loadByTitolo(string $titolo): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $titolo = addslashes($titolo);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoTitolo . " = '" . $titolo . "'" .
                " ORDER BY " . self::$nomeAttributoAnno . " ASC" . ";";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di EFilm
            $filmByTitoloResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $filmByTitoloResult[] = new EFilm($row[self::$chiaveTabella], $row[self::$nomeAttributoTitolo],
                        new DateTime($row[self::$nomeAttributoAnno]), $row[self::$nomeAttributoDurata],
                        $row[self::$nomeAttributoSinossi], null, null, null,
                        null, null);
                }
            }
            return $filmByTitoloResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica un film dal DB
     * @param string $titolo
     * @param int $anno
     * @return array|null
     * @throws Exception
     */
    public static function loadByTitoloEAnno(string $titolo, int $anno): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $titolo = addslashes($titolo);
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$nomeAttributoTitolo . " = '" . $titolo . "'" .
                " AND YEAR( " . self::$nomeAttributoAnno . " ) = '" . $anno . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di EFilm
            $filmByTitoloResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $filmByTitoloResult[] = new EFilm($row[self::$chiaveTabella], $row[self::$nomeAttributoTitolo],
                        new DateTime($row[self::$nomeAttributoAnno]), $row[self::$nomeAttributoDurata],
                        $row[self::$nomeAttributoSinossi], null, null, null,
                        null, null);
                }
            }
            return $filmByTitoloResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica il numero di views del film
     * @param int $id
     * @return int|null
     */
    public static function loadNumeroViews(int $id): ?int {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT COUNT(*) AS NumeroViews FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaFilmVisti .
                " ON " . self::$chiaveTabella . " = " . self::$chiave1TabellaFilmVisti .
                " WHERE " . self::$chiave1TabellaFilmVisti . " = '" . $id . "'";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroViews"]; // questo sarà un solo valore intero, anche zero
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica il voto medio del film
     * @param int $id
     * @return float|null
     */
    public static function loadVotoMedio(int $id): ?float {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT AVG(" . self::$nomeAttributoVotoMedio . ") AS VotoMedio" .
                " FROM " . self::$nomeTabella .
                " JOIN " . self::$nomeTabellaRecensione .
                " ON " . self::$chiaveTabella . " = " . self::$chiave1TabellaRecensione . "" .
                " WHERE " . self::$chiave1TabellaRecensione . " = '" . $id . "'";

            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["VotoMedio"];
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica la lista dei registi del film
     * @param int $id
     * @return array|null
     */
    public static function loadListaRegisti(int $id): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "pe." . self::$nomeChiaveTabellaRegisti . ", pe." . self::$nomeAttributoPersonaNome .
                ", pe." . self::$nomeAttributoPersonaCognome .
                " FROM " . self::$nomeTabellaRegisti . " pe " .
                " JOIN " . self::$nomeTabellaPersoneFilm . " pef " .
                " ON " . "pe." . self::$nomeChiaveTabellaRegisti . " = " . "pef." . self::$nomeChiave2TabellaPersoneFilm .
                " JOIN " . self::$nomeTabella . " f " .
                " ON " . "pef." . self::$nomeChiave1TabellaPersoneFilm . " = " . "f." . self::$chiaveTabella .
                " WHERE " . " pef." . self::$chiaveTabella . " = '" . $id . "'" .
                " AND " . self::$nomeAttributoPersonaRuolo . " = '" . self::$valoreAttributoPersonaRegista . "'" .
                " ORDER BY " . "pe." . self::$nomeAttributoPersonaCognome . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di ERegisti
            $registiResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $registiResult[] = new ERegista($row[self::$nomeChiaveTabellaRegisti],
                        $row[self::$nomeAttributoPersonaNome], $row[self::$nomeAttributoPersonaCognome]);
                }
            }
            return $registiResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica la lista dei registi del film
     * @param int $id
     * @return array|null
     */
    public static function loadListaAttori(int $id): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT " . "pe." . self::$nomeChiaveTabellaAttori . ", pe." . self::$nomeAttributoPersonaNome .
                ", pe." . self::$nomeAttributoPersonaCognome .
                " FROM " . self::$nomeTabellaAttori . " pe " .
                " JOIN " . self::$nomeTabellaPersoneFilm . " pef " .
                " ON " . "pe." . self::$nomeChiaveTabellaAttori . " = " . "pef." . self::$nomeChiave2TabellaPersoneFilm .
                " JOIN " . self::$nomeTabella . " f " .
                " ON " . "pef." . self::$nomeChiave1TabellaPersoneFilm . " = " . "f." . self::$chiaveTabella .
                " WHERE " . " pef." . self::$chiaveTabella . " = '" . $id . "'" .
                " AND " . self::$nomeAttributoPersonaRuolo . " = '" . self::$valoreAttributoPersonaAttore . "'" .
                " ORDER BY " . "pe." . self::$nomeAttributoPersonaCognome . " ASC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di EAttori
            $attoriResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $attoriResult[] = new EAttore($row[self::$nomeChiaveTabellaAttori],
                        $row[self::$nomeAttributoPersonaNome], $row[self::$nomeAttributoPersonaCognome]);
                }
            }
            return $attoriResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che carica la lista delle recensioni del film
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function loadListaRecensioniFilm(int $id): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabellaRecensione .
                " JOIN " . self::$nomeTabella .
                " ON " . self::$chiave1TabellaRecensione . " = " . self::$chiaveTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $id . "'" .
                " ORDER BY " . self::$nomeAttributoRecensioneDataScrittura . " DESC;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();

            // array di ERecensioni
            $recensioniResult = array();
            if($queryResult) {
                foreach($queryResult as $row) {
                    $recensioniResult[] = new ERecensione($row[self::$chiave1TabellaRecensione],
                        $row[self::$nomeAttributoRecensioneUsernameAutore], $row[self::$nomeAttributoRecensioneVoto],
                        $row[self::$nomeAttributoRecensioneTesto], new DateTime($row[self::$nomeAttributoRecensioneDataScrittura]),
                        null);
                }
            }
            return $recensioniResult;
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     *  Metodo che restituisce il numero delle recensioni del film
     * @param int $id
     * @return int|null
     */
    public static function calcolaNumeroRecensioniFilm(int $id): ?int {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT COUNT(*) AS NumeroRecensioni
                 FROM " . self::$nomeTabellaRecensione .
                " JOIN " . self::$nomeTabella .
                " ON " . self::$chiave1TabellaRecensione . " = " . self::$chiaveTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $id . "'" . " ;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            return $queryResult["NumeroRecensioni"];
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    /**
     * Metodo che salva il film sul DB
     * @param EFilm $film
     * @param array|null $listaAttori
     * @param array|null $listaRegisti
     * @param string|null $locandinaPath
     * @param string|null $tipoLocandina
     * @param string|null $sizeLocandina
     * @return void
     */
    public static function store(EFilm $film, ?array $listaAttori, ?array $listaRegisti,
                                 ?string $locandinaPath, ?string $tipoLocandina, ?string $sizeLocandina): void {

        if(!(FFilm::existByTitoloEAnno($film->getTitolo(), $film->getAnno()->format('Y')))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                if($sizeLocandina > self::$maxSizeImmagineLocandina) {
                    print("Il file caricato è troppo grande!");
                    return;
                }

                if($locandinaPath != null) {
                    // ricavo l'array con le info dell'immagine
                    $arrayGetImageSize = getimagesize($locandinaPath);

                    // si accettano solo jpeg e png
                    if($arrayGetImageSize['mime'] == !"image/jpeg" || $arrayGetImageSize['mime'] == "image/png")
                        return;

                    // si recupera il file da $_FILES['file']['tmp_name'] sottoforma di stringa
                    $locandina = file_get_contents($locandinaPath);
                }
                else {
                    $locandina = null;
                    $arrayGetImageSize['mime'] = null;
                }

                $query =
                    "INSERT INTO " . self::$nomeTabella .
                    " VALUES (null, :Titolo, :Anno, :Durata, :Sinossi, :Locandina, :TipoLocandina, :SizeLocandina);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(
                    ":Titolo" => $film->getTitolo(),
                    ":Anno" => $film->getAnno()->format('Y-m-d'),
                    ":Durata" => $film->getDurata(),
                    ":Sinossi" => $film->getSinossi(),
                    ":Locandina" => $locandina,
                    ":TipoLocandina" => $arrayGetImageSize['mime'],
                    ":SizeLocandina" => $sizeLocandina));

                // TODO provare a mettere il commit qui e lasciare le store dove sono--> già provato!
                // ogni attore della lista, se non vuota, verrà salvato in persona e in personefilm
                //if($listaAttori) FFilm::storeAttori($film, $listaAttori);

                // ogni regista della lista, se non vuota, verrà salvato in persona e in personefilm
                //if($listaRegisti) FFilm::storeRegisti($film, $listaRegisti);

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
     * Metodo che salva gli attori del film nel DB
     * @param EFilm $film
     * @param array|null $listaAttori
     * @return void
     */
    private static function storeAttori(EFilm $film, ?array $listaAttori): void {

        foreach ($listaAttori as $attore) {
            FAttore::store($attore);
        }

        $listaAttoriId = array();
        foreach($listaAttori as $attore) {
            //creo questo array perché se faccio subito lo storePersoneFilm, gli passo degli oggetti
            //attore senza l'id, quindi, prima li salvo nel db e poi li recupero completi
            $listaAttoriId[] = FAttore::loadbyNomeECognome($attore->getNome(), $attore->getCognome());
        }
        foreach ($listaAttoriId as $attore) {
            FAttore::storePersoneFilm($attore, $film);
        }
    }


    /**
     * Metodo che salva i registi del film nel DB
     * @param EFilm $film
     * @param array|null $listaRegisti
     * @return void
     */
    private static function storeRegisti(EFilm $film, ?array $listaRegisti): void {

        foreach ($listaRegisti as $regista) {
            FRegista::store($regista);
        }

        $listaRegistiId = array();
        foreach ($listaRegisti as $regista) {
            $listaRegistiId[] = FRegista::loadByNomeECognome($regista->getNome(), $regista->getCognome());
        }

        foreach ($listaRegistiId as $regista) {
            FRegista::storePersoneFilm($regista, $film);
        }
    }


    /**
     * Metodo che aggiorna un attributo del film con un nuovo valore
     * @param EFilm $film
     * @param string $nomeAttributo
     * @param string $nuovoValore
     * @return void
     */
    public static function update(EFilm $film, string $nomeAttributo, string $nuovoValore): void {

        if((FFilm::existById($film->getId()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $nomeAttributo = addslashes($nomeAttributo);
                $nuovoValore = addslashes($nuovoValore);
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . $nomeAttributo . " = '" . $nuovoValore . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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
     * Metodo che aggiorna la data di uscita del film
     * @param EFilm $film
     * @param DateTime $nuovaData
     * @return void
     */
    public static function updateData(EFilm $film, DateTime $nuovaData): void {

        if((FFilm::existById($film->getId()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoAnno . " = '" . $nuovaData->format('Y-m-d') . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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
     * Metodo che aggiorna la lista degli attori del film
     * @param EFilm $film
     * @param array|null $listaAttori
     * @return void
     */
    public static function updateAttori(EFilm $film, ?array $listaAttori): void {

        if($listaAttori)
            FFilm::storeAttori($film, $listaAttori);
    }


    /**
     * Metodo che aggiorna la lista dei registi del film
     * @param EFilm $film
     * @param array|null $listaRegisti
     * @return void
     */
    public static function updateRegisti(EFilm $film, ?array $listaRegisti): void {

        if($listaRegisti)
            FFilm::storeRegisti($film, $listaRegisti);
    }


    // cancella un film dalle tabelle film, filmvisti, recensione e risposta
    /**
     * Metodo che elimina il film dal DB
     * @param EFilm $film
     * @return void
     */
    public static function delete(EFilm $film): void {

        if(FFilm::existById($film->getId())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                FFilm::deleteFromRecensione($film);
                FFilm::deleteFromRisposta($film);
                FFilm::deleteFromFilmVisti($film);
                FFilm::deleteFromPersoneFilm($film);
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nCancellazione annullata!";
            }
        }
    }


    /**
     * Metodo che elimina tutti gli attori e i registi legati al film
     * @param EFilm $film
     * @return void
     */
    public static function deleteFromPersoneFilm(EFilm $film): void {

        if (FFilm::existById($film->getId())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabellaPersoneFilm .
                    " WHERE " . self::$nomeChiave1TabellaPersoneFilm . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nCancellazione annullata!";
            }
        }
    }


    /**
     * Metodo che elimina tutte le recensioni del film
     * @param EFilm $film
     * @return void
     */
    private static function deleteFromRecensione(EFilm $film): void {

        if (FFilm::existById($film->getId())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabellaRecensione .
                    " WHERE " . self::$chiave1TabellaRecensione . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nCancellazione annullata!";
            }
        }
    }


    /**
     * Metodo che elimina tutte le risposte del film
     * @param EFilm $film
     * @return void
     */
    private static function deleteFromRisposta(EFilm $film): void {

        if (FFilm::existById($film->getId())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabellaRisposta .
                    " WHERE " . self::$nomeAttributoRispostaIdFilmRecensito . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nCancellazione annullata!";
            }
        }
    }


    /**
     * Metodo che elimina il film da quelli visti dagli utenti
     * @param EFilm $film
     * @return void
     */
    private static function deleteFromFilmVisti(EFilm $film): void {

        if(FFilm::existById($film->getId())) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabellaFilmVisti .
                    " WHERE " . self::$chiave1TabellaFilmVisti . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();
                echo "\nCancellazione annullata!";
            }
        }
    }


    /**
     * Metodo che verifica se esiste la locandina del film
     * @param EFilm $film
     * @return bool|null
     */
    public static function existLocandina(EFilm $film): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "'" .
                " AND " . self::$nomeAttributoLocandina . " IS NOT NULL;";
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


    // Metodo che restituisce un array con i dati della locandina in base64, il tipo e la sua size.
    // Settando il bool $grande a true si carica la corrispettiva locandina in formato grande, piccola se false
    /**
     * Metodo che carica la locandina del film
     * @param EFilm $film
     * @param bool $grande
     * @return array|null
     */
    public static function loadLocandina(EFilm $film, bool $grande): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $queryResultFilm = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();

            if($queryResultFilm) {
                // se $grande è settato a true si caricherà la locandina grande
                // $locandina sarà una stringa, presa dal db come blob, e ridimensionata
                if($grande) {
                    $locandina = EFilm::resizeLocandina($queryResultFilm[self::$nomeAttributoLocandina], true);
                    $size = "width='" . EFilm::$larghezzaGrande . "' " . "height='" . EFilm::$altezzaGrande ."'";
                }
                else {
                    $locandina = EFilm::resizeLocandina($queryResultFilm[self::$nomeAttributoLocandina], false);
                    $size = "width='" . EFilm::$larghezzaPiccola . "' " . "height='" . EFilm::$altezzaPiccola . "'";
                }

                // si procede all'encode come richiesto per il display della locandina
                $locandina = EFilm::base64Encode($locandina);

                return array($locandina, $queryResultFilm[self::$nomeAttributoTipoLocandina], $size);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();
        }
        return null;
    }


    // Restituisce un array con chiavi gli idFilm e valori array di locandine, tipo e size
    // se si setta il bool $grande a true si carica la corrispettiva locandina in formato grande, piccola se false
    /**
     * Metodo che carica le locandine di più film
     * @param array $arrayFilms
     * @param bool $grande
     * @return array|null
     */
    public static function loadLocandineFilms(array $arrayFilms, bool $grande): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        // questo array avrà come chiave l'idFilm e come valore un array di locandine, tipo e size
        $arrayIdFilmLocandine = array();

        foreach($arrayFilms as $film) {
            $arrayIdFilmLocandine[$film->getId()] = FFilm::loadLocandina($film, $grande);;
        }
        $pdo->commit();
        return $arrayIdFilmLocandine;
    }


    // quì il controllore, chiedendo alla view, fornisce a questo metodo il valore associato a
    // questo $_FILES['file']['tmp_name'], cioè la $nuovaLocandina appena caricata, con $_FILES['file']['type'] il
    // $nuovoTipoLocandina dell'immagine e con $_FILES['file']['size'] la sua $nuovaSizeLocandina
    /**
     * Metodo che aggiorna la locandina del film
     * @param EFilm $film
     * @param string $nuovaLocandinaPath
     * @param string $nuovoTipoLocandina
     * @param string $nuovaSizeLocandina
     * @return void
     */
    public static function updateLocandina(EFilm  $film, string $nuovaLocandinaPath, string $nuovoTipoLocandina,
                                           string $nuovaSizeLocandina): void {

        if($nuovaSizeLocandina > self::$maxSizeImmagineLocandina) {
            print("Il file caricato è troppo grande!");
            return;
        }
        if($nuovaLocandinaPath != null) {
            // ricavo l'array con le info dell'immagine
            $arrayGetImageSize = getimagesize($nuovaLocandinaPath);

            // si accettano solo jpeg e png
            if ($arrayGetImageSize['mime'] == !"image/jpeg" || $arrayGetImageSize['mime'] == "image/png") {
                print("Formato non valido!");
                return;
            }
            // si recupera il file da $_FILES['file']['tmp_name'] sottoforma di stringa
            $nuovaLocandinaStringa = file_get_contents($nuovaLocandinaPath);
            // eseguo l'escape
            $nuovaLocandinaStringa = addslashes($nuovaLocandinaStringa);
        }
        else{
            $nuovaLocandinaStringa = null;
            $arrayGetImageSize['mime'] = null;
        }

        if((FFilm::existById($film->getId()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoLocandina . " = '" . $nuovaLocandinaStringa . "', " .
                    self::$nomeAttributoTipoLocandina . " = '" . $arrayGetImageSize['mime'] . "', " .
                    self::$nomeAttributoSizeLocandina . " = '" . $nuovaSizeLocandina . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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


    // si fa un update a null
    /**
     * Metodo che cancella la locandina del film
     * @param EFilm $film
     * @return void
     */
    public static function deleteLocandina(EFilm $film): void {

        if((FFilm::existById($film->getId()))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoLocandina . " = null, " .
                    self::$nomeAttributoTipoLocandina . " = null, "  .
                    self::$nomeAttributoSizeLocandina . " = null " .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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
}