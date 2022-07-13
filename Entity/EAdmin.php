<?php

/**
 * Classe che ha il compito di modellare il
 * concetto di admin
 */
class EAdmin extends EUser {

    /**
     * I warning massimi consentiti prima che l'utente
     * registrato venga bannato
     * @var int
     */
    public static int $warningMassimi = 3;

    /**
     * Costruttore dell'oggetto EAdmnin, di cui
     * il parametro fondamentale è il suo username
     * @param string $username
     */
    public function __construct(string $username) {
        $this->username = $username;
        $this->ioSono = "Admin";
    }


    /**
     * Metodo che restituisce il ruolo dell'utente in questione e cioè l'admin
     * @return string
     */
    public function chiSei(): string {
        return $this->ioSono;
    }


    /**
     * Metodo che permette di creare un nuovo film
     * per l'applicazione
     * @param int $id
     * @param string $titolo
     * @param int $anno
     * @param int $durata
     * @param string $sinossi
     * @param array $registi
     * @param array $attori
     * @return EFilm
     * @throws Exception
     */
    public function aggiungiFilm(int $id, string $titolo, int $anno, int $durata, string $sinossi, array $registi, array $attori): EFilm {
        //Damiano ha scritto che lui fa il parsing e crea il film, non sara' una classe a parte a farlo ed a passargli un film gia' fatto?
        // Oppure un metodo di EFilm chiamato Parsing come fatto a Programmazione Mobile?
        $recensioni = array();
        return new EFilm($id, $titolo, new DateTime($anno), $durata, $sinossi, null, null, $registi, $attori,
            $recensioni, null);
        //dopo questo, dopo l'eventuale parsing, parte la query
    }


    /**
     * Metodo che modifica il titolo del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param string $nuovoTitolo
     * @return void
     */
    public function modificaTitoloFilm(EFilm $filmDaModificare, string $nuovoTitolo): void {
            $filmDaModificare->setTitolo($nuovoTitolo);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare il titolo
    }


    /**
     * Metodo che modifica la data d'uscita del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param int $nuovoAnno
     * @return void
     * @throws Exception
     */
    public function modificaAnnoFilm(EFilm $filmDaModificare, int $nuovoAnno): void {
            $filmDaModificare->setAnno(new DateTime($nuovoAnno));
            //poi faremo la query di update passando come parametro il fatto che voglio modificare l'anno
    }


    /**
     * Metodo che modifica la durata del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param int $nuovaDurata
     * @return void
     */
    public function modificaDurataFilm(EFilm $filmDaModificare, int $nuovaDurata): void {
            $filmDaModificare->setDurata($nuovaDurata);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare la durata
    }


    /**
     * Metodo che modifica la sinossi del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param string $nuovaSinossi
     * @return void
     */
    public function modificaSinossiFilm(EFilm $filmDaModificare, string $nuovaSinossi): void {
            $filmDaModificare->setSinossi($nuovaSinossi);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare la sinossi
    }


    /**
     * Metodo che modifica la lista di registi del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param array $nuoviRegisti
     * @return void
     */
    public function modificaRegistiFilm(EFilm $filmDaModificare, array $nuoviRegisti): void {
            $filmDaModificare->setListaRegisti($nuoviRegisti);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare i registi
    }

    /**
     * Metodo che modifica la lista di attori del film passato per parametro
     * @param EFilm $filmDaModificare
     * @param array $nuoviAttori
     * @return void
     */
    public function modificaAttoriFilm(EFilm $filmDaModificare, array $nuoviAttori): void {
            $filmDaModificare->setListaAttori($nuoviAttori);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare gli attori
    }


}