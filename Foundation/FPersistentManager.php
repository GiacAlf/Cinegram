<?php

class FPersistentManager {

    // verifica l'esistenza in DB, segue le regole degli altri metodi
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
    public static function load(string $EClass, ?int $id, ?string $username, ?EFilm $film, ?string $nome, ?string $cognome,
                                ?string $titolo, ?int $anno, ?DateTime $data, bool $completo): ?object {

        $FClass = str_replace("E", "F", $EClass);
        // in base al valore di $FClass si verrà indirizzati verso il corretto metodo foundation
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
            if($film)
                return $FClass::loadById($film, $completo, $completo, $completo);
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
    public static function store(object $object, ?EFilm $film, ?string $password, ?array $attori, ?array $registi): void {

        $EClass = get_class($object);
        $FClass = str_replace("E", "F", $EClass);

        // in base al valore di $FClass si verrà indirizzati verso il corretto metodo foundation
        if($FClass == "FRisposta" || $FClass == "FRecensione") {
            $FClass::store($object);
            return;
        }

        if($FClass == "FAdmin" || $FClass == "FMember") {
            $FClass::store($object, $password);
            return;
        }

        if($FClass == "FFilm") {
            $FClass::store($object, $attori, $registi);
            return;
        }

        if($FClass == "FAttore" || $FClass == "FRegista") {
            if($film) {
                $FClass::storePersoneFilm($object, $film);
            }
            else $FClass::store($object);
        }
    }


    // TODO da completare
    public static function update(object $object, $vecchioValore, $nuovoValore): void {

        $EClass = get_class($object);
        $FClass = str_replace("E", "F", $EClass);
        $FClass::update($object, $vecchioValore, $nuovoValore);
    }


    // esegue il delete
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


    // permette allo $usernameFollower di seguire lo $usernameFollowing
    public static function follow(EMember $usernameFollower, EMember $usernameFollowing): void {

        $EClass = get_class($usernameFollower);
        $FClass = str_replace("E", "F", $EClass);
        $FClass::follow($usernameFollower, $usernameFollowing);
    }


    // rimuove il follow dello $usernameFollower verso lo $usernameFollowing
    public static function unfollow(EMember $usernameFollower, EMember $usernameFollowing): void {

        $EClass = get_class($usernameFollower);
        $FClass = str_replace("E", "F", $EClass);
        $FClass::unfollow($usernameFollower, $usernameFollowing);
    }
}