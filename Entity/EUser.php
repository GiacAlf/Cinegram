<?php

abstract class EUser {

    protected String $username;


    public function getUsername(): string {
        return $this->username;
    }


    public abstract function chiSei(): string;
}