<?php

class CFrontController {

    // TODO se non trova metodo o classe chiamare VErrore, vedi le view
    public static function run($path): void {

        $arraypath = explode("/","$path");
        array_shift($arraypath);
        switch ($arraypath[0]) {

            case("film"):
                $controllore = "CInterazione".$arraypath[0];
                array_shift($arraypath);
                if ($arraypath[0] = "?"){
                    $metodo = "cercaFilm";
                    $controllore::$metodo();
                    return;
                }
                else {
                    $metodo = "CaricaFilm";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }

            case("films"):
                $controllore="CInterazionefilm";
                $metodo="caricaFilms";
                $controllore::$metodo();
                break;

            case("recensione"):
                $controllore="CInterazionefilm";
                array_shift($arraypath);
                if(count($arraypath)==1){
                    $metodo="ScriviRecensione";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                else{
                    $metodo="EliminaRecensione";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }

            case("risposta"):
                $controllore="CInterazionefilm";
                array_shift($arraypath);
                if ($arraypath[0] = "?"){
                    $metodo = "ScriviRisposta";
                    $controllore::$metodo();
                    return;
                }
                else {
                    $metodo = "EliminaRisposta";
                    $data=ERisposta::ConvertiFormatoUrlInData($arraypath[0]);
                    $controllore::$metodo($data);
                    return;
                }

            case("risposte"):
                $controllore="CInterazionefilm";
                $metodo="caricaRisposte";
                $controllore::$metodo();
                return;

            case("homepage"):
                $controllore="CHomepage";
                $metodo="imposta".$arraypath[0];
                break;


            case("member"):




            case("members"):
            $controllore="CInterazioneMember";
            $metodo="caricaMembers";
            $controllore::$metodo();
            break;



            case("login"):




            case("logout"):




            case("admin"):




            case("profilo"):





        }


    }
















































}