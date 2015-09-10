<?php
/**
 * Admin controller
 * Administration features
 */
namespace Controller;

use Bootstrap;
use DM\AjaxCom\Handler;
use Model\Banner;
use Model\User;
use sys\ControllerManifest;
use sys\GenericController;
use Sys\REST;
use view\View;

class AdminControllerManifest extends ControllerManifest
{
    public $name = "Admin";
    public $author = "Sergiy Lilikovych";
    public $version = "19.02.2015/03:15";
    public $route;

    public function __construct()
    {
        $this->route = array(
            array('GET', '/admin', array('Controller\Admin', 'index')),
            array('POST', '/admin/user/[i:uid]/update', array('Controller\Admin', 'update')),
        );
    }
}

class Admin extends GenericController
{

    private $mUser;
    private $mBanner;
    private $view;

    public static function getManifest()
    {
        return new AdminControllerManifest();
    }

    public function __construct()
    {
        parent::__construct();
        $this->mUser = new User();
        $this->mBanner = new Banner();
        $this->view = new View();
    }

    public function index()
    {
        $this->view->te()->assign('users', $this->mUser->getUsers());
        $this->view->te()->assign('banners', $this->mBanner->getBanners());
        $this->view->te()->assign('common', $this->mBanner->getCommonConfigs());
        $this->view->te()->display('admin.tpl');
    }

    public function update($uid)
    {
        $user = $this->mUser->getById($uid);
        if ($user === false) {
            REST::error();
            return;
        }
        $fields = array('name', 'surname', 'email', 'isActive', 'password', 'level');
        foreach ($fields as $key) {
            if (!isset($_POST[$key])) continue;
            if (empty($_POST[$key])) continue;
            if ($key == 'password') $_POST[$key] = md5($_POST[$key]);
            if ($key == 'isActive') $_POST[$key] = filter_var($_POST[$key], FILTER_VALIDATE_BOOLEAN);
            $user->$key = $_POST[$key];
        }
        if ($user->save()) {
            REST::success();
            return;
        }

        REST::error();
    }

}