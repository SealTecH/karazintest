<?php
namespace plugin;

use model\User;
use sys\GenericPlugin;
use sys\GenericController;
use sys\IManifest;
use sys\PluginManifest;

class ForceLoginPluginManifest extends PluginManifest
{
    public $name = "ForceLogin";
    public $version = "05.02.2015/21:40";
    public $author = "Sergiy Lilikovych";

}

/**
 * Class ForceLogin
 * Forces user log-in for certain controllers
 * @package Plugin
 */
class ForceLogin extends GenericPlugin
{

    /**
     * @var Array current configuration
     */
    private $config;

    public static function getManifest()
    {
        return new ForceLoginPluginManifest();
    }

    /**
     * onLoad action
     * @param GenericController $controller
     */
    public function execute_controller_loaded($controller)
    {
        $mUser = new User();
        $controllerName = end(explode('\\', get_class($controller)));
        $minLevel = $controller::getManifest()->minUserLevel;
        $isAuthorized = $mUser->isAuthorized($minLevel);
        $this->template_engine->assign('isAuthorized', $isAuthorized);
        $this->template_engine->assign('controller', $controllerName);
        if (in_array($controllerName, $this->config['controllers']) && !$isAuthorized) {
            header('Location: /' . $this->config['redirect']);
        }
    }

    public function set_config($config)
    {
        $this->config = $config;
    }
}