<?php
require "CInterazioneFilm.php";
require "CHomepage.php";

class CFrontController {

    // TODO se non trova metodo o classe chiamare VErrore, vedi le view
    public function run($path): void {

        $arraypath = explode("/","$path");
        array_shift($arraypath);
        switch ($arraypath[0]) {

            case("film"):
                $controllore = "CInterazione".$arraypath[0];
                array_shift($arraypath);
                if ($arraypath[0][0] == "?" && count($arraypath)==1){
                    $metodo = "cercaFilm";
                    $controllore::$metodo();
                    return;
                }
                elseif(count($arraypath)==1){
                    $metodo = "CaricaFilm";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                elseif($arraypath[1]=="vedi" && count($arraypath)==2){
                    $metodo="vediFilm";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                elseif ($arraypath[1]=="toglivisto" && count($arraypath)==2){
                    $metodo="rimuoviFilmVisto";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                else{
                    print ("errore 405");
                    return;
                }

            case("films"):
                if(count($arraypath)>1){
                    print ("errore 405");
                    return;
                }
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
                elseif ($arraypath[1]=="elimina" && count($arraypath)==2){
                    $metodo="EliminaRecensione";
                    $controllore::$metodo($arraypath[0]);
                    return;
                }
                else{
                    print ("errore 405");
                    return;
                }

            case("risposta"):
                $controllore="CInterazionefilm";
                array_shift($arraypath);
                if ($arraypath[0][0] == "?" && count($arraypath)==1){
                    $metodo = "ScriviRisposta";
                    $controllore::$metodo();
                    return;
                }
                elseif($arraypath[1] == "elimina" && count($arraypath) == 2) {
                    $metodo = "EliminaRisposta";
                    $data=ERisposta::ConvertiFormatoUrlInData($arraypath[0]);
                    $controllore::$metodo($data);
                    return;
                }
                else {
                    print ("errore 405");
                    return;
                }

            case("risposte"):
                array_shift($arraypath);
                if($arraypath[0][0]=="?" && count($arraypath)==1){
                $controllore="CInterazionefilm";
                $metodo="caricaRisposte";
                $controllore::$metodo();
                return;
                }
                else {
                    print("errore 405");
                    return;

                }

            case("homepage"):
                if(count($arraypath)>1){
                    print("errore 405");
                    return;
                }
                $controllore="CHomepage";
                $metodo="impostaHomePage";
                $controllore::$metodo();
                break;


            case("member"):
                $controllore="CInterazioneMember";
                array_shift($arraypath);
                if (count($arraypath)==2){
                    if ($arraypath[1]=="follow"){
                        $metodo="seguiMember";
                        $controllore::$metodo($arraypath[0]);
                    }
                    else{
                        $metodo="unfollowMember";
                        $controllore::$metodo($arraypath[0]);
                    }
                }
                else {
                    if($arraypath[0]=="registrazione"){
                        $metodo="registrazione";
                        $controllore::$metodo();
                    }
                    else {
                        $metodo="caricaMember";
                        $controllore::$metodo($arraypath[0]);
                    }
                }

            case("members"):
            $controllore="CInterazioneMember";
            $metodo="caricaMembers";
            $controllore::$metodo();
            break;

            case("login"):
                $controllore="CLogin";
                if (count($arraypath)==2){
                    $metodo="verificaLogin";
                    $controllore::$metodo();

                }
                else{
                    $metodo="paginaLogin";
                    $controllore::$metodo();

                }

            case("logout"):
                $metodo="logoutMember";
                $controllore::$metodo();



            case("admin"):
                $controllore="CGestioneAdmin";
                switch(count($arraypath)){
                    case (1):
                        $metodo="caricaPaginaAdmin";
                        $controllore::$metodo();
                        break;

                    case (2):
                        switch($arraypath[1]) {
                            case ("caricafilm"):
                                $metodo="caricaFilm";
                                $controllore::$metodo();
                                break;

                            case ("recensione"):
                                $metodo="rimuoviRecensione";
                                $controllore::$metodo();
                                break;

                            case ("risposta"):
                                $metodo="rimuoviRisposta";
                                $controllore::$metodo();
                                break;
                        }
                        break;

                    case (3):
                        switch($arraypath[2]){
                            case("ammonisci"):
                                $metodo="ammonisciUser";
                                $controllore::$metodo($arraypath[1]);
                                break;

                            case("sbanna"):
                                $metodo="sbannaUser";
                                $controllore::$metodo($arraypath[1]);
                                break;

                            case("togliammonizione"):
                                $metodo="togliAmmonizione";
                                $controllore::$metodo($arraypath[1]);
                                break;
                        }
                        break;
                }

            case("profilo"):
                $controllore="CGestioneProfilo";
                if(count($arraypath)==1){
                    $metodo="caricaProfilo";
                    $controllore::$metodo();
                }
                elseif($arraypath[1]=="aggiornaimmagine") {
                    $metodo="aggiornaImmagineProfilo";
                    $controllore::$metodo();
                }
                elseif ($arraypath[1]=="aggiornabio"){
                    $metodo="aggiornaBioProfilo";
                    $controllore::$metodo();
                }
                elseif($arraypath[1]=="aggiornapw"){
                    $metodo="aggiornaPasswordMember";
                    $controllore::$metodo();

                }
                break;
        }
        print("errore 404");
    }



















































}