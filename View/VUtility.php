<?php

class VUtility
{
    public static function getRootDir(): ?string{
        $root_dir = $_SERVER['HTTP_HOST'];
        return $root_dir;
    }

    public static function getUserNavBar(): string {
        $user = SessionHelper::UserNavBar();
        return $user;
    }

}