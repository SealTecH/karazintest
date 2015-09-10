<?php
/**
 * Common manifest for Controllers.
 * Read info in IMainfest.php
 */

namespace sys;


abstract class ControllerManifest
{
    public $name;
    public $version;
    public $author;
    public $route;
    public $minUserLevel;
} 