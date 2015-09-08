<?php
/**
 * Generic controller class.
 * Parent for all controllers
 */

namespace Sys;


abstract class GenericController implements IManifest
{

    public final function initialize()
    {
        //for system purposes
    }

    public function __construct()
    {
        $this->initialize();
    }

} 