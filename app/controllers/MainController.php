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

         // Get 3 firsts brands
         $brands = R::find('brand', 'LIMIT 3');


         // set meta
         $this->setMeta('Главная страница', 'Описание', 'Ключевики');


         // parse data to view
         $this->set(compact('brands'));
     }
}