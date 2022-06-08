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


    public function scriviRecensione(EFilm $filmRecensito, ERecensione $recensioneScritta): void {  //ok
        $this->recensioniScritte[$filmRecensito->getId()] = $recensioneScritta;
        $filmRecensito->aggiungiRecensione($recensioneScritta);
    }


    public function rimuoviRecensione(EFilm $filmRecensito, ERecensione $recensioneDaRimuovere): void { //ok
        $key = $filmRecensito->getId();
        unset($this->recensioniScritte[$key]);
        $filmRecensito->rimuoviRecensione($recensioneDaRimuovere);
    }


    public function scriviRisposta(ERisposta $rispostaScritta, ERecensione $recensioneInteressata): void { //ok
        $recensioneInteressata->AggiungiRisposta($rispostaScritta, $this->username);
    }


    public function rimuoviRisposta(ERisposta $rispostaDaRimuovere, ERecensione $recensioneInteressata): void { //ok, problema: con questa soluzione un utente può accedere a risposte non sue
        $recensioneInteressata->RimuoviRisposta($rispostaDaRimuovere, $this->username); //soluzione: controllo autore risposta
    }


    public function Follow(EMember $memberDaSeguire): void { //ok, fino a che non aggiungi i follower, da lì il casino totale
        $this->listaFollowing[] = $memberDaSeguire; //pare funzioni, attenzione alla lettura del print
        $memberDaSeguire->AggiungiFollower($this); //aggiungi te stesso
    }


    public function UnFollow(EMember $memberDaNonSeguire): void { //stessa cosa di sopra
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
}