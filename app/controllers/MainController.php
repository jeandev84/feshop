<?php
namespace app\controllers;



use Framework\App;
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
         // get posts and post
         $posts = \R::findAll('test');
         $post  = R::findOne('test', 'id = ?', [2]);

         // debug($posts);

         $this->setMeta('Главная страница', 'Описание', 'Ключевики');

         $this->set(compact('posts'));

     }
}