<?php
/**
 * Generic views class.
 * Parent for all views
 */

namespace sys;

use Smarty;

trait SmartyTE
{
    /**
     * Smarty TE getter
     * @return Smarty
     */
    public function te()
    {
        return \Bootstrap::self()->getTE();
    }
}


abstract class GenericView
{
    use SmartyTE; //every view has to use Smarty TE. We can simply switch TEs using traits

}