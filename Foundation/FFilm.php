<?php

class FFilm {

    private static int $maxSizeImmagineLocandina = 8192; // corrisponde ad 1 MByte (0 16MiB sul DB) di size massima consentita

    private static string $nomeClasse = "FFilm";  // ci potrebbe essere utile con il FPersistentManager
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



    // metodo che verifica l'esistenza di un film in db passando il EFilm, tramite il valore della chiave idFilm
    public static function existById(EFilm $film): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
            $query =
                "SELECT * FROM " . self::$nomeTabella .
                " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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


    // metodo che verifica l'esistenza di un film in db passando EFilm, attraverso il titolo del film
    public static function existByTitolo(string $titolo): ?bool {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che verifica l'esistenza di un film in db passando EFilm, attraverso il titolo e l'anno del film
    public static function existByTitoloEAnno(string $titolo, int $anno): ?bool {

        // connessione al DB con oggetto $pdo
        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // recupero dati dal DB per creazione oggetto film passando EFilm, attraverso la chiave idFilm
    // settando i valori booleani a true si caricheranno anche gli array che costituiscono i rispettivi attributi
    // di EFilm
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // recupero dati dal DB per creazione oggetto film passando il titolo come parametro
    // questa servirà solo per caricare una lista di film ordinati cronologicamente per anno da cui scegliere e poi
    // fare una loadById e caricarlo con tutti gli altri parametri
    public static function loadByTitolo(string $titolo): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // recupero dati dal DB per creazione oggetto film passando il titolo e l'anno come parametro
    // potrebbe non servire ma era praticamente gratis, ho lasciato aperta la possibilità che possa dare più di
    // un risultato da cui scegliere e poi fare una loadById e caricarlo con tutti gli altri parametri
    public static function loadByTitoloEAnno(string $titolo, int $anno): ?array {

        $pdo = FConnectionDB::connect();
        $pdo->beginTransaction();
        try {
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // caricamento del numero di views del film passato per parametro, usando il suo id
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }

    // caricamento del voto medio del film passato per parametro, usando il suo id
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

            return $queryResult["VotoMedio"]; // questo sarà un solo valore float, anche zero
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // carica tutti i registi associati al film passato per parametro, restituendoli in un array di ERegisti
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // carica tutti gli attori associati al film passato per parametro, restituendoli in un array di EAttori
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // carica tutte le recensioni associate al film passato per parametro, restituendole in un array di ERecensioni
    // le risposte di ciascuna recensione non verranno caricate in questo momento ma solo quando si selezionerà una di
    // esse cliccandoci sopra
    // TODO considerare un numero limite di recensioni da caricare, da passare per parametro (le prime $n)
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }

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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // salva l'oggetto film sul DB incluse le lise attori e registi, se non si vuole salvare la locandina per il
    // momento inserire null nei 3 parametri relativi a essa
    public static function store(EFilm $film, ?array $listaAttori, ?array $listaRegisti,
                                 ?string $locandina, ?string $tipoLocandina, ?string $sizeLocandina): void {

        // si controlla se il film non è presente in DB prima di procedere
        if(!(FFilm::existByTitoloEAnno($film->getTitolo(), $film->getAnno()->format('Y')))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
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
                    ":TipoLocandina" => $tipoLocandina,
                    ":SizeLocandina" => $sizeLocandina));

                // ogni attore della lista, se non vuota, verrà salvato in persona e in personefilm
                if($listaAttori) FFilm::storeAttori($film, $listaAttori);

                // ogni regista della lista, se non vuota, verrà salvato in persona e in personefilm
                if($listaRegisti) FFilm::storeRegisti($film, $listaRegisti);

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


    // metodo che salva gli attori nel DB legati ad un particolare film $film
    // l'array è settato anche con di null perchè ci fa comodo con il Persistent Manager, dove chiamiamo
    // i due metodi storeAttori e storeRegisti insieme
    private static function storeAttori(EFilm $film, ?array $listaAttori): void {

        foreach ($listaAttori as $attore) {
            FAttore::store($attore);
            FAttore::storePersoneFilm($attore, $film);
        }
    }


    // metodo che salva i registi nel DB legati ad un particolare film $film
    // l'array è settato anche con di null perchè ci fa comodo con il Persistent Manager, dove chiamiamo
    // i due metodi storeAttori e storeRegisti insieme
    private static function storeRegisti(EFilm $film, ?array $listaRegisti): void {

        foreach ($listaRegisti as $regista) {
            FRegista::store($regista);
            FRegista::storePersoneFilm($regista, $film);
        }
    }


    // questo update, per ora, salverà solo i seguenti attributi di EFilm nel DB: Titolo, Durata e Sinossi (la durata
    // anche se intera verrà convertita in stringa con la concatenazione)
    public static function update(EFilm $film, string $nomeAttributo, string $nuovoValore): void {

        if((FFilm::existById($film))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // questo update aggiorna solo la data di uscita del film, che sul DB si chiama Anno
    public static function updateData(EFilm $film, DateTime $nuovaData): void {

        if((FFilm::existById($film))) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }


    // L'update è intesto come sostituzione di un vecchio parametro con un nuovo ma in questo caso si tratta di più
    // parametri che vanno aggiornati, quindi, non potendo usare una singola istruzione di update, si procederà
    // con la cancellazione degli esistenti e l'inserimento dei nuovi
    public static function updateAttoriERegisti(EFilm $film, ?array $listaAttori, ?array $listaRegisti): void {

        // cancellando il film dalla tabella PersoneFilm si eliminano tutti gli attori e registi ad esso collegato, che
        // é proprio quello che vogliamo fare quì, e si considererà trascurabile l'aver inserito un attore o un regista
        // nella tabella persona che avrebbe dovuto essere eliminato poichè non associato a nessun film visto che
        // potrebbe già esserci o magari sarebbe stato inserito comunque in futuro
        FFilm::deleteFromPersoneFilm($film);
        FFilm::storeAttori($film, $listaAttori);
        FFilm::storeRegisti($film, $listaRegisti);
    }


    // cancella un film dal db ovvero dalle tabelle film, filmvisti recensione e risposta
    public static function delete(EFilm $film): void {

        if(FFilm::existById($film)) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "DELETE FROM " . self::$nomeTabella .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                /* il codice seguete, funzionante, è sostituito dal FFilm::deleteFromPersoneFilm
                // ogni attore, se l'array è di almeno un elemento, verrà rimosso da personefilm
                if($listaAttori) {
                    foreach ($listaAttori as $attore) {
                        $idPersona = $attore->getId();
                        $idFilm = $film->getId();
                        FPersona::deletePersoneFilm($idPersona, $idFilm);
                    }
                }
                // ogni regista, se l'array è di almeno un elemento, verrà rimosso da personefilm
                if($listaRegisti) {
                    foreach ($listaRegisti as $regista) {
                        $idPersona = $regista->getId();
                        $idFilm = $film->getId();
                        FPersona::deletePersoneFilm($idPersona, $idFilm);
                    }
                }
                */
                FFilm::deleteFromRecensione($film);
                FFilm::deleteFromRisposta($film);
                FFilm::deleteFromFilmVisti($film);
                FFilm::deleteFromPersoneFilm($film);
                $pdo->commit();
            }
            catch (PDOException $e) {
                $pdo->rollback();
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nCancellazione annullata!";
            }
        }
    }


    // cancella le recensioni riferite al film passato per parametro dal DB
    private static function deleteFromPersoneFilm(EFilm $film): void {

        if (FFilm::existById($film)) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nCancellazione annullata!";
            }
        }
    }


