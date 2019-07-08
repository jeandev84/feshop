<?php
namespace app\controllers;



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
     * @return void
     */
     public function indexAction()
     {
          debug($this->route);

          $this->setMeta('Главная', 'Описание', 'Ключевики');

          // debug($this->meta);
     }
}