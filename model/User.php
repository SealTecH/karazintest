<?php
namespace Model;


use Bootstrap;
use ORM;
use sys\GenericModel;
use sys\IManifest;
use sys\ModelManifest;

class UserModelManifest extends ModelManifest
{
    public $name = "User";
    public $author = "Sergiy Lilikovych";
    public $version = "05.02.2015/21:35";
    public $table = 'User';
}

/**
 * User model
 * Provides User data manipulation API
 * @package Model
 */
class User extends GenericModel
{
    protected $_table;

    public static function getManifest()
    {
        $manifest = new UserModelManifest();
        return $manifest;
    }

    public function __construct()
    {
        $this->_table = User::getManifest()->table;
    }

    /**
     * Resurns User object by it's ID
     * @param int $id
     * @return bool|ORM
     */
    public function getById($id)
    {
        return ORM::for_table($this->_table)->where('id', intval($id))->find_one();
    }

    /**
     * Activates user using token
     * @param int $id
     * @param string $token
     * @return bool
     */
    public function activation($id, $token)
    {
        $user = $this->getById($id);
        $targetToken = $this->getActivationToken($id);
        if ($token !== $targetToken) {
            return false;
        }
        $user->isActive = true;
        $user->save();
        return true;
    }

    /**
     * Returns user activation token.
     * It is bicycle-like, because we are not using random numbers.
     * @param int $id
     * @return string
     */
    public function getActivationToken($id)
    {
        $user = $this->getById($id);
        return md5(strtolower($user->name . $user->surname . $user->email . '-salt'));
    }

    /**
     * Checks user's authorization
     * @param int $needLevel
     * @param null $id
     * @return bool
     */
    public function isAuthorized($needLevel = 0, $id = null)
    {
        if (!isset($_SESSION['UID'])) {
            return false;
        }
        $user = $this->getById($_SESSION['UID']);
        if ($user->level < $needLevel) {
            return false;
        }
        if (!is_null($id) && $_SESSION['UID'] !== $id) {
            return false;
        }
        return true;
    }

    /**
     * Returns current user ID
     * @return bool|int
     */
    public function getCurrentId()
    {
        if ($this->isAuthorized()) {
            return intval($_SESSION['UID']);///TODO
        }
        return false;
    }

    /**
     * Authorizes user
     * @param string $login
     * @param string $password
     * @return bool|ORM
     */
    public function authorize($login, $password)
    {
        $user = ORM::for_table($this->_table)
            ->where('password', md5($password))
            ->where('email', strtolower($login))
            ->find_one();
        if (!is_object($user) || !$user->isActive) {
            return false;
        }
        $_SESSION['UID'] = $user->id;
        return $user;
    }

    /**
     * Creates new user
     * @param array $data
     * @return bool|ORM
     */
    public function register($data)
    {
        $data['password'] = md5($data['password']);
        //ORM::get_db()->beginTransaction();
        try {
            $user = ORM::for_table($this->_table)
                ->create($data)
                ->save();
            if ($user === false) {
                throw new \Exception();
            }
            $user = ORM::for_table($this->_table)
                ->where('email', $data['email'])
                ->where('password', $data['password'])
                ->find_one();
        } catch (\Exception $e) {
            ORM::get_db()->rollBack();
            return false;
        }
        //if(ORM::get_db()->commit()){
        return $user;
        //}
    }

    /**
     * Returns user by it's e-mail
     * @param string $email
     * @return bool|ORM
     */
    public function findByEmail($email)
    {
        return ORM::for_table($this->_table)->where('email', $email)->find_one();
    }

    /**
     * Returns all users
     * @return array
     */
    public function getUsers()
    {
        return ORM::for_table($this->_table)->find_array();
    }

    /**
     * Sends e-mail to the User by it's ID
     * @param int $to
     * @param string $subj
     * @param string $text
     * @return bool
     */
    public function email($to, $subj, $text)
    {
        $user = $this->getById($to);
        if ($user === false) {
            return false;
        }
        $headers = "From: " . strip_tags(Bootstrap::self()->getConfig()['www']['email']) . "\r\n";
        $headers .= "Reply-To: " . strip_tags(Bootstrap::self()->getConfig()['www']['email']) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($user->email, $subj, $text, $headers);
    }
}