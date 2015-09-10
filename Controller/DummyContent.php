<?php
/**
 * DummyContent controller
 * Shows page with fake content
 */

namespace Controller;

use Model\User;
use sys\ControllerManifest;
use sys\GenericController;
use view\View;

class DummyContentControllerManifest extends ControllerManifest
{
    public $name = "DummyContent";
    public $author = "Sergiy Lilikovych";
    public $version = "08.09.2015/11:06";
    public $route;

    public function __construct()
    {
        $this->route = array(
            array('GET', '/content/[i:id]', array('Controller\DummyContent', 'content'))
        );
    }
}

class DummyContent extends GenericController
{
    public static function getManifest()
    {
        return new DummyContentControllerManifest();
    }

    public function content($numParam = 0)
    {
        $dcView = new View();
        $dcView->te()->assign('numParam', $numParam);
        $dcView->te()->display('dummy.tpl');
    }

}