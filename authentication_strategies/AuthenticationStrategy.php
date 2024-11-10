<?php

interface AuthenticationStrategy{
    public function authenticate(string $emailOrUsername, string $password): string;
}