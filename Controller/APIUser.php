<?php
/**
 * User API
 * Allows users to register, edit profiles and so on
 */
namespace Controller;

use Bootstrap;
use Model\User;
use sys\ControllerManifest;
use sys\GenericController;
use Sys\REST;
use view\View;

class APIUserControllerManifest extends ControllerManifest
{
    public $name = "User API";
    public $author = "Sergiy Lilikovych";
    public $version = "10.02.2015/02:50";
    public $route;

    public function __construct()
    {
        $this->route = array(
            array('POST', '/api/user/login', array('Controller\APIUser', 'login')),
            array('POST', '/api/user/logout', array('Controller\APIUser', 'logout')),
            array('POST', '/api/user/update', array('Controller\APIUser', 'update')),
            array('POST', '/api/user/signup', array('Controller\APIUser', 'register')),
            array('POST', '/api/user/[i:id]/info', array('Controller\APIUser', 'info')),
            array('GET', '/api/user/activate/[i:id]/[:hash]', array('Controller\APIUser', 'activate')),
            array('GET', '/api/user/reset', array('Controller\APIUser', 'resetpass')),
            array('GET', '/api/user/__token/[i:id]', array('Controller\APIUser', '__token')),//TODO: not for produnction!
        );
    }
}

class APIUser extends GenericController
{

    private $mUser;

    public static function getManifest()
    {
        return new APIUserControllerManifest();
    }

    public function __construct()
    {
        parent::__construct();
        $this->mUser = new User();
    }

    private function getUserInfo($id = null)
    {
        if (is_null($id)) {
            $id = $this->mUser->getCurrentId();
            $user = $this->mUser->getById($id);
            $currentUser = &$user;
            $currentId = &$id;
        } else {
            $user = $this->mUser->getById($id);
            $currentId = $this->mUser->getCurrentId();
            $currentUser = $this->mUser->getById($currentId);
        }

        $baseInfo = array(
            'id' => $user->id,
            'level' => $user->level,
            'name' => $user->name
        );

        if ($currentUser->level < $user->level) {
            return $baseInfo;
        }

        $extendedInfo = array(
            'surname' => $user->surname,
            'lastname' => $user->lastname,
            'comment' => $user->comment,
            'email' => $user->email,
            'phone' => $user->phone
        );

        return array_merge($baseInfo, $extendedInfo);

    }

    public function info($id = null)
    {
        REST::response($this->getUserInfo($id));
    }

    public function login()
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            REST::error(500, 'email and password POST parameters are required');
        }
        $obj = $this->mUser->authorize($_POST['email'], $_POST['password']);
        if ($obj === false) {
            REST::error();
            return;
        }
        REST::success('', $obj->as_array());
    }

    public function logout()
    {
        $_SESSION['UID'] = null;
        session_destroy();
        REST::success();
    }

    public function register()
    {
        $needed = array('password', 'name', 'email');
        $optional = array('surname', 'comment', 'phone', 'lastname');
        foreach ($needed as $i => $name) {
            if (!isset($_POST[$name])) {
                REST::error(500, implode(',', $needed) . ' parameters are required');
                return;
            }
            $needed[$name] = $_POST[$name];
            unset($needed[$i]);
        }
        if (!filter_var($needed['email'], FILTER_VALIDATE_EMAIL) || strlen($needed['password']) < 6) {
            REST::error(501, 'E-mail is invalid or password is too short');
            return;
        }
        foreach ($optional as $i => $name) {
            $optional[$name] = $_POST[$name];
            unset($optional[$i]);
        }
        $needed['email'] = strtolower($needed['email']);
        $params = array_merge($needed, $optional);
        $user = $this->mUser->register($params);
        if (is_object($user)) {
            REST::success('', $this->getUserInfo($user->id));
        } else {
            REST::error(503);
            return;
        }

        $view = new View();
        $view->te()->assign('user', $user->as_array());
        $view->te()->assign('hash', $this->mUser->getActivationToken($user->id));
        $html = $view->te()->fetch('email.confirm.tpl');
        $this->mUser->email($user->id, "Registration confirmation", $html);
    }

    public function update()
    {
        $optional = array('surname', 'password', 'name', 'email', 'isActive');
        foreach ($optional as $i => $name) {
            unset($optional[$i]);
            if (!isset($_POST[$name])) {
                unset($optional[$i]);
                continue;
            }
            $optional[$name] = $_POST[$name];
            unset($optional[$i]);
        }
        if (empty($optional['password'])) {
            unset($optional['password']);
        }
        if (empty($optional)) {
            REST::success();
            return;
        }

        if (isset($optional['email']) && !filter_var($optional['email'], FILTER_VALIDATE_EMAIL)) {
            REST::error(501);
            return;
        } else {
            $optional['email'] = strtolower($optional['email']);
        }

        if (isset($optional['password'])) {
            if (strlen($optional['password']) < 6) {
                REST::error(501);
                return;
            } else {
                $optional['password'] = md5($optional['password']);
            }
        }

        $user = $this->mUser->getById($this->mUser->getCurrentId());
        foreach ($optional as $key => $val) {
            $user->set($key, $val);
        }
        $user->save();
        REST::success('', $user);
    }

    public function activate($uid, $hash)
    {
        $this->mUser->activation($uid, strtolower($hash));
        header('Location: /');
    }

    public function resetpass()
    {
        if (!isset($_GET['email'])) {
            return;
        }
        $email = $_GET['email'];
        $user = $this->mUser->findByEmail($email);
        if ($user === false) {
            return;
        }
        $newpass = substr(md5(time()), 0, 8);
        $user->password = md5($newpass);
        if ($user->save()) {
            $view = new View();
            $view->te()->assign('user', $user->as_array());
            $view->te()->assign('password', $newpass);
            $html = $view->te()->fetch('email.password-reset.tpl');
            $this->mUser->email($user->id, "Password reset", $html);
        }
        header('Location: /');
    }

    public function __token($uid)
    {
        $token = $this->mUser->getActivationToken($uid);
        if ($token === false) {
            REST::error();
            return;
        }
        REST::success('NOT for produnction API', array('token' => $token));
    }
}