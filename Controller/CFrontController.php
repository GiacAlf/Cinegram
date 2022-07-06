<?php

class CFrontController {

    public function run(): void{
        $path = $this->parsingFrontControllerUrl() ;
        $arraypath = explode("/","$path");
        array_shift($arraypath);
        $controller = "C". ucfirst($arraypath[0]);
        array_shift($arraypath);
        $method = $this->capisciUrl($arraypath[0]);
        if ( class_exists( $controller ) ) {
            if ( method_exists($controller, $method ) ) {
                $real_controller = new $controller();
            }
            else {
                $view = new VErrore();
                $view ->error(3);
                return;

            }
        }
        else {
            $view = new VErrore();
            $view ->error(2);
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


    private function capisciUrl(?string $path): ?string{
        $arrayRisultato = explode("-",$path);
        $arrayRisultato[1] = ucfirst($arrayRisultato[1]);
        return ($arrayRisultato[0].$arrayRisultato[1]);
    }

    private function parsingFrontControllerUrl():string{
        $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url_base = $GLOBALS["URLBASE"];
        $frontUrl = str_replace($url_base , "", $url);
        return $frontUrl;
    }
}