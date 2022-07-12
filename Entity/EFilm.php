<?php

/**
 * Classe che ha il compito di modellare il
 * concetto di film
 */
class EFilm {

    /**
     * L'id numerico del film autogenerato
     * @var int|null
     */
    private ?int $idFilm;
    /**
     * Il titolo del film
     * @var string
     */
    private String $titolo;
    /**
     * La data d'uscita del film
     * @var DateTime
     */
    private DateTime $data;
    /**
     * La durata in minuti
     * @var int
     */
    private int $durata;
    /**
     * La sinossi del film
     * @var string|null
     */
    private ?String $sinossi;
    /**
     * Il numero di utenti che ha visto il film
     * @var int|null
     */
    private ?int $numeroViews;
    /**
     * Il voto medio nelle recensioni del film
     * @var float|null
     */
    private ?float $votoMedio;
    /**
     * La lista di registi del film
     * @var array|null
     */
    private ?array $listaRegisti;
    /**
     * La lista di attori del film
     * @var array|null
     */
    private ?array $listaAttori;
    /**
     * La lista di recensioni del film
     * @var array|null
     */
    private ?array $listaRecensioni;
    /* i prossimi due parametri servono per il ridimensionamento della locandina in formato piccolo, in caso di futuri
    cambiamenti si possono aggiungere altre dimensioni e scegliere con un parametro numerico in ingresso alla
    funzione di resize per scegliere la dimensione che si desidererà */
    /**
     * La larghezza della locandina grande del film
     * @var int
     */
    public static int $larghezzaGrande = 210;  // in pixel
    /**
     * L'altezza della locandina grande del film
     * @var int
     */
    public static int $altezzaGrande = 315;    // in pixel
    /**
     * La larghezza della locandina piccola del film
     * @var int
     */
    public static int $larghezzaPiccola = 70;  // in pixel
    /**
     * L'altezza della locandina grande del film
     * @var int
     */
    public static int $altezzaPiccola = 105;    // in pixel

    /**
     * Costruttore dell'oggetto EFilm, di cui i parametri necessari sono il titolo del film, la durata,
     * la data d'uscita
     * @param int|null $id
     * @param string $titolo
     * @param DateTime $data
     * @param int $durata
     * @param string|null $sinossi
     * @param int|null $numeroViews
     * @param float|null $votoMedio
     * @param array|null $listaRegisti
     * @param array|null $listaAttori
     * @param array|null $listaRecensioni
     */
    public function __construct(?int   $id, string $titolo, DateTime $data, int $durata, ?string $sinossi, ?int $numeroViews,
                                ?float $votoMedio, ?array $listaRegisti, ?array $listaAttori, ?array $listaRecensioni) {
        $this->idFilm = $id;
        $this->titolo = $titolo;
        $this->data = $data;
        $this->durata = $durata;
        $this->sinossi = $sinossi;
        $this->numeroViews = $numeroViews;
        $this->votoMedio = $votoMedio;
        $this->listaRegisti = $listaRegisti;
        $this->listaAttori = $listaAttori;
        $this->listaRecensioni = $listaRecensioni;
    }

    /**
     * Metodo che aggiunge un oggetto ERegista alla lista di registi
     * @param ERegista $regista
     * @return void
     */
    public function aggiungiRegista(ERegista $regista): void {
        $this->listaRegisti[]=$regista;
    }

    /**
     * Metodo che aggiunge un oggetto EAttore alla lista di attori
     * @param EAttore $attore
     * @return void
     */
    public function aggiungiAttore(EAttore $attore): void {
        $this->listaAttori[]=$attore;
    }


    /**
     * Metodo che aggiunge un oggetto ERecensione alla lista di recensioni
     * @param ERecensione $recensione
     * @return void
     */
    public function aggiungiRecensione(ERecensione $recensione): void {
        $this->listaRecensioni[]=$recensione;
   }


    /**
     * Metodo che rimuove un oggetto ERegista dalla lista di registi
     * @param ERegista $regista
     * @return void
     */
    public function rimuoviRegista(ERegista $regista): void {
        if (($key = array_search($regista, $this->listaRegisti))!==false)
            unset($this->listaRegisti[$key]);
    }


