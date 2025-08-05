<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Two_FactorAuth
{
    public function __construct()
    {
        require_once APPPATH.'../vendor/autoload.php';
    }
    public function init()
    {
        return new \Google\Authenticator\GoogleAuthenticator();
    }
}