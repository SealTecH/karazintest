<?php
namespace Model;


use Bootstrap;
use ORM;
use PDO;
use Sys\GenericModel;
use sys\IManifest;
use sys\ModelManifest;

class BannerModelManifest extends ModelManifest
{
    public $name = "Banner";
    public $author = "Sergiy Lilikovych";
    public $version = "09.09.2015/17:09";
    public $table = 'rangedbanners';//it's a view. Source table is 'banner'
}

/**
 * Banner model
 * Provides banner data manipulation API
 * @package Model
 */
class Banner extends GenericModel
{
    protected $_table;

    public static function getManifest()
    {
        $manifest = new BannerModelManifest();
        return $manifest;
    }

    public function __construct()
    {
        $this->_table = Banner::getManifest()->table;
    }

    /**
     * Returns Banner object by its ID
     * @param int $id
     * @return bool|ORM
     */
    public function getById($id)
    {
        return ORM::for_table('banner')->where('id', intval($id))->find_one();
    }

    /**
     * Returns number of active banners
     * @return int
     */
    public function getActiveCount()
    {
        return ORM::for_table('banner')
            ->where('active', true)
            ->count();
    }

    /**
     * Returns an array of random Banner objects
     * This function uses banner priority
     * @prarm int $count
     * @return array
     */
    public function getRandomUsingPriority($count)
    {
        //I am using transaction, which rolls back always
        //because we need temporary disable already selected
        //banners (to avoid banner repeats).
        //I decided to do that, because I wanted to keep
        //selection procedure in the RDBMS (due to possible
        //high loading, which may be produced by loading
        //ALL banner data on the web-server side).
        //I'd recommend to move DB from MySQL to PostgreSQL
        //and use something like PL/SQL or PL/Py.
        $banners = array();
        ORM::get_db()->beginTransaction();
        for ($i = 0; $i < $count; $i++) {
            $bannerId = ORM::get_db()
                ->query('CALL getNewBannerId()')
                ->fetch(PDO::FETCH_ASSOC)['id'];
            $bannerObj = ORM::for_table('banner')
                ->find_one($bannerId);
            $bannerObj->active = 0;
            $bannerObj->save();
            $banners[] = $bannerObj;
        }
        ORM::get_db()->rollBack();
        return $banners;
    }

    public function getBanners()
    {
        return ORM::for_table('banner')->find_array();
    }

    public function newBanner($hint, $active = false, $priority = 1, $text = "", $href = "")
    {
        $obj = ORM::for_table('banner')->create();
        $obj->hint = $hint;
        $obj->active = $active;
        $obj->priority = $priority;
        $obj->text = $text;
        $obj->href = $href;
        $obj->save();
        return $obj;
    }

    public function removeBannerFile($banner)
    {
        @unlink(Bootstrap::self()->getConfig()['www']['banners'] . $banner->filename);
        $banner->filename = "";
        return $banner->save();
    }

}