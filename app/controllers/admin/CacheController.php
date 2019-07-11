<?php
namespace app\controllers\admin;


use Framework\Library\Cache;


/**
 * Class CacheController
 *
 * @package app\controllers\admin
 */
class CacheController extends AppController
{

    /**
     * Action Index
     *
     * @return void
     */
    public function indexAction()
    {
        $this->setMeta('Очистка кэша');
    }


    /**
     * Action Delete
     *
     * @return void
     */
    public function deleteAction()
    {
        $key = isset($_GET['key']) ? $_GET['key'] : null;
        $cache = Cache::instance();

        switch($key)
        {
            case 'category':
                $cache->delete('categories');
                $cache->delete('menu_cache'); // from widgets app\widgets\menu\Menu [ 'menu_cache' ]
                break;
            case 'filter':
                $cache->delete('filter_group');
                $cache->delete('filter_attrs');
                break;
        }
        $_SESSION['success'] = 'Выбранный кэш удален';
        redirect();
    }
}