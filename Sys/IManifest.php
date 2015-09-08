<?php
/**
 * Manifest interface
 * For system purposes (just like enumerating components or getting component info)
 * every model, view, controller and plugin must have it's own IMainfest implementation.
 */

namespace Sys;


interface IManifest
{
    public static function getManifest();
} 