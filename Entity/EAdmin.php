<?php

class EAdmin extends EUser {

    public static int $warningMassimi = 3;


    public function __construct(string $username) {
        $this->username = $username;
        $this->ioSono = "Admin";
    }


    public function chiSei(): string {
        return $this->ioSono;
    }


    public function ammonisciUser(string $usernameMemberDaAmmonire): void {

        // si carica l'EMember
        $memberDaAmmonire = FMember::load($usernameMemberDaAmmonire, false, false,
            false, false);
        // calcolo dei warning attuali
        $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();
        if($warningMemberDaAmmonire < self::$warningMassimi) {
            $memberDaAmmonire->incrementaWarning();
            if($memberDaAmmonire->getWarning() == self::$warningMassimi) {
                $this->bannaUser($memberDaAmmonire);
            }
        }
        else echo "\nL'utente è già bannato!";
    }


    public function TogliAmmonizione(string $usernameMemberDaAmmonire): void { //potrebbe essere utile, magari vogliamo mettere
        $memberDaAmmonire = FMember::load($usernameMemberDaAmmonire, false, false,
            false, false);
        // calcolo dei warning attuali
        $warningMemberDaAmmonire = $memberDaAmmonire->getWarning();
        if ($warningMemberDaAmmonire>0 && $warningMemberDaAmmonire<3)
           $memberDaAmmonire->decrementaWarning();
        else
            print ("Errore");




    }


    //metodo che dovrà evolversi con Foundation
    private function bannaUser(EMember $member): void {
        FPersistentManager::bannaUser($member->getUsername());
            /*Banno il membro, lui avra' magari nella sua tabella nel db un attributo bannato e lo metto a true(?)
            cosi quando proverà a fare un nuovo account con le stesse credenziali se la prende in culo?
            quando fa login dobbiamo controllare se ci sono username, password e bannato a false? Sì
            Inoltre come gestire questa cosa? Quando l'admin banna l'utente dovra' vedere una schermata con scritto
            sei stato bannato ed essere cacciato da Cinegram altrimenti lui se non slogga rimane all'infinito dentro
            come nulla fosse successo
            */
        echo "Utente bannato!";
    }


    //qui invece id autogenerato??
    public function aggiungiFilm(int $id, string $titolo, int $anno, int $durata, string $sinossi, array $registi, array $attori): EFilm {
        //Damiano ha scritto che lui fa il parsing e crea il film, non sara' una classe a parte a farlo ed a passargli un film gia' fatto?
        // Oppure un metodo di EFilm chiamato Parsing come fatto a Programmazione Mobile?
        $recensioni = array();
        return new EFilm($id, $titolo, new DateTime($anno), $durata, $sinossi, null, null, $registi, $attori,
            $recensioni, null);
        //dopo questo, dopo l'eventuale parsing, parte la query
    }


    /*
    public function rimuoviFilm(EFilm $filmDaRimuovere): void {
        unset($filmDaRimuovere); //boh, non funge, forse solo lavoro di db?
        //e parte la query per cancellare il film-> inoltre cancellando tutti le info a riguardo
        //dunque cancello il film nelle liste degli utenti, cancello le recensioni legate al film,
        //tutte le risposte... lo vogliamo tenere davvero?
    }
    */

    public function modificaIdFilm(EFilm $filmDaModificare, int $nuovoId): void {
        $filmDaModificare->setId($nuovoId);
        //poi faremo la query di update passando come parametro il fatto che voglio modificare l'id
    }


    public function modificaTitoloFilm(EFilm $filmDaModificare, string $nuovoTitolo): void {
            $filmDaModificare->setTitolo($nuovoTitolo);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare il titolo
    }


    public function modificaAnnoFilm(EFilm $filmDaModificare, int $nuovoAnno): void {
            $filmDaModificare->setAnno(new DateTime($nuovoAnno));
            //poi faremo la query di update passando come parametro il fatto che voglio modificare l'anno
    }


    public function modificaDurataFilm(EFilm $filmDaModificare, int $nuovaDurata): void {
            $filmDaModificare->setDurata($nuovaDurata);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare la durata
    }


    public function modificaSinossiFilm(EFilm $filmDaModificare, string $nuovaSinossi): void {
            $filmDaModificare->setSinossi($nuovaSinossi);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare la sinossi
    }


    public function modificaRegistiFilm(EFilm $filmDaModificare, array $nuoviRegisti): void {
            $filmDaModificare->setListaRegisti($nuoviRegisti);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare i registi
    }

    public function modificaAttoriFilm(EFilm $filmDaModificare, array $nuoviAttori): void {
            $filmDaModificare->setListaAttori($nuoviAttori);
            //poi faremo la query di update passando come parametro il fatto che voglio modificare gli attori
    }

    /*
     * la modifica per NumeroViews, VotoMedio, Recensioni non mi pare il caso
     * quando si potrebbe fare nel caso? Difficile e molto pericoloso secondo me
     *Concordo, tanto sono tutti valori che si derivano, quindi non dovremmo poterli cambiare arbitrariamente
     */


    // ritorna tutti gli ammoniti, per poter agire con togli ammonizione
    public function tuttiGliAmmoniti(): ?array {

        // TODO da implementare se ci serve
        return array();
    }


    // ritorna tutti i bannati, per poter agire con togli ban
    public function tuttiIBannati(): ?array {

        // TODO da implementare se ci serve
        return array();
    }

    public function setUsername(string $username): void {
            $this->username = $username;
    }
}