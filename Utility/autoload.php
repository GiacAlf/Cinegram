<?php

function autoload($className) {

    $firstLetter = $className[0];
    $fileName = '';
    switch ($firstLetter) {
        case 'E':
            $fileName = ('Entity/' . $className . '.php');
            break;

        case 'F':
            $fileName = ('Foundation/' . $className . '.php');
            break;

        case 'V':
            $fileName = ('View/' . $className . '.php');
            break;

        case 'C':
            $fileName = ('Controller/' . $className . '.php');
            break;
    }

    if (file_exists($fileName) && is_readable($fileName)) {
        include($fileName);
    }
}
spl_autoload_register("autoload");