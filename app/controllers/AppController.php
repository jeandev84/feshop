<?php
namespace app\controllers;


use app\models\AppModel;
use app\widgets\currency\Currency;
use Framework\App;
use Framework\Library\Cache;
use Framework\Routing\Controller;
use R;


/**
 * Class AppController
 *
 * @package app\controllers
 */
class AppController extends Controller
{

    /**
     * AppController constructor.
     *
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);

        // Get connection
        new AppModel();

        // Add all currencies in registry
        App::$app->set('currencies', Currency::getCurrencies());

        // Add currency in registry
        App::$app->set('currency', Currency::getCurrency(App::$app->get('currencies')));


        // Add categories data in registry
        App::$app->set('categories', self::cacheCategory());



        /* debug(App::$app->properties()); */

    }


    /**
     * Cache category
     *
     * @return array
     */
    protected static function cacheCategory()
    {
        // Get instance of cache
        $cache = Cache::instance();

        // Firstly we'll  try to get categories data from cache
        $categories = $cache->get('categories');

        // If hasn't data categories from cache
        if(!$categories)
        {
            // we'll get them from database
            $categories = R::getAssoc("SELECT * FROM category");

            // And we'll add in cache
            $cache->set('categories', $categories);
        }

        // Get categories
        return $categories;
    }
}