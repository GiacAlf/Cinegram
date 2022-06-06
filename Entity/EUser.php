<?php

abstract class EUser {

    protected String $username;
    protected string $ioSono;


    public function getUsername(): string {
        return $this->username;
    }


    public abstract function chiSei(): string;
}