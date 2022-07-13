<?php

/**
 * Classe adibita a gestire alcune liste di film
 * utili alle pagine principali dell'applicazione
 */
class EStatisticheFilm {

    /**
     * Metodo che restituisce una lista di film più visti dagli utenti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function filmPiuVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuVisti($numeroDiEstrazioni);
    }


    /**
     * Metodo che restituisce una lista di film più recensiti dagli utenti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function filmPiuRecensiti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuRecensiti($numeroDiEstrazioni);
    }

    /**
     * Metodo che restituisce una lista di film con voti medi più alti
     * assegnati dagli utenti
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function filmConVotoMedioPiuAlto(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmConVotoMedioPiuAlto($numeroDiEstrazioni);
    }


    /**
     * Metodo che restituisce una lista di film recenti, per data d'uscita
     * @param int $numeroDiEstrazioni
     * @return array|null
     * @throws Exception
     */
    public static function filmRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmRecenti($numeroDiEstrazioni);
    }
}
