<?php
namespace app\controllers;



use Framework\App;

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

         $this->setMeta('Главная страница', 'Описание', 'Ключевики');

         $meta = 'ddddkle';
         $title = 'ddd';

         $this->set(compact('meta', 'title'));

     }
}