<?php

/**
 * Classe che ha il compito di modellare il
 * concetto di member, cioè l'utente registrato
 */
class EMember extends EUser {

    /**
     * La data d'iscrizione dell'utente
     * @var DateTime
     */
    private DateTime $dataIscrizione;
    /**
     * La bio dell'utente
     * @var string|null
     */
    private ?string $bio;
    /**
     * I warning dell'utente
     * @var int|null
     */
    private ?int $warning;
    /**
     * La lista di film visti dall'utente
     * @var array|null
     */
    private ?array $filmVisti;
    /**
     * La lista di follower dell'utente
     * @var array|null
     */
    private ?array $listaFollower;
    /**
     * La lista di utenti che l'utente segue
     * @var array|null
     */
    private ?array $listaFollowing;
    /**
     * La lista di recensioni scritte dall'utente
     * @var array|null
     */
    private ?array $recensioniScritte;  // array k: IdFilm, v: recensioneScritta
    /* i prossimi due parametri servono per il ridimensionamento dell'immagine profilo in formato piccolo, in caso di futuri
    cambiamenti si possono aggiungere altre dimensioni e scegliere con un parametro numerico in ingresso alla
    funzione di resize per scegliere la dimensione che si desidererà */
    /**
     * La larghezza dell'immagine profilo grande dell'utente
     * @var int
     */
    public static int $larghezzaGrande = 210;  // in pixel
    /**
     * L'altezza dell'immagine profilo grande dell'utente
     * @var int
     */
    public static int $altezzaGrande = 210;    // in pixel
    /**
     * La larghezza dell'immagine profilo piccola dell'utente
     * @var int
     */
    public static int $larghezzaPiccola = 80;  // in pixel
    /**
     * L'altezza dell'immagine profilo piccola dell'utente
     * @var int
     */
    public static int $altezzaPiccola = 80;    // in pixel


    // quando si crea ex novo i warning saranno sempre zero
    /**
     * Costruttore dell'oggetto EMember, di cui i parametri necessari sono
     * lo username e la data d'iscrizione
     * @param string $username
     * @param DateTime $dataIscrizione
     * @param string|null $bio
     * @param int|null $warning
     * @param array|null $filmVisti
     * @param array|null $listaFollower
     * @param array|null $listaFollowing
     * @param array|null $recensioniScritte
     */
    public function __construct(string $username, DateTime $dataIscrizione, ?string $bio, ?int $warning, ?array $filmVisti,
                                ?array $listaFollower, ?array $listaFollowing, ?array $recensioniScritte) {

        $this->username = $username;
        $this->ioSono = "Member";
        $this->dataIscrizione = $dataIscrizione;
        $this->bio = $bio;
        $this->warning = $warning;
        $this->filmVisti = $filmVisti;
        $this->listaFollower = $listaFollower;
        $this->listaFollowing = $listaFollowing;
        $this->recensioniScritte = $recensioniScritte;
    }


    /**
     * Metodo che aggiunge un nuovo film alla lista di film visti dall'utente
     * @param EFilm $filmVisto
     * @return void
     */
    public function vediFilm(EFilm $filmVisto): void {
        $this->filmVisti[] = $filmVisto;
    }


    /**
     * Metodo che rimuove un film dalla lista di film visti dall'utente
     * @param EFilm $filmDaRimuovere
     * @return void
     */
    public function rimuoviFilmVisto(EFilm $filmDaRimuovere): void {
        $key = array_search($filmDaRimuovere, $this->filmVisti);
        unset($this->filmVisti[$key]);
    }


    /**
     * Metodo che aggiunge una recensione alla lista di recensioni scritte
     * dall'utente
     * @param EFilm $filmRecensito
     * @param ERecensione $recensioneScritta
     * @return void
     */
    public function scriviRecensione(EFilm $filmRecensito, ERecensione $recensioneScritta): void {
        $this->recensioniScritte[$filmRecensito->getId()] = $recensioneScritta;
        $filmRecensito->aggiungiRecensione($recensioneScritta);
    }


    /**
     * Metodo che rimuove una recensione dalla lista di recensioni scritte
     * dall'utente
     * @param EFilm $filmRecensito
     * @param ERecensione $recensioneDaRimuovere
     * @return void
     */
    public function rimuoviRecensione(EFilm $filmRecensito, ERecensione $recensioneDaRimuovere): void {
        $key = $filmRecensito->getId();
        unset($this->recensioniScritte[$key]);
        $filmRecensito->rimuoviRecensione($recensioneDaRimuovere);
    }


