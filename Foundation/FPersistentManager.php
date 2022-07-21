<?php

    /*
    I seguenti metodi richiederanno l'inserimento del nome della classe entity o direttamente dell'oggetto, per chiamare
    correttamente il rispettivo metodo foundation, e dei parametri necessari richiesti dal metodo. Ciascun altro campo
    dovrà essere popolato con null (o false se booleano)
    */
class FPersistentManager {

    /**
     * Metodo che verifica l'esistenza dei parametri inseriti nel DB
     * @param string $EClass
     * @param int|null $id
     * @param string|null $username
     * @param string|null $nome
     * @param string|null $cognome
     * @param EFilm|null $film
     * @param string|null $titolo
     * @param int|null $anno
     * @param DateTime|null $dataScrittura
     * @return bool|null
     */
    public static function exist(string $EClass, ?int $id, ?string $username, ?string $nome, ?string $cognome,
                                 ?EFilm $film, ?string $titolo, ?int $anno, ?DateTime $dataScrittura): ?bool {

        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FUser") return $FClass::exist($username);
        if($FClass == "FRisposta") return $FClass::exist($username, $dataScrittura);
        if($FClass == "FRecensione") return $FClass::exist($id, $username);
        if($FClass == "FPersona") return $FClass::exist($id);
        if($FClass == "FAttore" || $FClass == "FRegista") return $FClass::exist($nome, $cognome);

        if($FClass == "FFilm") {
            if($id)
                return $FClass::existById($id);
            if($titolo && $anno)
                return $FClass::existByTitoloEAnno($titolo, $anno);
            return $FClass::existByTitolo($titolo);
        }
        return null;
    }


    /*
    Il booleano $completo sarà importante, se settato a true, solo per EMember ed EFilm, così da caricare le rispettive
    entity complete di tutti gli attributi costituiti da array, e per ERecensione, che permetterà di caricare tutte
    le sue risposte
    */
    /**
     * Metodo che verifica l'esistenza di ciò che viene passato per parametro nel DB
     * @param string $EClass
     * @param int|null $id
     * @param string|null $username
     * @param string|null $nome
     * @param string|null $cognome
     * @param string|null $titolo
     * @param int|null $anno
     * @param DateTime|null $data
     * @param bool $completo
     * @return null
     */
    public static function load(string  $EClass, ?int $id, ?string $username, ?string $nome, ?string $cognome,
                                ?string $titolo, ?int $anno, ?DateTime $data, bool $completo) {

        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FAdmin") return $FClass::load($username);
        if($FClass == "FMember") return $FClass::load($username, $completo, $completo, $completo, $completo);
        if($FClass == "FRisposta") return $FClass::load($username, $data);
        if($FClass == "FRecensione") return $FClass::load($id, $username, $completo);

        if($FClass == "FAttore" || $FClass == "FRegista") {
            if($nome == null && $cognome == null)
                return $FClass::loadById($id);
            return $FClass::loadByNomeECognome($nome, $cognome);
        }

        if($FClass == "FFilm") {
            if(!is_null($id))
                return $FClass::loadById($id, $completo, $completo, $completo);
            if($titolo && $nome == null && $cognome == null)
                return $FClass::loadByTitolo($titolo);
            return $FClass::loadByTitoloEAnno($titolo, $anno);
        }
        return null;
    }


    /*
     Per Attore e Regista: se si vuole salvare un nuovo attore nella tabella Persona si deve usare lo store con il
    solo parametro $object, se si vuole invece salvare sulla tabella PersoneFilm fornire anche il $film, se si vuole
    fare entrambe le cose usare due store diverse.
    I tre parametri "immagine" serviranno sia per salvare l'immagine profilo del member che la locandina del film
    */
    /**
     * Metodo che salva ciò che viene passato per parametro nel DB
     * @param object $object
     * @param EFilm|null $film
     * @param string|null $password
     * @param array|null $attori
     * @param array|null $registi
     * @param string|null $immagine
     * @param string|null $tipoImmagine
     * @param string|null $sizeImmagine
     * @return bool|null
     */
    public static function store(object $object, ?EFilm $film, ?string $password, ?array $attori, ?array $registi,
                                 ?string $immagine, ?string $tipoImmagine, ?string $sizeImmagine): ?bool {

        $EClass = get_class($object);
        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FRisposta" || $FClass == "FRecensione") return $FClass::store($object);
        if($FClass == "FAdmin") return $FClass::store($object, $password);
        if($FClass == "FMember") return $FClass::store($object, $password, $immagine, $tipoImmagine, $sizeImmagine);
        if($FClass == "FFilm") return $FClass::store($object, $attori, $registi, $immagine, $tipoImmagine, $sizeImmagine);

        if($FClass == "FAttore" || $FClass == "FRegista") {
            if($film)
                return$FClass::storePersoneFilm($object, $film);
            return $FClass::store($object);
        }
        return null;
    }


