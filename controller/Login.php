<?php
/**
 * Login controller
 * Shows login form or user profile
 */

namespace controller;

use model\User;
use sys\ControllerManifest;
use sys\GenericController;
use view\View;

class LoginControllerManifest extends ControllerManifest
{
    public $name = "Login";
    public $author = "Sergiy Lilikovych";
    public $version = "05.02.2015/21:27";
    public $route;

    public function __construct()
    {
        $this->route = array(
            array('GET', '/login', array('Controller\Login', 'index')),
        );
    }
}

class Login extends GenericController
{
    public static function getManifest()
    {
        return new LoginControllerManifest();
    }

    public function index()
    {
        $loginView = new View();
        $mUser = new User();
        if (!$mUser->isAuthorized()) {
            $loginView->te()->display('login.tpl');
            return;
        }
        $this->_redir_admin();
    }

    private function _redir_admin()
    {
        header('Location: /admin');
        return;
    }
}