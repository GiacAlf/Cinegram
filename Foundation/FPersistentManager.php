<?php

class FPersistentManager {

    // verifica l'esistenza in DB, seguire i metodi foundation per i relativi passaggi dei parametri
    public static function exist(string $EClass, ?int $id, ?string $username, ?string $nome, ?string $cognome,
                                 ?EFilm $film, ?string $titolo, ?int $anno, ?DateTime $dataScrittura): ?bool {

        $FClass = str_replace("E", "F", $EClass);

        if($FClass == "FUser") return $FClass::exist($username);
        if($FClass == "FRisposta") return $FClass::exist($username, $dataScrittura);
        if($FClass == "FRecensione") return $FClass::exist($id, $username);
        if($FClass == "FPersona") return $FClass::exist($id);
        if($FClass == "FAttore" || $FClass == "FRegista") return $FClass::exist($nome, $cognome);

        if($FClass == "FFilm") {
            if($film)
                return $FClass::existById($film);
            if($titolo && $anno)
                return $FClass::existByTitoloEAnno($titolo, $anno);
            return $FClass::existByTitolo($titolo);
        }
        return null;
    }


    // In questo caso conosco la classe $EClass dell'oggetto da caricare e sarà quindi da indicare obbligatoriamente,
    // i restanti parametri andranno settati solo se richiesti dalla foundation relativa, altrimenti inserire null.
    // Il booleano $completo sarà importante, se settato a true, solo per EMember ed EFilm, così da caricare le rispettive
    // entity complete di tutti gli attributi costituiti da array, e per ERecensione, che permetterà di caricare tutte
    // le sue risposte.
    public static function load(string $EClass, ?int $id, ?string $username, ?string $nome, ?string $cognome,
                                ?string $titolo, ?int $anno, ?DateTime $data, bool $completo){

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


    // fa lo store ricevendo un oggetto entity come parametro e chiama la corrispettiva foundation.
    // Per Attore e Regista: se si vuole salvare un nuovo attore nella tabella Persona si deve usare lo store con il
    // solo parametro $object, se si vuole invece salvare sulla tabella PersoneFilm fornire anche il $film, se si vuole
    // fare entrambe le cose usare due store diverse.
    // i 3 parametri "immagine" serviranno sia per salvare l'immagine profilo del member che la locandina del film
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


    // fare attenzione ai campi che si compilano, il parametro nuovoValore è una stringa ma è usato anche per
    // l'update di interi, come la durata del film
    public static function update(object $object, ?string $nomeAttributo, ?string $nuovoValore, ?string $nuovaPassword,
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
            if($listaAttori || $listaRegisti)
                return $FClass::updateAttoriERegisti($object, $listaAttori, $listaRegisti);
            return $FClass::update($object, $nomeAttributo, $nuovoValore);
        }
        return null;
    }


    // esegue il delete, fare riferimento alle relative foundation per capire meglio i parametri in ingresso
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

    /* nota per me: se ci fossero ambiguità inserire la stringa $FClass per discriminare */

    public static function follow(EMember $usernameFollower, EMember $usernameFollowing): void {
        // $EClass = get_class($usernameFollower);
        // $FClass = str_replace("E", "F", $EClass);
        FMember::follow($usernameFollower, $usernameFollowing);
    }


    public static function unfollow(EMember $usernameFollower, EMember $usernameFollowing): void {
        // $EClass = get_class($usernameFollower);
        // $FClass = str_replace("E", "F", $EClass);
        FMember::unfollow($usernameFollower, $usernameFollowing);
    }


    public static function loadListaFilmVisti(string $username): ?array {
        return FMember::loadListaFilmVisti($username);
    }


    public static function loadListaFollower(string $username): ?array {
        return FMember::loadListaFollower($username);
    }


    public static function loadListaFollowing(string $username): ?array {
        return FMember::loadListaFollowing($username);
    }


    public static function loadListaRecensioni(string $username): ?array {
        return FMember::loadListaRecensioni($username);
    }


    public static function vediFilm(EMember $member, EFilm $film): void {
        FMember::vediFilm($member, $film);
    }


    public static function rimuoviFilmVisto(EMember $member, EFilm $film): void {
        FMember::rimuoviFilmVisto($member, $film);
    }


    public static function updateBio(EMember $member, ?string $nuovaBio): void {
        FMember::updateBio($member, $nuovaBio);
    }


    public static function incrementaWarning(EMember $member): void {
        FMember::incrementaWarning($member);
    }


    public static function decrementaWarning(EMember $member): void {
        FMember::decrementaWarning($member);
    }


    public static function updatePassword(EMember $member, string $nuovaPassword): void {
        FMember::updatePassword($member, $nuovaPassword);
    }


    public static function memberRegistrato(string $username, string $password): ?bool {
        return FMember::memberRegistrato($username, $password);
    }


    public static function calcolaNumeroFilmVisti(EMember $member): ?int {
        return FMember::calcolaNumeroFilmVisti($member);
    }


    public static function calcolaNumeroFollowing(EMember $member): ?int {
        return FMember::calcolaNumeroFollowing($member);
    }


    public static function calcolaNumeroFollower(EMember $member): ?int {
        return FMember::calcolaNumeroFollower($member);
    }


    public static function calcolaNumeroRecensioni(EMember $member): ?int {
        return FMember::calcolaNumeroRecensioni($member);
    }


    public static function calcolaNumeroRisposte(EMember $member): ?int {
        return FMember::calcolaNumeroRisposte($member);
    }


    public static function caricaUltimeRecensioniScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRecensioniScritteUtente($member, $numeroDiEstrazioni);
    }


    public static function caricaUltimeRisposteScritteUtente(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRisposteScritteUtente($member, $numeroDiEstrazioni);
    }


    public static function caricaUltimeAttivitaMember(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeAttivitaMember($member, $numeroDiEstrazioni);
    }


    public static function caricaUltimeRecensioniScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRecensioniScritteUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    public static function caricaUltimeRisposteScritteUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeRisposteScritteUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    public static function caricaUltimeAttivitaUtentiSeguiti(EMember $member, int $numeroDiEstrazioni): ?array {
        return FMember::caricaUltimeAttivitaUtentiSeguiti($member, $numeroDiEstrazioni);
    }


    public static function existImmagineProfilo(EMember $member): ?bool {
        return FMember::existImmagineProfilo($member);
    }


    // se $grande è true su caricherà l'immagine profilo grande
    public static function loadImmagineProfilo(EMember $member, bool $grande): ?array {
        return FMember::loadImmagineProfilo($member, $grande);
    }


    public static function updateImmagineProfilo(EMember $member, string $nuovaImmagine, string $nuovoTipoImmagine,
                                                 string $nuovaSizeImmagine): void {
        FMember::updateImmagineProfilo($member, $nuovaImmagine, $nuovoTipoImmagine, $nuovaSizeImmagine);
    }


    public static function deleteImmagineProfilo(EMember $member): void {
        FMember::deleteImmagineProfilo($member);
    }


            /* ----- metodi di FFilm ----- */


    public static function loadNumeroViews(EFilm $film): ?int {
        return FFilm::loadNumeroViews($film);
    }


    public static function loadVotoMedio(EFilm $film): ?float {
        return FFilm::loadVotoMedio($film);
    }


    public static function loadListaRegisti(EFilm $film): ?array {
        return FFilm::loadListaRegisti($film);
    }


    public static function loadListaAttori(EFilm $film): ?array {
        return FFilm::loadListaAttori($film);
    }


    public static function loadListaRecensioniFilm(EFilm $film): ?array {
        return FFilm::loadListaRecensioniFilm($film);
    }


    public static function existLocandina(EFilm $film): ?bool {
        return FFilm::existLocandina($film);
    }


    // se $grande è true su caricherà la locandina grande
    public static function loadLocandina(EFilm $film, bool $grande): ?array {
        return FFilm::loadLocandina($film, $grande);
    }


    public static function updateLocandina(EFilm $film, string $nuovaLocandina, string $nuovoTipoLocandina,
                                           string $nuovaSizeLocandina): void {
        FFilm::updateLocandina($film, $nuovaLocandina, $nuovoTipoLocandina, $nuovaSizeLocandina);
    }


    public static function deleteLocandina(EFilm $film): void {
        FFilm::deleteLocandina($film);
    }


            /* ----- metodi di FPersona ----- */


    public static function existPersoneFilm(int $idPersona, int $idFilm): ?bool {
        return FPersona::existPersoneFilm($idPersona, $idFilm);
    }


    public static function deletePersoneFilm(int $idPersona, int $idFilm): void {
        FPersona::deletePersoneFilm($idPersona, $idFilm);
    }


    public static function loadFilmByNomeECognome(string $nome, string $cognome): ?array {
        return FPersona::loadFilmByNomeECognome($nome, $cognome);
    }

            /* ----- metodi di FRecensione ----- */


    public static function loadRisposte(int $idFilmRecensito, string $usernameAutoreRecensione): ?array {
        return FRecensione::loadRisposte($idFilmRecensito, $usernameAutoreRecensione);
    }


            /* ----- metodi di FUser ----- */


    public static function userRegistrato(string $username, string $password): ?bool {
        return FUser::userRegistrato($username, $password);
    }


    public static function userBannato(string $username): ?bool {
        return FUser::userBannato($username);
    }


    public static function tipoUserRegistrato(string $username, string $password): ?string {
        return FUser::tipoUserRegistrato($username, $password);
    }


    public static function bannaUser(string $username): void {
        FUser::bannaUser($username);
    }


    public static function sbannaUser(string $username): void {
        FUser::sbannaUser($username);
    }


            /* ----- metodi di FStatisticheMember ----- */


    public static function caricaUtentiConPiuFilmVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFilmVisti($numeroDiEstrazioni);
    }


    public static function caricaUtentiConPiuRecensioni(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRecensioni($numeroDiEstrazioni);
    }


    public static function caricaUtentiConPiuRisposteRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRisposteRecenti($numeroDiEstrazioni);
    }


    public static function caricaUtentiConPiuFollower(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollower($numeroDiEstrazioni);
    }


    public static function caricaUtentiConPiuFollowing(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollowing($numeroDiEstrazioni);
    }


    public static function caricaUtentiPiuPopolari(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiPiuPopolari($numeroDiEstrazioni);
    }


    public static function caricaUltimeRecensioniScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRecensioniScritte($numeroDiEstrazioni);
    }


    public static function caricaUltimeRisposteScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRisposteScritte($numeroDiEstrazioni);
    }


    public static function caricaUltimeAttivita(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeAttivita($numeroDiEstrazioni);
    }


            /* ----- metodi di FStatisticheFilm ----- */


    public static function caricaFilmPiuVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuVisti($numeroDiEstrazioni);
    }


    public static function caricaFilmPiuRecensiti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuRecensiti($numeroDiEstrazioni);
    }


    public static function caricaFilmConVotoMedioPiuAlto(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmConVotoMedioPiuAlto($numeroDiEstrazioni);
    }


    public static function caricaFilmRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmRecenti($numeroDiEstrazioni);
    }

}