    /*
    Fare attenzione ai campi che si compilano, il parametro nuovoValore è una stringa ma è usato anche per
    l'update di interi, come la durata del film
    */
    /**
     * Metodo che permette l'update di ciò che viene passato per parametro nel DB
     * @param object $object
     * @param string|null $nomeAttributo
     * @param string|null $nuovoValore
     * @param string|null $nuovaPassword
     * @param string|null $nuovaBio
     * @param DateTime|null $nuovaData
     * @param array|null $listaAttori
     * @param array|null $listaRegisti
     * @return bool|null
     */
    public static function update(object  $object, ?string $nomeAttributo, ?string $nuovoValore, ?string $nuovaPassword,
                                  ?string $nuovaBio, ?DateTime $nuovaData, ?array $listaAttori, ?array $listaRegisti): ?bool {

        $EClass = get_class($object);
        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FAdmin") return $FClass::updatePassword($object, $nuovaPassword);
        if($FClass == "FRisposta") return $FClass::updateTesto($object, $nuovoValore);
        if($FClass == "FAttore" || $FClass == "FRegista" || $FClass == "FRecensione")
            return $FClass::update($object, $nomeAttributo, $nuovoValore);

        if($FClass == "FMember") {
            if($nuovaPassword)
                return $FClass::update($object, $nuovaPassword);
            return $FClass::updateBio($object, $nuovaBio);
        }

        if($FClass == "FFilm") {
            if($nuovaData)
                return $FClass::updateData($object, $nuovaData);
            //mi serve che il delete lo faccia e poi vada giù
            if($listaAttori && $listaRegisti) {
                $FClass::deleteFromPersoneFilm($object);
                $FClass::updateAttori($object, $listaAttori);
                $FClass::updateRegisti($object, $listaRegisti);
                return null;
            }
            else {
                if ($listaAttori)
                    return $FClass::updateAttori($object, $listaAttori);
                if ($listaRegisti)
                    return $FClass::updateRegisti($object, $listaRegisti);
            }
            return $FClass::update($object, $nomeAttributo, $nuovoValore);
        }
        return null;
    }


    // esegue il delete, fare riferimento alle relative foundation per capire meglio i parametri da passare
    /**
     * Metodo che elimina ciò che viene passato per parametro dal DB
     * @param string $EClass
     * @param string|null $username
     * @param EFilm|null $film
     * @param int|null $idPersona
     * @param int|null $idFilm
     * @param DateTime|null $dataScrittura
     * @return bool|null
     */
    public static function delete(string $EClass, ?string $username, ?EFilm $film, ?int $idPersona, ?int $idFilm,
                                  ?DateTime $dataScrittura): ?bool {

        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FAdmin" || $FClass == "FMember" || $FClass == "FUser") return $FClass::delete($username);
        if($FClass == "FFilm") return $FClass::delete($film);
        if($FClass == "FRecensione") return $FClass::delete($idFilm, $username);
        if($FClass == "FRisposta") return $FClass::delete($username, $dataScrittura);

        if($FClass == "FPersona") {
            if ($idPersona && $idFilm)
                return $FClass::deletePersoneFilm($idPersona, $idFilm);
            return $FClass::delete($idPersona);
        }
        return null;
    }


            /* ----- metodi di FMember ----- */


    /**
     * Metodo che salva il follow di un member verso un altro
     * @param EMember $usernameFollower
     * @param EMember $usernameFollowing
     * @return void
     */
    public static function follow(EMember $usernameFollower, EMember $usernameFollowing): void {
        FMember::follow($usernameFollower, $usernameFollowing);
    }


    /**
     * Metodo elimina il follow di un member verso un altro
     * @param EMember $usernameFollower
     * @param EMember $usernameFollowing
     * @return void
     */
    public static function unfollow(EMember $usernameFollower, EMember $usernameFollowing): void {
        FMember::unfollow($usernameFollower, $usernameFollowing);
    }


    /**
     * Metodo che carica i film visti dal member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFilmVisti(string $username): ?array {
        return FMember::loadListaFilmVisti($username);
    }


    /**
     * Metodo che verifica se il member ha visto il film
     * @param string $username
     * @param int $idFilm
     * @return bool|null
     * @throws Exception
     */
    public static function loHaiVisto(string $username, int $idFilm): ?bool {
        return FMember::loHaiVisto( $username, $idFilm);
    }


