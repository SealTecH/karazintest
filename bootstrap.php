<?php
include('./vendor/autoload.php');
/**
 * Autoloader
 * @param $className
 * @return bool
 */
function _autoload($className)
{
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    if (file_exists($className . '.php')) {
        require_once $className . '.php';
        return true;
    }
    return false;
}

spl_autoload_register('_autoload');

/**
 * Class Bootstrap
 * Application entry point
 */
class Bootstrap
{
    /**
     * Bootstrap's static instance of Bootstrap class
     * @var Bootstrap
     */
    private static $self;

    /**
     * Router
     * @var AltoRouter
     */
    private $router;
    /**
     * Template engine
     * @var Smarty
     */
    private $smarty;
    /**
     * Array of routes
     * @var array|bool
     */
    private $route;
    /**
     * Current config
     * @var array
     */
    private $config;

    /**
     * Returns bootstrap instance
     * @return Bootstrap
     */
    public static function self()
    {
        return Bootstrap::$self;
    }

    /**
     * Returns current config
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns current route
     * @return array|bool
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Returns template engine
     * @return Smarty
     */
    public function getTE()
    {
        return $this->smarty;
    }

    /**
     * System initializer
     * @throws Exception
     */
    public function __construct()
    {
        Bootstrap::$self = &$this;
        //try to load configs
        include('./config/main.php');
        $this->config = $config;
        unset($config);
        $this->load_plugin('config_loaded');
        //ORM configuration
        ORM::configure($this->config['orm']['connection_string']);
        ORM::configure('username', $this->config['orm']['username'] . '');
        if (!empty($this->config['orm']['password'])) {
            ORM::configure('password', $this->config['orm']['password']);
        }
        //smarty configuration
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($this->config['smarty']['tpl_dir']);
        $this->smarty->setCompileDir($this->config['smarty']['compile_dir']);
        $this->smarty->setConfigDir($this->config['smarty']['config_dir']);
        $this->smarty->setCacheDir($this->config['smarty']['cache_dir']);
        foreach ($this->config['smarty'] as $name => $value) {
            $this->smarty->assign($name, $value);
        }
        //router configuration
        $this->router = new AltoRouter(array(), $this->config['www']['basePath']);
        $this->map_controllers();
        $this->route = $this->router->match();
        if ($this->route) {
            //call_user_func_array($this->route['target'], $this->route['params']);
            list($controller, $method) = $this->route['target'];
            $controller = new $controller();
            $this->load_plugin('controller_loaded', array(&$controller));
            call_user_func_array(array($controller, $method), $this->route['params']);
        } else {
            header('Location: http://' . $this->config['www']['basePath']);
            return;
        }
    }

    /**
     * Adds routers from controllers to router
     * @throws Exception
     */
    private function map_controllers()
    {
        foreach ($this->config['controller'] as $controller) {
            /**
             * @var \Sys\GenericController $classname
             */
            $classname = '\\controller\\' . $controller;
            $manifest = $classname::getManifest();
            $this->router->addRoutes($manifest->route);
        }
    }

    /**
     * Grants right to a plugin
     * @param \Sys\GenericPlugin $obj
     * @param String $kind
     */
    private function grant_right(&$obj, $kind)
    {
        switch ($kind) {
            case 'templateEngineAccess':
                $obj->template_engine = &$this->getTE();
                break;
            case 'configsRead':
                $obj->configs = $this->config;
                break;
            case 'configsReadWrite':
                $obj->configs = &$this->config;
                break;
            case 'bootstrapAccess':
                $obj->bootstrap = &$this;
                break;
        }
    }

    /**
     * Loads plugin, registered for an action
     * @param String $action
     * @param null|Object $params
     * @return array|null
     * @throws Exception
     */
    function load_plugin($action, $params = null)
    {
        $output = array();
        if (!isset($this->config['plugin'][$action]) || empty($this->config['plugin'][$action])) {
            return null;
        }
        foreach ($this->config['plugin'][$action] as $pluginName => $pluginRecord) {
            $filename = $this->config['sys']['plugin_dir'] . $pluginName . '.plugin.php';
            if (!file_exists($filename)) {
                throw new Exception("Plugin file not found while loading $filename");
            }
            $pluginName = '\\plugin\\' . $pluginName;
            if (!class_exists($pluginName)) {
                include($filename);
            }
            if (!class_exists($pluginName)) {
                throw new Exception("Class [$pluginName] not found while loading $filename");
            }
            $plugin = new $pluginName();
            if (isset($pluginRecord['config']) && method_exists($plugin, 'set_config')) {
                call_user_func(array($plugin, 'set_config'), $pluginRecord['config']);
            }
            foreach ($pluginRecord['right'] as $row) {
                $this->grant_right($plugin, (string)$row);
            }
            if (method_exists($plugin, '__initialized')) {
                call_user_func(array($plugin, '__initialized'));
            }
            $params = is_null($params) ? array() : $params;
            $output[] = call_user_func_array(array($plugin, 'execute_' . $action), $params);
        }
        return $output;
    }

} 