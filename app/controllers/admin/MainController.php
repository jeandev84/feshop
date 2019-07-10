<?php
namespace app\controllers\admin;


use R;

/**
 * Class MainController [ Dashboard ]
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
         // получаем количество все необработные заказы
         $countNewOrders = R::count('order', "status = '0'");

         // получаем количество зарегистрированые пользователи
         $countUsers = R::count('user');

         // получаем количество все товаров
         $countProducts = R::count('product');

         // получаем количество категории
         $countCategories = R::count('category');

         // set meta
         $this->setMeta('Панель управления');

         // передаем все переменные в вид для пополнения наших виджетов
         $this->set(compact('countNewOrders', 'countCategories', 'countProducts', 'countUsers'));
     }
}