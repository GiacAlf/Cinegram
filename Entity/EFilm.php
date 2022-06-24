<?php

class EFilm {

    private ?int $idFilm;   // sarà null in fase di costruzione ex novo, avrà un valore quando farò il load da DB
    private String $titolo;
    private DateTime $data;
    private int $durata;    // durata in minuti
    private String $sinossi;
    private ?int $numeroViews;
    private ?float $votoMedio;
    private ?array $listaRegisti;
    private ?array $listaAttori;
    private ?array $listaRecensioni;
    /* i prossimi due parametri servono per il ridimensionamento della locandina in formato piccolo, in caso di futuri
    cambiamenti si possono aggiungere altre dimensioni e scegliere con un parametro numerico in ingresso alla
    funzione di resize per scegliere la dimensione che si desidererà */
    private static int $larghezzaGrande = 210;  // in pixel
    private static int $altezzaGrande = 315;    // in pixel
    private static int $larghezzaPiccola = 70;  // in pixel
    private static int $altezzaPiccola = 105;    // in pixel

    public function __construct(?int $id, string $titolo, DateTime $data, int $durata, string $sinossi, ?int $numeroViews,
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


    public function aggiungiRegista(ERegista $regista): void {
        $this->listaRegisti[]=$regista;
    }


    public function aggiungiAttore(EAttore $attore): void {
        $this->listaAttori[]=$attore;
    }


   public function aggiungiRecensione(ERecensione $recensione): void {
        $this->listaRecensioni[]=$recensione;
   }


   public function rimuoviRegista(ERegista $regista): void {
        if (($key = array_search($regista, $this->listaRegisti))!==false)
            unset($this->listaRegisti[$key]);
    }


    public function rimuoviAttore(EAttore $attore): void {
        if (($key = array_search($attore, $this->listaAttori))!==false)
            unset($this->listaAttori[$key]);
    }


    public function rimuoviRecensione(ERecensione $recensione): void {
        if (($key = array_search($recensione, $this->listaRecensioni))!==false) {
            unset($this->listaRecensioni[$key]);
        }
    }


    /**
     * @return int
     */
    public function getId(): int {
        return $this->idFilm;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->idFilm = $id;
    }


    /**
     * @return string
     */
    public function getTitolo(): string {
        return $this->titolo;
    }


    /**
     * @param string $titolo
     */
    public function setTitolo(string $titolo): void {
        $this->titolo = $titolo;
    }


    /**
     * @return int
     */
    public function getAnno(): DateTime {
        return $this->data;
    }


    /**
     * @param int $anno
     */
    public function setAnno(DateTime $data): void {
        $this->data = $data;
    }


    /**
     * @return int
     */
    public function getDurata(): int {
        return $this->durata;
    }


    /**
     * @param int $durata
     * @return void
     */
    public function setDurata(int $durata): void {
        $this->durata = $durata;
    }


    /**
     * @return string
     */
    public function getSinossi(): string {
        return $this->sinossi;
    }


    /**
     * @param string $sinossi
     */
    public function setSinossi(string $sinossi): void {
        $this->sinossi = $sinossi;
    }


    /**
     * @return int
     */
    public function getNumeroViews(): ?int {
        return $this->numeroViews;
    }


    public function setNumeroViews(int $numeroViews): void {
        $this->numeroViews = $numeroViews;
    }


    /**
     * @return float|null
     */
    public function getVotoMedio(): ?float {
        return $this->votoMedio;
    }


    public function setVotoMedio(?float $votoMedio): void {
        $this->votoMedio = $votoMedio;
    }


    /**
     * @return array|null
     */
    public function getListaRegisti(): ?array {
        return $this->listaRegisti;
    }


    /**
     * @param array|null $listaRegisti
     */
    public function setListaRegisti(?array $listaRegisti): void {
        $this->listaRegisti = $listaRegisti;
    }


    /**
     * @return array|null
     */
    public function getListaAttori(): ?array {
        return $this->listaAttori;
    }


    /**
     * @param array|null $listaAttori
     */
    public function setListaAttori(?array $listaAttori): void {
        $this->listaAttori = $listaAttori;
    }


    /**
     * @return array|null
     */
    public function getListaRecensioni(): ?array {
        return $this->listaRecensioni;
    }


    /**
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
    public static function base64Encode(?string $locandinaStringa): ?string {
        return base64_encode($locandinaStringa);
    }


    // prende come parametro l'array risultante da EFilm::loadLocandina
    public static function getSrc(?array $locandina): ?string {

        $encodeBase64 = $locandina[0];
        $type = $locandina[1];

        return "data: " . $type . ";base64," . $encodeBase64;
    }
}