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
}