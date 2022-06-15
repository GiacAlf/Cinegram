<?php

class EMember extends EUser {

    private DateTime $dataIscrizione;
    private ?string $bio; // per gli argomenti facoltativi basterà inserire null o stringa vuota nel costruttore
    private ?int $warning;
    private ?array $filmVisti;
    private ?array $listaFollower;
    private ?array $listaFollowing;
    private ?array $recensioniScritte;  // array k: IdFilm, v: recensioneScritta


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


    // metodo che restituisce un immagine profilo più piccola dell'originale passata per parametro
    // TODO: implementare con del codice che abbia senso, volendo mettere un parametro % di resize passato per parametro
    public static function resizeImmagineProfilo(string $immagineStringa): string {

        $larghezzaInPixel = 20;
        $altezzaInPixel = 20;
        // $immagineStringa = FPersistentManager::caricaImmagine();
        // $tipoImmagine = FPersistentManager::caricaTipo();

        // ricrea l'immagine dalla stringa presa dal db come blob
        $immagineReale = imagecreatefromstring($immagineStringa);

        $immagineRidimensionata = imagecreatetruecolor($larghezzaInPixel, $altezzaInPixel);
        $X = imagesx($immagineReale);
        $Y = imagesy($immagineReale);

        imagecopyresampled($immagineRidimensionata, $immagineReale, 0, 0, 0, 0, $larghezzaInPixel, $altezzaInPixel, $X, $Y);

        // svuota la variabile
        imagedestroy($immagineReale);

        // header('Content-type: image / jpeg');

        imagejpeg($immagineRidimensionata, "/Users/giacomoalfani/Downloads/imm.jpeg", 75);
        return $immagineRidimensionata;
    }
}