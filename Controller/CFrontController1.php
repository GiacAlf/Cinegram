<?php

class CFrontController1 {

    public function run(string $path): void{
        $arraypath = explode("/","$path");
        array_shift($arraypath);
        $controller = "C". ucfirst($arraypath[0]);
        array_shift($arraypath);
        $method = self::capisciUrl($arraypath[0]);
        if ( class_exists( $controller ) ) {
            if ( method_exists($controller, $method ) ) {
                $real_controller = new $controller();
            } else {
               print ("Errore 405");
                return;
            }
        } else {
            print("Errore 404");
            return;
        }
        array_shift($arraypath);
        switch (count($arraypath)){
            case (0):
                $real_controller->$method();
                break;
            case (1):
                $real_controller->$method( $arraypath[0] );
                break;
            case (2):
                $real_controller->$method( $arraypath[0] ,$arraypath[1] );
                break;
        }
    }








    private static function capisciUrl(string $path):string{
        $arrayRisultato = explode("-",$path);
        $arrayRisultato[1] = ucfirst($arrayRisultato[1]);
        return ($arrayRisultato[0].$arrayRisultato[1]);
    }










}