    /**
     * Metodo che verifica se il member segue l'altro member
     * @param string $username
     * @param string $usernameFollowing
     * @return bool|null
     * @throws Exception
     */
    public static function loSegui(string $username, string $usernameFollowing): ?bool {
        return FMember::loSegui($username, $usernameFollowing);
    }


    /**
     * Metodo che carica la lista dei follower del member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFollower(string $username): ?array {
        return FMember::loadListaFollower($username);
    }


    /**
     * Metodo che carica la lista dei following del member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaFollowing(string $username): ?array {
        return FMember::loadListaFollowing($username);
    }


    /**
     * Metodo che carica la lista delle recensioni del member
     * @param string $username
     * @return array|null
     * @throws Exception
     */
    public static function loadListaRecensioni(string $username): ?array {
        return FMember::loadListaRecensioni($username);
    }


    /**
     * Metodo che salva sul DB la visione di un film da parte del member
     * @param EMember $member
     * @param EFilm $film
     * @return void
     */
    public static function vediFilm(EMember $member, EFilm $film): void {
        FMember::vediFilm($member, $film);
    }


    /**
     * Metodo che elimina sul DB la visione di un film da parte del member
     * @param EMember $member
     * @param EFilm $film
     * @return void
     */
    public static function rimuoviFilmVisto(EMember $member, EFilm $film): void {
        FMember::rimuoviFilmVisto($member, $film);
    }


    /**
     * Metodo che aggiorna la bio del member
     * @param EMember $member
     * @param string|null $nuovaBio
     * @return void
     */
    public static function updateBio(EMember $member, ?string $nuovaBio): void {
        FMember::updateBio($member, $nuovaBio);
    }


    /**
     * Metodo che incrementa i warning del member
     * @param string $username
     * @return void
     */
    public static function incrementaWarning(string $username): void {
        FMember::incrementaWarning($username);
    }


    /**
     * Metodo che decrementa i warning del member
     * @param string $username
     * @return void
     */
    public static function decrementaWarning(string $username): void {
        FMember::decrementaWarning($username);
    }


    /**
     * Metodo che aggiorna la password del member
     * @param EMember $member
     * @param string $nuovaPassword
     * @return void
     */
    public static function updatePassword(EMember $member, string $nuovaPassword): void {
        FMember::updatePassword($member, $nuovaPassword);
    }


    /**
     * Metodo che verifica se il member è registrato
     * @param string $username
     * @param string $password
     * @return bool|null
     */
    public static function memberRegistrato(string $username, string $password): ?bool {
        return FMember::memberRegistrato($username, $password);
    }


    /**
     * Metodo che calcola il numero di film visti dal member
     * @param EMember $member
     * @return int|null
     */
    public static function calcolaNumeroFilmVisti(EMember $member): ?int {
        return FMember::calcolaNumeroFilmVisti($member);
    }


    /**
     * Metodo che calcola il numero di following del member
     * @param EMember $member
     * @return int|null
     */
    public static function calcolaNumeroFollowing(EMember $member): ?int {
        return FMember::calcolaNumeroFollowing($member);
    }


    /**
     * Metodo che calcola il numero di follower del member
     * @param EMember $member
     * @return int|null
     */
    public static function calcolaNumeroFollower(EMember $member): ?int {
        return FMember::calcolaNumeroFollower($member);
    }


    /**
     * Metodo che calcola il numero di recensioni scritte dal member
     * @param EMember $member
     * @return int|null
     */
    public static function calcolaNumeroRecensioni(EMember $member): ?int {
        return FMember::calcolaNumeroRecensioni($member);
    }


    /**
     * Metodo che calcola il numero di risposte scritte dal member
     * @param EMember $member
     * @return int|null
     */
    public static function calcolaNumeroRisposte(EMember $member): ?int {
        return FMember::calcolaNumeroRisposte($member);
    }


    /**
     * Metodo che carica le ultime recensioni scritte dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRecensioniScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRecensioniScritteUtente($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime risposte scritte dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRisposteScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRisposteScritteUtente($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime attività scritte dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeAttivitaMember(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeAttivitaMember($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime recensioni scritte dagli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRecensioniScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRecensioniScritteUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime risposte scritte dagli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRisposteScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRisposteScritteUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime attività dagli utenti seguiti dal member
     * @param EMember $member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeAttivitaUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeAttivitaUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    /**
     * Metodo che verifica l'esistenza dell'immagine profilo del member
     * @param EMember $member
     * @return bool|null
     */
    public static function existImmagineProfilo(EMember $member): ?bool {
        return FMember::existImmagineProfilo($member);
    }


