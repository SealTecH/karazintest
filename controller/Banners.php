<?php
/**
 * Banners controller
 */

namespace controller;

use model\Banner;
use model\User;
use sys\ControllerManifest;
use sys\GenericController;
use sys\REST;
use view\View;

class BannersControllerManifest extends ControllerManifest
{
    public $name = "Banners";
    public $author = "Sergiy Lilikovych";
    public $version = "08.09.2015/10:51";
    public $route;

    public function __construct()
    {
        $this->route = array(
            array('GET', '/', array('Controller\Banners', 'index')),
            array('GET', '/banners/errorLoadImage', array('Controller\Banners', 'errorLoadImage')),
            array('POST', '/banners/api/[i:id]/update', array('Controller\Banners', 'apiUpdate')),
            array('POST', '/banners/api/create', array('Controller\Banners', 'apiCreate')),
            array('POST', '/banners/api/[i:id]/delete', array('Controller\Banners', 'apiDelete')),
            array('POST', '/banners/api/[i:id]/set-image', array('Controller\Banners', 'apiSetImage')),
        );
    }
}

class Banners extends GenericController
{

    /**
     * Banner model
     * @var Banner
     */
    private $mBanner;

    public static function getManifest()
    {
        return new BannersControllerManifest();
    }

    public function __construct()
    {
        parent::__construct();
        $this->mBanner = new Banner();
    }

    public function index()
    {
        $bannersView = new View();
        //display all active banners using their priority
        $bannersView->te()->assign('banners', $this->mBanner->getRandomUsingPriority(
            $this->mBanner->getActiveCount()
        ));
        $bannersView->te()->display('banners.tpl');
    }

    /**
     * Shows error information page
     */
    public function errorLoadImage()
    {
        $bannersView = new View();
        $bannersView->te()->display('error.load_image.tpl');
    }

    /**
     * Creates new banner entry.
     * Banner will be created with default parameters
     * or with settings, which were passed via POST.
     * Entry will be created without image file,
     * it can be attached using apiSetImage
     */
    public function apiCreate()
    {
        $banner = $this->mBanner->newBanner(
            $_POST['hint'],
            filter_var($_POST['active'], FILTER_VALIDATE_BOOLEAN),
            intval($_POST['priority']),
            $_POST['text'],
            $_POST['link']);
        if (!is_null($banner) && $banner !== false) {
            REST::success();
            return;
        }
        REST::error();
    }

    /**
     * Update banner record works just like creating new banner
     * using apiCreate.
     * @param int $id
     */
    public function apiUpdate($id)
    {
        $rows = array('hint' => 'hint', 'active' => 'active', 'link' => 'href', 'priority' => 'priority', 'text' => 'text');
        $obj = $this->mBanner->getById($id);
        if (is_null($obj) || $obj === false) {
            REST::error();
            return;
        }
        foreach ($rows as $row => $dbrow) {
            if (!isset($_POST[$row]))
                continue;
            if ($row == 'active') {
                $_POST['active'] = filter_var($_POST['active'], FILTER_VALIDATE_BOOLEAN);
            }
            if ($row == 'priority') {
                $_POST['priority'] = intval($_POST['priority']);
            }

            $obj->set($dbrow, $_POST[$row]);
        }
        if ($obj->save()) {
            REST::success();
            return;
        }
        REST::error();
    }

    /**
     * Delete banner.
     * @param int $id
     */
    public function apiDelete($id)
    {
        $obj = $this->mBanner->getById($id);
        if (is_null($obj) || $obj === false) {
            REST::error();
            return;
        }
        if ($this->mBanner->removeBannerFile($obj) && $obj->delete()) {
            REST::success();
            return;
        }

        REST::error();
    }

    /**
     * Set banner image
     * @param $id
     */
    public function apiSetImage($id)
    {
        $banner = $this->mBanner->getById($id);
        list($width, $height, $type, $attr) = getimagesize($_FILES['imagefile']['tmp_name']);
        if (is_null($width) OR is_null($height) OR $width !== 250 OR $height !== 50 OR is_null($banner)) {//size checking here
            echo('<script>location.href = "/banners/errorLoadImage"</script>');//TODO: bicycle :)
        } else {
            $targetFile = \Bootstrap::self()->getConfig()['www']['banners'] . strval($banner->id) . '_' . basename($_FILES['imagefile']['name']);
            move_uploaded_file($_FILES['imagefile']['tmp_name'], $targetFile);
            $this->mBanner->removeBannerFile($banner);//remove old file
            $banner->filename = basename($targetFile);
            $banner->save();
            echo('<script>window.close();</script>');//TODO: bicycle :)
        }
    }

}