    /**
     * Metodo che aggiunge una risposta alla lista di risposte della recensione
     * interessata
     * @param ERisposta $rispostaScritta
     * @param ERecensione $recensioneInteressata
     * @return void
     */
    public function scriviRisposta(ERisposta $rispostaScritta, ERecensione $recensioneInteressata): void {
        $recensioneInteressata->AggiungiRisposta($rispostaScritta, $this->username);
    }


    /**
     * Metodo che rimuove una risposta dalla lista di risposte della recensione
     * interessata
     * @param ERisposta $rispostaDaRimuovere
     * @param ERecensione $recensioneInteressata
     * @return void
     */
    public function rimuoviRisposta(ERisposta $rispostaDaRimuovere, ERecensione $recensioneInteressata): void { //ok, problema: con questa soluzione un utente può accedere a risposte non sue
        $recensioneInteressata->RimuoviRisposta($rispostaDaRimuovere, $this->username); //soluzione: controllo autore risposta
    }


    /**
     * Metodo che aggiunge alla lista di following l'utente passato per parametro
     * @param EMember $memberDaSeguire
     * @return void
     */
    public function Follow(EMember $memberDaSeguire): void {
        $this->listaFollowing[] = $memberDaSeguire;
        $memberDaSeguire->AggiungiFollower($this); //aggiungi te stesso
    }


    /**
     * Metodo che rimuove dalla lista di following l'utente passato per parametro
     * @param EMember $memberDaNonSeguire
     * @return void
     */
    public function UnFollow(EMember $memberDaNonSeguire): void {
        $key = array_search( $memberDaNonSeguire, $this->listaFollowing);
        unset($this->listaFollowing[$key]);
        $memberDaNonSeguire->RimuoviFollower($this);
    }


    /**
     * Metodo che aggiunge alla lista di follower l'utente passato per parametro
     * @param EMember $follower
     * @return void
     */
    private function AggiungiFollower(EMember $follower): void {
        $this->listaFollower[] = $follower;
    }


    /**
     * Metodo che rimuove dalla lista di follower l'utente passato per parametro
     * @param EMember $follower
     * @return void
     */
    private function RimuoviFollower(EMember $follower): void {
        $key = array_search( $follower, $this->listaFollower);
        unset($this->listaFollower[$key]);
    }


    /**
     * Metodo che incrementa i warning dell'utente
     * @return void
     */
    public function incrementaWarning(): void {
        $this->warning = $this->warning + 1;

    }


    /**
     * Metodo che decrementa i warning dell'utente
     * @return void
     */
    public function decrementaWarning(): void {
        $this->warning = $this->warning - 1;
    }


    /**
     * Metodo che restituisce lo username dell'utente
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }


    /**
     * Metodo che restituisce il ruolo dell'utente cioè Member
     * @return string
     */
    public function chiSei(): string {
        return $this->ioSono;
    }


    /**
     * Metodo che restituisce i warning dell'utente
     * @return int|null
     */
    public function getWarning(): ?int {
        return $this->warning;
    }


    /**
     * Metodo che restituisce la data d'iscrizione dell'utente
     * @return DateTime
     */
    public function getDataIscrizione(): DateTime {
        return $this->dataIscrizione;
    }


    /**
     * Metodo che restituisce la bio dell'utente
     * @return string|null
     */
    public function getBio(): ?string {
        return $this->bio;
    }


    /**
     * Metodo che aggiorna la bio dell'utente
     * @param string $bio
     * @return void
     */
    public function setBio(string $bio): void {
        $this->bio = $bio;
    }


    /**
     * Metodo che restituisce la lista di film visti dall'utente
     * @return array|null
     */
    public function getFilmVisti(): ?array {
        return $this->filmVisti;
    }


    /**
     * Metodo che restituisce la lista di follower dell'utente
     * @return array|null
     */
    public function getListaFollower(): ?array {
        return $this->listaFollower;
    }


    /**
     * Metodo che restituisce la lista di following dell'utente
     * @return array|null
     */
    public function getListaFollowing(): ?array {
        return $this->listaFollowing;
    }