    // se $grande è true su caricherà l'immagine profilo grande
    /**
     * Metodo che carica l'immagine profilo del member
     * @param EMember $member
     * @param bool $grande
     * @return array|null
     */
    public static function loadImmagineProfilo(EMember $member, bool $grande): ?array {
        return FMember::loadImmagineProfilo($member, $grande);
    }


    /*
     Metodo che restituisce un array con chiavi gli username e valori array d'immagini profilo, tipo e size.
     Se si setta il bool $grande a true si carica la corrispettiva immagine profilo in formato grande, piccola se false
    */
    /**
     * Metodo che carica le immagini profilo di più member
     * @param array $arrayMembers
     * @param bool $grande
     * @return array|null
     */
    public static function loadImmaginiProfiloMembers(array $arrayMembers, bool $grande): ?array {
        return FMember::loadImmaginiProfiloMembers($arrayMembers, $grande);
    }


    /**
     * Metodo che aggiorna l'immagine profilo del member
     * @param string $username
     * @param string $nuovaImmagine
     * @param string $nuovoTipoImmagine
     * @param string $nuovaSizeImmagine
     * @return void
     */
    public static function updateImmagineProfilo(string $username, string $nuovaImmagine, string $nuovoTipoImmagine,
                                                 string $nuovaSizeImmagine): void {
        FMember::updateImmagineProfilo($username, $nuovaImmagine, $nuovoTipoImmagine, $nuovaSizeImmagine);
    }


    /**
     * Metodo che elimina l'immagine profilo del member
     * @param string $username
     * @return void
     */
    public static function deleteImmagineProfilo(string $username): void {
        FMember::deleteImmagineProfilo($username);
    }


            /* ----- metodi di FFilm ----- */


    /**
     * Metodo che carica il numero delle views del film
     * @param int $id
     * @return int|null
     */
    public static function loadNumeroViews(int $id): ?int {
        return FFilm::loadNumeroViews($id);
    }


    /**
     * Metodo che carica il voto medio del film
     * @param int $id
     * @return float|null
     */
    public static function loadVotoMedio(int $id): ?float {
        return FFilm::loadVotoMedio($id);
    }


    /**
     * Metodo che carica la lista dei registi del film
     * @param int $id
     * @return array|null
     */
    public static function loadListaRegisti(int $id): ?array {
        return FFilm::loadListaRegisti($id);
    }


    /**
     * Metodo che carica la lista degli attori del film
     * @param int $id
     * @return array|null
     */
    public static function loadListaAttori(int $id): ?array {
        return FFilm::loadListaAttori($id);
    }


    /**
     * Metodo che carica la lista delle recensioni del film
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function loadListaRecensioniFilm(int $id): ?array {
        return FFilm::loadListaRecensioniFilm($id);
    }

    /**
     * Metodo che calcola il numero di recensioni del film
     * @param int $id
     * @return int|null
     */
    public static function calcolaNumeroRecensioniFilm(int $id): ?int {
        return FFilm::calcolaNumeroRecensioniFilm($id);
    }

    /**
     * Metodo che verifica l'esistenza della locandina del film
     * @param EFilm $film
     * @return bool|null
     */
    public static function existLocandina(EFilm $film): ?bool {
        return FFilm::existLocandina($film);
    }


    /*
    Se $grande è true su caricherà la locandina grande.
    Restituisce un array con i dati della locandina, il tipo e la sua size
    */
    /**
     * Metodo che carica la locandina del film
     * @param EFilm $film
     * @param bool $grande
     * @return array|null
     */
    public static function loadLocandina(EFilm $film, bool $grande): ?array {
        return FFilm::loadLocandina($film, $grande);
    }


    /*
    Restituisce un array con chiavi gli idFilm e valori array di locandine, tipo e size.
    Se si setta il bool $grande a true si carica la corrispettiva locandina in formato grande, piccola se false
    */
    /**
     * Metodo che carica le locandine di più film
     * @param array $arrayFilm
     * @param bool $grande
     * @return array|null
     */
    public static function loadLocandineFilms(array $arrayFilm, bool $grande): ?array {
        return FFilm::loadLocandineFilms($arrayFilm, $grande);
    }


    /**
     * Metodo che aggiorna la locandina del film
     * @param EFilm $film
     * @param string $nuovaLocandina
     * @param string $nuovoTipoLocandina
     * @param string $nuovaSizeLocandina
     * @return void
     */
    public static function updateLocandina(EFilm  $film, string $nuovaLocandina, string $nuovoTipoLocandina,
                                           string $nuovaSizeLocandina): void {
        FFilm::updateLocandina($film, $nuovaLocandina, $nuovoTipoLocandina, $nuovaSizeLocandina);
    }


