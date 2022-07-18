<?php

/**
 *Classe che fa partire il controllore e il metodo corretto a
 * seconda del clic dell'utente
 */
class CFrontController {

    /**
     * Metodo che, una volta interpretata l'url e gli eventuali parametri in ingresso,
     * chiama ed esegue un metodo di un controllore
     * @return void
     * @throws SmartyException
     */
    public function run(): void {

        $path = $this->parsingFrontControllerUrl();
        $arrayPath = explode("/","$path");
        array_shift($arrayPath);    // perché il primo valore è sempre vuoto
        $controller = "C". ucfirst($arrayPath[0]);
        array_shift($arrayPath);
        $method = $this->capisciUrl($arrayPath[0]);
        if (class_exists($controller)) {
            if (method_exists($controller, $method)) {
                $real_controller = new $controller();
            }
            else {
                $view = new VErrore();
                $view->error(3);
                return;
            }
        }
        else {
            $view = new VErrore();
            $view->error(2);
            return;
        }
        array_shift($arrayPath);
        switch (count($arrayPath)) {
            case (0):
                $real_controller->$method();
                break;
            case (1):
                $real_controller->$method($arrayPath[0]);
                break;
            case (2):
                $real_controller->$method($arrayPath[0], $arrayPath[1]);
                break;
        }
    }


    /**
     * Metodo che interpreta il corretto metodo del controllore da chiamare
     * @param string|null $path
     * @return string|null
     */
    private function capisciUrl(?string $path): ?string {

        $arrayRisultato = explode("-", $path);
        $arrayRisultato[1] = ucfirst($arrayRisultato[1]);
        return ($arrayRisultato[0] . $arrayRisultato[1]);
    }


    /**
     * Metodo che restituisce la url cliccata dall'utente
     * @return string
     */
    private function parsingFrontControllerUrl(): string {

        $url = VUtility::getHttpHost() . VUtility::getRequestUri();
        $url_base = $GLOBALS["URLBASE"];    // gestita ad hoc: aggiungere in config l'eventuale ~nomeutente concatenandola se in public_html
        return str_replace($url_base, "", $url);
    }
}