    /**
     * Metodo che rimuove un oggetto EAttore dalla lista di attori
     * @param EAttore $attore
     * @return void
     */
    public function rimuoviAttore(EAttore $attore): void {
        if (($key = array_search($attore, $this->listaAttori))!==false)
            unset($this->listaAttori[$key]);
    }


    /**
     * Metodo che rimuove un oggetto ERecensione dalla lista di recensioni
     * @param ERecensione $recensione
     * @return void
     */
    public function rimuoviRecensione(ERecensione $recensione): void {
        if (($key = array_search($recensione, $this->listaRecensioni))!==false) {
            unset($this->listaRecensioni[$key]);
        }
    }


    /**
     * Metodo che restituisce l'id del film
     * @return int
     */
    public function getId(): int {
        return $this->idFilm;
    }


    /**
     * Metodo che aggiorna l'id del film
     * @param int $id
     */
    public function setId(int $id): void {
        $this->idFilm = $id;
    }


    /**
     * Metodo che restituisce il titolo del film
     * @return string
     */
    public function getTitolo(): string {
        return $this->titolo;
    }


    /**
     * Metodo che restituisce il titolo del film, prendendo in
     * ingresso il suo id numerico
     * @param int $idFilm
     * @return string
     */
    public function getTitoloById(int $idFilm): string {
        $film = FPersistentManager::load("EFilm", $idFilm, null, null, null, null,
            null, null, false);

        return $film->getTitolo;
    }


    /**
     * Metodo che aggiorna il titolo del film
     * @param string $titolo
     */
    public function setTitolo(string $titolo): void {
        $this->titolo = $titolo;
    }


    /**
     * Metodo che restituisce la data di uscita del film
     * @return int
     */
    public function getAnno(): DateTime {
        return $this->data;
    }


    /**
     * Metodo che aggiorna la data di uscita del film
     * @param int $anno
     */
    public function setAnno(DateTime $data): void {
        $this->data = $data;
    }


    /**
     * Metodo che restituisce la durata del film
     * @return int
     */
    public function getDurata(): int {
        return $this->durata;
    }


    /**
     * Metodo che aggiorna la durata del film
     * @param int $durata
     * @return void
     */
    public function setDurata(int $durata): void {
        $this->durata = $durata;
    }


    /**
     * Metodo che restituisce la sinossi del film
     * @return string
     */
    public function getSinossi(): string {
        return $this->sinossi;
    }


    /**
     * Metodo che aggiorna la sinossi del film
     * @param string $sinossi
     */
    public function setSinossi(string $sinossi): void {
        $this->sinossi = $sinossi;
    }


    /**
     * Metodo che restituisce il numero di utenti che hanno visto il film
     * @return int
     */
    public function getNumeroViews(): ?int {
        return $this->numeroViews;
    }


    /**
     * Metodo che aggiorna il numero di utenti che hanno visto il film
     * @param int $numeroViews
     * @return void
     */
    public function setNumeroViews(int $numeroViews): void {
        $this->numeroViews = $numeroViews;
    }


    /**
     * Metodo che restituisce il voto medio delle recensioni del film
     * @return float|null
     */
    public function getVotoMedio(): ?float {
        return $this->votoMedio;
    }


    /**
     * Metodo che aggiorna il voto medio delle recensioni del film
     * @param float|null $votoMedio
     * @return void
     */
    public function setVotoMedio(?float $votoMedio): void {
        $this->votoMedio = $votoMedio;
    }


    /**
     * Metodo che restituisce la lista di registi del film
     * @return array|null
     */
    public function getListaRegisti(): ?array {
        return $this->listaRegisti;
    }


    /**
     * Metodo che aggiorna la lista di registi del film
     * @param array|null $listaRegisti
     */
    public function setListaRegisti(?array $listaRegisti): void {
        $this->listaRegisti = $listaRegisti;
    }


    /**
     * Metodo che restituisce la lista di attori del film
     * @return array|null
     */
    public function getListaAttori(): ?array {
        return $this->listaAttori;
    }


    /**
     * Metodo che aggiorna la lista di attori del film
     * @param array|null $listaAttori
     */
    public function setListaAttori(?array $listaAttori): void {
        $this->listaAttori = $listaAttori;
    }


