<?php
namespace sys;

use Bootstrap;
use Smarty;

/**
 * Generic plugin class.
 * Parent for all plugins
 */
abstract class GenericPlugin implements IManifest
{
    /**
     * @var Smarty
     */
    public $template_engine;
    /**
     * @var Array
     */
    public $configs;
    /**
     * @var Bootstrap
     */
    public $bootstrap;

    public abstract function set_config($config);


}