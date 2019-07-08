<?php
namespace app\controllers;


use app\models\AppModel;
use app\widgets\currency\Currency;
use Framework\App;
use Framework\Routing\Controller;



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


    }
}