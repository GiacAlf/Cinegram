<?php

class EStatisticheFilm {

    // carica e restituisce un array di EFilm più visti, di $numeroDiEstrazioni elementi
    public static function filmPiuVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuVisti($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EFilm più recensiti, di $numeroDiEstrazioni elementi
    public static function filmPiuRecensiti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmPiuRecensiti($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EFilm con voto medio più alto di, $numeroDiEstrazioni elementi
    public static function filmConVotoMedioPiuAlto(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmConVotoMedioPiuAlto($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EFilm più recenti, di $numeroDiEstrazioni elementi
    public static function filmRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheFilm::caricaFilmRecenti($numeroDiEstrazioni);
    }
}
