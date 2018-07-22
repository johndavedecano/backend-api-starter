<?php namespace App\Services;

interface AuthServiceInterface
{

    public function logout();

    public function login($email, $pasword);

    public function forgot($email);

    public function reset($credentials = []);

    public function register($credentials = []);

    public function activate($token);

    public function resetEmail($email);

    public function activateEmail($token);

    public function getCurrentUser();

    public function refreshToken();
}