    // cancella le recensioni riferite al film passato per parametro dal DB
    private static function deleteFromRecensione(EFilm $film): void {

        if (FFilm::existById($film)) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nCancellazione annullata!";
            }
        }
    }


    // cancella le risposte riferite al film passato per parametro dal DB
    private static function deleteFromRisposta(EFilm $film): void {

        if (FFilm::existById($film)) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nCancellazione annullata!";
            }
        }
    }


    // cancella le risposte riferite al film passato per parametro dal DB
    private static function deleteFromFilmVisti(EFilm $film): void {

        if(FFilm::existById($film)) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nCancellazione annullata!";
            }
        }
    }


    // metodo che verifica se per un dato film è presente la sua locandina
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
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che carica la locandina di un dato film, restituisce un array con i dati della locandina in base64,
    // il tipo e la sua size.
    // se si setta il bool $grande a true si carica la corrispettiva locandina in formato grande, piccola se false
    // quì quindi sono previste solo queste due dimensioni
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
                // il resize gestisce anche il null come input ;)
                // $locandina sarà una stringa, presa dal db come blob
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

                /* si è considerato che la query potrebbe restituire una locandina null, in quel caso faremo un
                display di una locandina neutra, una pellicola in bianco e nero  */
                return array($locandina, $queryResultFilm[self::$nomeAttributoTipoLocandina], $size);
            }
        }
        catch(PDOException $e) {
            $pdo->rollback();
            echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
        }
        return null;
    }


    // metodo che restituisce un array con chiavi gli idFilm e valori array di locandine, tipo e size
    // se si setta il bool $grande a true si carica la corrispettiva locandina in formato grande, piccola se false
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


    // metodo che inserisce una nuova locandina
    // quì il controllore, chiedendo alla view, fornisce a questo metodo il valore associato a
    // questo $_FILES['file']['tmp_name'], cioè la $nuovaLocandina appena caricata, con $_FILES['file']['type'] il
    // $nuovoTipoLocandina dell'immagine e con $_FILES['file']['size'] la sua $nuovaSizeLocandina
    public static function updateLocandina(EFilm $film, string $nuovaLocandina, string $nuovoTipoLocandina,
                                           string $nuovaSizeLocandina): void {

        if($nuovaSizeLocandina > self::$maxSizeImmagineLocandina) {
            print("Il file caricato è troppo grande!");
            return;
        }

        // TODO
        /* inizio piccola modifica, da testare
        if($nuovoTipoLocandina == "image/jpeg")
            $locandina = imagecreatefromjpeg($nuovaLocandina);
        elseif($nuovoTipoLocandina == "image/png")
            $locandina = imagecreatefrompng($nuovaLocandina);
        else {
            print("Formato non valido!");
            return;
        }
        */ //fine piccola modifica

        // prendo il contenuto grezzo dell'immagine
        //$locandinaContenuto = file_get_contents($locandina);
        // eseguo l'escape
        //$locandinaDaSalvare = addslashes($locandinaContenuto);
        $locandinaDaSalvare = $nuovaLocandina;

        if((FFilm::existById($film))) {
            $pdo = FConnectionDB::connect();
            $pdo->beginTransaction();
            try {
                $query =
                    "UPDATE " . self::$nomeTabella .
                    " SET " . self::$nomeAttributoLocandina . " = '" . $locandinaDaSalvare . "', " .
                    self::$nomeAttributoTipoLocandina . " = '" . $nuovoTipoLocandina . "', " .
                    self::$nomeAttributoSizeLocandina . " = '" . $nuovaSizeLocandina . "'" .
                    " WHERE " . self::$chiaveTabella . " = '" . $film->getId() . "';";
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


    // metodo che modifica una locandina facendo "update a null"
    public static function deleteLocandina(EFilm $film): void {

        if((FFilm::existById($film))) {
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
                echo "\nAttenzione errore: " . $e->getMessage();    // TODO da salvare poi invece sul log degli errori
                echo "\nUpdate annullato!";
            }
        }
    }
}