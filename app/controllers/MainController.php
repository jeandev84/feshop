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
         // get posts and post
         $posts = \R::findAll('test'); # debug($posts);
         $post  = R::findOne('test', 'id = ?', [2]);


         // set meta
         $this->setMeta('Главная страница', 'Описание', 'Ключевики');

         // caching data
         $cache = Cache::instance();
         // $cache->set('posts', $posts);
         $cache->delete('posts');
         $data = $cache->get('posts'); // debug($data);
         if(!$data)
         {
             $cache->set('posts', $posts);
         }

         // parse data to view
         $this->set(compact('posts'));

     }
}