<?php

class EStatisticheMember {

    // carica e restituisce un array di EMember che hanno il maggior numero di fil visti, di $numeroDiEstrazioni elementi
    public static function utentiConPiuFilmVisti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFilmVisti($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EMember che hanno il maggior numero di recensioni scritte, di $numeroDiEstrazioni elementi
    public static function utentiConPiuRecensioni(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRecensioni($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EMember che hanno il maggior numero di risposte recenti, di $numeroDiEstrazioni elementi
    public static function utentiConPiuRisposteRecenti(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuRisposteRecenti($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EMember che hanno il maggior numero di follower, di $numeroDiEstrazioni elementi
    public static function utentiConPiuFollower(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollower($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EMember che hanno il maggior numero di following, di $numeroDiEstrazioni elementi
    public static function utentiConPiuFollowing(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiConPiuFollowing($numeroDiEstrazioni);
    }


    // carica e restituisce un array di EMember più popolari (calcolati tra quelli che hanno più follower e più risposte
    // recenti), di $numeroDiEstrazioni elementi
    public static function utentiPiuPopolari(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUtentiPiuPopolari($numeroDiEstrazioni);
    }


    // carica e restituisce un array delle ultime ERecensioni scritte sul forum, di $numeroDiEstrazioni elementi
    public static function ultimeRecensioniScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRecensioniScritte($numeroDiEstrazioni);
    }


    // carica e restituisce un array delle ultime ERisposte scritte sul forum, di $numeroDiEstrazioni elementi
    public static function ultimeRisposteScritte(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeRisposteScritte($numeroDiEstrazioni);
    }


    // inserire come $numeroDiEstrazioni un numero pari!
    // carica e restituisce un array delle ultime attività svolte sul forum (calcolate in base alle recensioni e
    // alle risposte scritte), di $numeroDiEstrazioni elementi
    public static function ultimeAttivita(int $numeroDiEstrazioni): ?array {
        return FStatisticheMember::caricaUltimeAttivita($numeroDiEstrazioni);
    }
}
