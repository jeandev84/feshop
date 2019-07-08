<?php
namespace app\controllers;



use Framework\App;
use Framework\Library\Cache;
use R;

/**
 * Class MainController
 *
 * @package app\controllers
 */
class MainController extends AppController
{


    /**
     * Action index
     *
     *  Ex:
     *  $this->setMeta('Главная страница', 'Описание', 'Ключевики');
     *  $this->setMeta(App::$app->get('shop_name'), 'Описание', 'Ключевики');
     *
     * @return void
     */
     public function indexAction()
     {
         // set meta
         $this->setMeta('Главная страница', 'Описание', 'Ключевики');
     }
}