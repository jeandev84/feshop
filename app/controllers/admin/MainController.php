<?php
namespace app\controllers\admin;


use R;

/**
 * Class MainController
 *
 * @package app\controllers\admin
 */
class MainController extends AppController
{

    /**
     * Action Index
     *
     * @return void
     */
     public function indexAction()
     {
         $countNewOrders = R::count('order', "status = '0'");
         $countUsers = R::count('user');
         $countProducts = R::count('product');
         $countCategories = R::count('category');

         $this->setMeta('Панель управления');
         $this->set(compact('countNewOrders', 'countCategories', 'countProducts', 'countUsers'));
     }
}