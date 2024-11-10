<?php
require_once "AuthenticationStrategy.php";

class AuthenticationContext{
    private $strategy;

    public function setStrategy(AuthenticationStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function authenticate($emailOrUsername, $password) {
        return $this->strategy->authenticate($emailOrUsername, $password);
    }
}