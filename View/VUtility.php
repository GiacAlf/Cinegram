<?php

class VUtility {

    public static function getRootDir(): ?string {
        return $GLOBALS['URLBASE'];
    }

    public static function getUserNavBar(): string {
        return SessionHelper::UserNavBar();
    }
}