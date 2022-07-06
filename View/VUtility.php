<?php

class VUtility
{
    public static function getRootDir(): ?string{
        $root_dir = $GLOBALS['URLBASE'];
        return $root_dir;
    }

    public static function getUserNavBar(): string {
        $user = SessionHelper::UserNavBar();
        return $user;
    }

}