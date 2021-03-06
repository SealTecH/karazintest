<?php
/**
 * Main configuration file
 */
//system configs
$config['sys']['plugin_dir'] = './plugin/';
//ORM configs
$config['orm']['connection_string'] = 'mysql:host=localhost;dbname=karazin';
$config['orm']['username'] = 'root';
$config['orm']['password'] = '';
//WWW settings
$config['www']['base_path'] = 'http://karazin';
$config['www']['email'] = 'admin@localhost';
$config['www']['banners'] = './data/images/banners/';
//template engine
$config['smarty'] = array(
    'tpl_dir' => './data/tpl/',
    'compile_dir' => './data/tpl/compiled/',
    'cache_dir' => './data/tpl/cache/',
    'config_dir' => '',
    'css' => '/data/css/',
    'images' => '/data/images/',
    'js' => '/data/js/',
    'fonts' => '/data/fonts/',
    'baseURL' => 'http://karazin');
//the list of controllers
$config['controller'] = array('Login', 'Banners', 'DummyContent', 'APIUser', 'Admin');
//plugins by action
$config['plugin'] = array(
    'controller_loaded' => array(
        'ForceLogin' => array(
            'right' => array('configsRead', 'templateEngineAccess', 'bootstrapAccess'),
            'config' => array('controllers' => array('Admin'), 'redirect' => 'login'),
        ),
    ),
);