    /**
     * Metodo che restituisce la lista di recensioni del film
     * @return array|null
     */
    public function getListaRecensioni(): ?array {
        return $this->listaRecensioni;
    }

    /**
     * Metodo che restituisce il numero di recensioni del film
     * @return int|null
     */
    public function getNumeroRecensioni(): ?int{
        $numero_recensioni = FPersistentManager::calcolaNumeroRecensioniFilm($this->idFilm);
        return $numero_recensioni;
    }


    /**
     * Metodo che aggiorna la lista di recensioni del film
     * @param array|null $listaRecensioni
     */
    public function setListaRecensioni(?array $listaRecensioni): void {
        $this->listaRecensioni = $listaRecensioni;
    }


    /* metodo che restituisce una locandina più piccola dell'originale (che verrà passata per parametro e
    caricata dal DB) se si setta il parametro $grande a false oppure non si setta affatto.
    (ciò che deve essere passato al metodo è quindi del tipo $array[0], dove $array è il ritornato da
    FFilm::loadLocandina).
    Il resize non è percentuale ma fornisce una larghezza e altezza fissata dagli attributi
    statici di questa classe */
    /**
     * Metodo che restituisce la locandina del film grande o piccola, a seconda del
     * parametro passato in ingresso
     * @param string|null $locandinaDaQuery
     * @param bool $grande
     * @return string|null
     */
    public static function resizeLocandina(?string $locandinaDaQuery, bool $grande): ?string {

        /* il film potrebbe non avere la locandina, in questo modo se la query trova il suo valore a null
        restituirà sempre null */
        if(is_null($locandinaDaQuery))
            return null;

        // crea la GdImage $locandina dalla stringa presa dal db come blob e prende larghezza e lunghezza
        $locandina = imagecreatefromstring($locandinaDaQuery);
        $larghezzaImmagine = imagesx($locandina);
        $lunghezzaImmagine = imagesy($locandina);

        if($grande) {
            $larghezzaDesiderata = self::$larghezzaGrande;
            $altezzaDesiderata = self::$altezzaGrande;
        }
        else {
            $larghezzaDesiderata = self::$larghezzaPiccola;
            $altezzaDesiderata = self::$altezzaPiccola;
        }

        // preparazione nuova locandina
        $locandinaRidimensionata = imagecreatetruecolor($larghezzaDesiderata, $altezzaDesiderata);

        // setta $locandinaRidimensionata con tutti i parametri, è una GdImage
        imagecopyresampled($locandinaRidimensionata, $locandina, 0, 0, 0, 0,
            $larghezzaDesiderata, $altezzaDesiderata, $larghezzaImmagine, $lunghezzaImmagine);

        // devo fare così per poter prendere il contenuto di un immagine
        ob_start();
        imagejpeg($locandinaRidimensionata);
        $locandinaRidimensionataString = ob_get_clean();

        // si svuota la variabile (fanno tutti così!)
        // imagedestroy($locandina);

        // questa è per provare che il resize funzioni, salva su file system
        // imagejpeg($locandinaRidimensionata, "/Users/giacomoalfani/Downloads/locandinaRidimensionata.jpeg", 100);
        // anche questa è per provare, stampa su browser (o console Phpstorm)
        // imagejpeg($locandinaRidimensionata, null, 100);

        // la locandina ritornata è una stringa
        return $locandinaRidimensionataString;
    }


    // metodo che si occupa della codifica in base64 richiesta per il display

    /**
     * Metodo che restituisce la codifica in base 64 della locandina del film
     * @param string|null $locandinaStringa
     * @return string|null
     */
    public static function base64Encode(?string $locandinaStringa): ?string {
        return base64_encode($locandinaStringa);
    }


    // prende come parametro l'array risultante da EFilm::loadLocandina

    /**
     * Metodo che restituisce una stringa necessaria al tag img
     * dell'HTML per fare il display della locandina
     * @param array|null $locandina
     * @return string|null
     */
    public static function getSrc(?array $locandina): ?string {

        if($locandina[0] === null)
            return "/Src/Locandina_Nulla.jpeg";

        $encodeBase64 = $locandina[0];
        $type = $locandina[1];

        return "data: " . $type . ";base64," . $encodeBase64;
    }
}