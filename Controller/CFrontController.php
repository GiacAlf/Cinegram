<?php
require_once "CInterazioneFilm.php";
require_once "CHomepage.php";
require_once "CInterazioneMember.php";
require_once "CLogin.php";
require_once "CGestioneProfilo.php";
require_once "CGestioneAdmin.php";

class CFrontController {

    // TODO se non trova metodo o classe chiamare VErrore, vedi le view
    public function run($path): void {

        $arraypath = explode("/","$path");
        array_shift($arraypath);
        switch ($arraypath[0]) {

            case("film"):
                $controllore = "CInterazione".$arraypath[0];
                array_shift($arraypath);
                if($arraypath[0][0] == "?" && count($arraypath) == 1) {
                    $metodo = "cercaFilm";
                    $controllore::$metodo();
                    return;
                }
                elseif(count($arraypath) == 1){
                    $metodo = "CaricaFilm";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                elseif($arraypath[1] == "vedi" && count($arraypath) == 2) {
                    $metodo = "vediFilm";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                elseif($arraypath[1] == "toglivisto" && count($arraypath) == 2) {
                    $metodo = "rimuoviFilmVisto";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                else{
                    print("errore 405");
                    return;
                }

            case("films"):
                if(count($arraypath) > 1) {
                    print("errore 405");
                    return;
                }
                $controllore = "CInterazionefilm";
                $metodo = "caricaFilms";
                $controllore::$metodo();
                break;

            case("recensione"):
                $controllore="CInterazionefilm";
                array_shift($arraypath);
                if(count($arraypath) == 1) {
                    $metodo = "ScriviRecensione";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                elseif ($arraypath[1] == "elimina" && count($arraypath) == 2) {
                    $metodo="EliminaRecensione";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                else{
                    print("errore 405");
                    return;
                }

            case("risposta"):
                $controllore = "CInterazionefilm";
                array_shift($arraypath);
                if($arraypath[0][0] == "?" && count($arraypath) == 1) {
                    $metodo = "ScriviRisposta";
                    $controllore::$metodo();
                    return;
                }
                elseif($arraypath[1] == "elimina" && count($arraypath) == 2) {
                    $metodo = "EliminaRisposta";
                    $data = ERisposta::ConvertiFormatoUrlInData($arraypath[0]);
                    $controllore::$metodo($data);
                    return;
                }
                else {
                    print("errore 405");
                    return;
                }

            case("risposte"):
                array_shift($arraypath);
                if($arraypath[0][0] == "?" && count($arraypath) == 1) {
                $controllore = "CInterazionefilm";
                $metodo = "caricaRisposte";
                $controllore::$metodo();
                return;
                }
                else {
                    print("errore 405");
                    return;
                }

            case("homepage"):
                if(count($arraypath) > 1) {
                    print("errore 405");
                    return;
                }
                $controllore = "CHomepage";
                $metodo = "impostaHomePage";
                $controllore::$metodo();
                break;


            case("member"):
                $controllore = "CInterazioneMember";
                array_shift($arraypath);
                    if($arraypath[1] == "follow" && count($arraypath) == 2) {
                        $metodo = "seguiMember";
                        $controllore::$metodo($arraypath[0]);
                        return;
                    }
                    elseif($arraypath[1] == "unfollow" && count($arraypath) == 2) {
                        $metodo = "unfollowMember";
                        $controllore::$metodo($arraypath[0]);
                        return;
                    }
                    elseif($arraypath[0] == "registrazione" && count($arraypath) == 1) {
                        $metodo = "registrazione";
                        $controllore::$metodo();
                        return;
                    }
                    elseif(count($arraypath) == 1) {
                        $metodo = "caricaMember";
                        $controllore::$metodo($arraypath[0]);
                        return;
                    }
                    else{
                        print("errore 405");
                        return;
                    }


            case("members"):
                $controllore="CInterazioneMember";
                if(count($arraypath) > 1) {
                    print("errore 405");
                    return;
                }
                $metodo = "caricaMembers";
                $controllore::$metodo();
                break;

            case("login"):
                $controllore = "CLogin";
                if(count($arraypath) == 2 && $arraypath[1] == "accesso") {
                    $metodo = "verificaLogin";
                    $controllore::$metodo();
                    return;
                }
                elseif(count($arraypath) == 1) {
                    $metodo = "paginaLogin";
                    $controllore::$metodo();
                    return;
                }
                else{
                    print("errore 405");
                    return;
                }

            case("logout"):
                if(count($arraypath) > 1) {
                    print("errore 405");
                    return;
                }
                $controllore = "CLogin";
                $metodo = "logoutMember";
                $controllore::$metodo();
                break;

            case("admin"):
                $controllore = "CGestioneAdmin";
                if(count($arraypath) == 1) {
                    $metodo="caricaPaginaAdmin";
                    $controllore::$metodo();
                    return;
                }
                elseif(count($arraypath) == 2 && $arraypath[1] == "caricafilm") {
                    $metodo = "caricaFilm";
                    $controllore::$metodo();
                    return;

                }
                elseif(count($arraypath) == 2 && $arraypath[1] == "recensione") {
                    $metodo = "rimuoviRecensione";
                    $controllore::$metodo();
                    return;

                }
                elseif(count($arraypath) == 2 && $arraypath[1] == "risposta") {
                    $metodo = "rimuoviRisposta";
                    $controllore::$metodo();
                    return;

                }
                elseif(count($arraypath) == 3 && $arraypath[2] == "ammonisci") {
                    $metodo="ammonisciUser";
                    $controllore::$metodo($arraypath[1]);
                    return;

                }
                elseif(count($arraypath) == 3 && $arraypath[2] == "sbanna") {
                    $metodo = "sbannaUser";
                    $controllore::$metodo($arraypath[1]);
                    return;

                }
                elseif(count($arraypath) == 3 && $arraypath[2] == "togliammonizione") {
                    $metodo = "togliAmmonizione";
                    $controllore::$metodo($arraypath[1]);
                    return;

                }
                else {
                    print("errore 405");
                    return;
                }


            case("profilo"):
                $controllore = "CGestioneProfilo";
                if(count($arraypath) == 1) {
                    $metodo = "caricaProfilo";
                    $controllore::$metodo();
                    return;
                }
                elseif($arraypath[1] == "aggiornaimmagine" && count($arraypath) == 2) {
                    $metodo = "aggiornaImmagineProfilo";
                    $controllore::$metodo();
                    return;
                }
                elseif($arraypath[1] == "aggiornabio" && count($arraypath) == 2) {
                    $metodo = "aggiornaBioProfilo";
                    $controllore::$metodo();
                    return;
                }
                elseif($arraypath[1] == "aggiornapw" && count($arraypath) == 2) {
                    $metodo="aggiornaPasswordMember";
                    $controllore::$metodo();
                    return;
                }
                else {
                    print("errore 405");
                    return;
                }
        }
        print("errore 404");
    }
}