    /**
     * Metodo che restituisce la lista di recensioni scritte dall'utente
     * @return array|null
     */
    public function getRecensioniScritte(): ?array {
        return $this->recensioniScritte;
    }


    /**
     * Metodo che restituisce il numero di risposte scritte dall'utente
     * @return int|null
     */
    public function getNumeroRisposte(): ?int{
        return FPersistentManager::calcolaNumeroRisposte($this);
    }

    /**
     * Metodo che restituisce il numero di follower dell'utente
     * @return int|null
     */
    public function getNumeroFollower(): ?int{
        return FPersistentManager::calcolaNumeroFollower($this);
    }


    /* metodo che restituisce un immagine profilo più piccola dell'originale (che verrà passata per parametro e
    caricata dal DB) se si setta il parametro $grande a false oppure non si setta affatto.
    (ciò che deve essere passato al metodo è quindi del tipo $array[0], dove $array è il ritornato da
    FMember::loadImmagineProfilo).
    Il resize non è percentuale ma fornisce una larghezza e altezza fissata dagli attributi
    statici di questa classe */
    /**
     * Metodo che restituisce l'immagine profilo dell'utente grande o piccola, a seconda del
     * parametro passato in ingresso
     * @param string|null $immagineDaQuery
     * @param bool $grande
     * @return string|null
     */
    public static function resizeImmagineProfilo(?string $immagineDaQuery, bool $grande): ?string {

        /* il member potrebbe non aver caricato l'immagine, in questo modo se la query trova il suo valore a null
        restituirà sempre null */
        if(is_null($immagineDaQuery))
            return null;

        // crea la GdImage $immagine dalla stringa presa dal db come blob e prende larghezza e lunghezza
        $immagine = imagecreatefromstring($immagineDaQuery);
        $larghezzaImmagine = imagesx($immagine);
        $lunghezzaImmagine = imagesy($immagine);

        if($grande) {
            $larghezzaDesiderata = self::$larghezzaGrande;
            $altezzaDesiderata = self::$altezzaGrande;
        }
        else {
            $larghezzaDesiderata = self::$larghezzaPiccola;
            $altezzaDesiderata = self::$altezzaPiccola;
        }

        // preparazione nuova immagine
        $immagineRidimensionata = imagecreatetruecolor($larghezzaDesiderata, $altezzaDesiderata);

        // setta $immagineRidimensionata con tutti i parametri, è una GdImage
        imagecopyresampled($immagineRidimensionata, $immagine, 0, 0, 0, 0,
            $larghezzaDesiderata, $altezzaDesiderata, $larghezzaImmagine, $lunghezzaImmagine);

        // devo fare così per poter prendere il contenuto di un immagine
        ob_start();
        imagejpeg($immagineRidimensionata);
        $immagineRidimensionataString = ob_get_clean();

        // si svuota la variabile (fanno tutti così!)
        // imagedestroy($immagine);

        // questa è per provare che il resize funzioni, salva su file system
        // imagejpeg($immagineRidimensionata, "/Users/giacomoalfani/Downloads/immagineRidimensionata.jpeg", 100);
        // anche questa è per provare, stampa su browser (o console Phpstorm)
        // imagejpeg($immagineRidimensionata, null, 100);

        // l'immagine ritornata è una stringa
        return $immagineRidimensionataString;
    }


    // metodo che si occupa della codifica in base64 richiesta per il display

    /**
     * Metodo che restituisce la codifica in base 64 dell'immagine profilo dell'utente
     * @param string|null $immagineStringa
     * @return string|null
     */
    public static function base64Encode(?string $immagineStringa): ?string {
        return base64_encode($immagineStringa);
    }


    // prende come parametro l'array risultante da EMember::loadImmagineProfilo

    /**
     * Metodo che restituisce una stringa necessaria al tag img
     * dell'HTML per fare il display dell'immagine profilo
     * @param array|null $immagineProfilo
     * @return string|null
     */
    public static function getSrc(?array $immagineProfilo): ?string {

        // per gestire l'avatar nullo
        if($immagineProfilo[0] == null)
            return "https://{\$root_dir}/Cinegram/Src/Avatar_Nullo.png";

        $encodeBase64 = $immagineProfilo[0];
        $type = $immagineProfilo[1];

        return "data: " . $type . ";base64," . $encodeBase64;
    }
}