<?php

/**
 * Classe adibita a gestire alcune liste di utenti
 * utili alle pagine principali dell'applicazione
 */
class EStatisticheMember {

    /**
     * Metodo che restituisce una lista di utenti con più film visti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiConPiuFilmVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFilmVisti($numeroDiEstrazioni);
    }


    /**
     * Metodo che restituisce una lista di utenti con più recensioni scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiConPiuRecensioni(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRecensioni($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce una lista di utenti con più risposte recenti scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiConPiuRisposteRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRisposteRecenti($numeroDiEstrazioni);
    }


    /**
     * Metodo che restituisce una lista di utenti con più follower
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiConPiuFollower(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollower($numeroDiEstrazioni);
    }


    /**
     * Metodo che restituisce una lista di utenti con più following
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiConPiuFollowing(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollowing($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce la lista di utenti più popolari
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function utentiPiuPopolari(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiPiuPopolari($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce una lista delle ultime recensioni scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function ultimeRecensioniScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRecensioniScritte($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce una lista delle ultime risposte scritte
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function ultimeRisposteScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRisposteScritte($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce una lista delle ultime attività
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function ultimeAttivita(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeAttivita($numeroDiEstrazioni);
    }
}