    /**
     * Metodo che elimina la locandina del film
     * @param EFilm $film
     * @return void
     */
    public static function deleteLocandina(EFilm $film): void {
        FFilm::deleteLocandina($film);
    }


            /* ----- metodi di FPersona ----- */


    /**
     * Metodo che verifica se la persona è legata a un particolare film
     * @param int $idPersona
     * @param int $idFilm
     * @return bool|null
     */
    public static function existPersoneFilm(int $idPersona, int $idFilm): ?bool {
        return FPersona::existPersoneFilm($idPersona, $idFilm);
    }


    /**
     * Metodo che elimina la relazione di una persona con un particolare film
     * @param int $idPersona
     * @param int $idFilm
     * @return void
     */
    public static function deletePersoneFilm(int $idPersona, int $idFilm): void {
        FPersona::deletePersoneFilm($idPersona, $idFilm);
    }


    /**
     * Metodo che restituisce i film in vui la persona ha partecipato
     * @param string $nome
     * @param string $cognome
     * @return array|null
     * @throws Exception
     */
    public static function loadFilmByNomeECognome(string $nome, string $cognome): ?array {
        return FPersona::loadFilmByNomeECognome($nome, $cognome);
    }


            /* ----- metodi di FRecensione ----- */


    /**
     * Metodo che carica le risposte di una recensione
     * @param int $idFilmRecensito
     * @param string $usernameAutoreRecensione
     * @return array|null
     * @throws Exception
     */
    public static function loadRisposte(int $idFilmRecensito, string $usernameAutoreRecensione): ?array {
        return FRecensione::loadRisposte($idFilmRecensito, $usernameAutoreRecensione);
    }


            /* ----- metodi di FRisposta ----- */


    /**
     * Metodo che cancella tutte le risposte della recensione di un film scritta da un member
     * @param string $usernameAutoreRecensione
     * @param int $idFilmRecensito
     * @return void
     */
    public static function deleteRisposteDellaRecensione(string $usernameAutoreRecensione, int $idFilmRecensito): void {
        FRisposta::deleteRisposteDellaRecensione($usernameAutoreRecensione, $idFilmRecensito);
    }


            /* ----- metodi di FUser ----- */


    /**
     * Metodo che verifica se uno user è registrato
     * @param string $username
     * @param string $password
     * @return bool|null
     */
    public static function userRegistrato(string $username, string $password): ?bool {
        return FUser::userRegistrato($username, $password);
    }


    /**
     * Metodo che verifica se uno user è bannato
     * @param string $username
     * @return bool|null
     */
    public static function userBannato(string $username): ?bool {
        return FUser::userBannato($username);
    }


    /**
     * Metodo che restituisce il tipo dello user registato
     * @param string $username
     * @return string|null
     */
    public static function tipoUserRegistrato(string $username): ?string {
        return FUser::tipoUserRegistrato($username);
    }


    /**
     * Metodo che banna uno user
     * @param string $username
     * @return void
     */
    public static function bannaUser(string $username): void {
        FUser::bannaUser($username);
    }


    /**
     * Metodo che sbanna uno user
     * @param string $username
     * @return void
     */
    public static function sbannaUser(string $username): void {
        FUser::sbannaUser($username);
    }


            /* ----- metodi di FStatisticheMember ----- */


    /**
     * Metodo che carica i member con più film visti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiConPiuFilmVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFilmVisti($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i member con più recensioni scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiConPiuRecensioni(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRecensioni($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i member con più risposte scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiConPiuRisposteRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRisposteRecenti($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i member con più follower
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiConPiuFollower(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollower($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i member con più following
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiConPiuFollowing(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollowing($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i member più popolari
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUtentiPiuPopolari(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiPiuPopolari($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime recensioni scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRecensioniScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRecensioniScritte($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime risposte scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeRisposteScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRisposteScritte($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica le ultime attività dei member
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaUltimeAttivita(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeAttivita($numeroDiEstrazioni);
    }


            /* ----- metodi di FStatisticheFilm ----- */


    /**
     * Metodo che carica i film più visti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmPiuVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuVisti($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i film più recensiti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmPiuRecensiti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuRecensiti($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i film con voto medio più alto
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmConVotoMedioPiuAlto(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmConVotoMedioPiuAlto($numeroDiEstrazioni);
    }


    /**
     * Metodo che carica i film recenti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function caricaFilmRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmRecenti($numeroDiEstrazioni);
    }
}