<?php

class EMember extends EUser {

    private DateTime $dataIscrizione;
    private ?string $bio; // per gli argomenti facoltativi basterà inserire null o stringa vuota nel costruttore
    private ?int $warning;
    private ?array $filmVisti;
    private ?array $listaFollower;
    private ?array $listaFollowing;
    private ?array $recensioniScritte;  // array k: IdFilm, v: recensioneScritta
    /* i prossimi due parametri servono per il ridimensionamento dell'immagine profilo in formato piccolo, in caso di futuri
    cambiamenti si possono aggiungere altre dimensioni e scegliere con un parametro numerico in ingresso alla
    funzione di resize per scegliere la dimensione che si desidererà */
    private static int $larghezzaDesiderata = 80;  // in pixel
    private static int $altezzaDesiderata = 80;    // in pixel


    // quando si crea ex novo i warning saranno sempre zero
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


    public function vediFilm(EFilm $filmVisto): void {
        $this->filmVisti[] = $filmVisto;
    }


    public function rimuoviFilmVisto(EFilm $filmDaRimuovere): void {
        $key = array_search($filmDaRimuovere, $this->filmVisti);
        unset($this->filmVisti[$key]);
    }


    public function scriviRecensione(EFilm $filmRecensito, ERecensione $recensioneScritta): void {
        $this->recensioniScritte[$filmRecensito->getId()] = $recensioneScritta;
        $filmRecensito->aggiungiRecensione($recensioneScritta);
    }


    public function rimuoviRecensione(EFilm $filmRecensito, ERecensione $recensioneDaRimuovere): void {
        $key = $filmRecensito->getId();
        unset($this->recensioniScritte[$key]);
        $filmRecensito->rimuoviRecensione($recensioneDaRimuovere);
    }


    public function scriviRisposta(ERisposta $rispostaScritta, ERecensione $recensioneInteressata): void {
        $recensioneInteressata->AggiungiRisposta($rispostaScritta, $this->username);
    }


    public function rimuoviRisposta(ERisposta $rispostaDaRimuovere, ERecensione $recensioneInteressata): void { //ok, problema: con questa soluzione un utente può accedere a risposte non sue
        $recensioneInteressata->RimuoviRisposta($rispostaDaRimuovere, $this->username); //soluzione: controllo autore risposta
    }


    public function Follow(EMember $memberDaSeguire): void {
        $this->listaFollowing[] = $memberDaSeguire;
        $memberDaSeguire->AggiungiFollower($this); //aggiungi te stesso
    }


    public function UnFollow(EMember $memberDaNonSeguire): void {
        $key = array_search( $memberDaNonSeguire, $this->listaFollowing);
        unset($this->listaFollowing[$key]);
        $memberDaNonSeguire->RimuoviFollower($this);
    }


    private function AggiungiFollower(EMember $follower): void {
        $this->listaFollower[] = $follower;
    }


    private function RimuoviFollower(EMember $follower): void {
        $key = array_search( $follower, $this->listaFollower);
        unset($this->listaFollower[$key]);
    }


    public function incrementaWarning(): void {
        $this->warning = $this->warning + 1;

    }


    public function decrementaWarning(): void {
        $this->warning = $this->warning - 1;
    }


    public function getUsername(): string {
        return $this->username;
    }


    // serve? alla fine lo username lo si scrive sul db in fare di registrazione e poi faccio solo get,
    // non è modificabile lo username
    public function setUsername(string $username): void {
        $this->username = $username;
    }


    public function chiSei(): string {
        return $this->ioSono;
    }


    public function getWarning(): ?int {
        return $this->warning;
    }


    public function getDataIscrizione(): DateTime {
        return $this->dataIscrizione;
    }


    public function getBio(): ?string {
        return $this->bio;
    }


    public function setBio(string $bio): void {
        $this->bio = $bio;
    }


    public function getFilmVisti(): ?array {
        return $this->filmVisti;
    }


    public function getListaFollower(): ?array {
        return $this->listaFollower;
    }


    public function getListaFollowing(): ?array {
        return $this->listaFollowing;
    }


    public function getRecensioniScritte(): ?array {
        return $this->recensioniScritte;
    }


    /* metodo che restituisce un immagine profilo più piccola dell'originale (che verrà passata per parametro e
    caricata dal DB) se si setta il parametro $grande a false oppure non si setta affatto.
    (ciò che deve essere passato al metodo è quindi del tipo $array[0], dove $array è il ritornato da
    FMember::loadImmagineProfilo).
    Il resize non è percentuale ma fornisce una larghezza e altezza fissata dagli attributi
    statici di questa classe */
    public static function resizeImmagineProfilo(?string $immagineDaQuery): ?string {

        /* il member potrebbe non aver caricato l'immagine, in questo modo se la query trova il suo valore a null
        restituirà sempre null */
        if(is_null($immagineDaQuery))
            return null;

        // crea la GdImage $immagine dalla stringa presa dal db come blob e prende larghezza e lunghezza
        $immagine = imagecreatefromstring($immagineDaQuery);
        $larghezzaImmagine = imagesx($immagine);
        $lunghezzaImmagine = imagesy($immagine);

        // preparazione nuova immagine
        $immagineRidimensionata = imagecreatetruecolor(self::$larghezzaDesiderata, self::$altezzaDesiderata);

        // setta $immagineRidimensionata con tutti i parametri, è una GdImage
        imagecopyresampled($immagineRidimensionata, $immagine, 0, 0, 0, 0,
            self::$larghezzaDesiderata, self::$altezzaDesiderata, $larghezzaImmagine, $lunghezzaImmagine);

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
    public static function base64Encode(?string $immagineStringa): ?string {
        return base64_encode($immagineStringa);
    }


    // prende come parametro l'array risultante da EMember::loadImmagineProfilo
    public static function getSrc(?array $immagineProfilo): ?string {

        $encodeBase64 = $immagineProfilo[0];
        $type = $immagineProfilo[1];

        return "data: " . $type . ";base64," . $encodeBase64;
    }
}