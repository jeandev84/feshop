<?php
namespace app\controllers\admin;


use Framework\Library\Pagination;
use R;


/**
 * Class OrderController
 *
 * @package app\controllers\admin
 */
class OrderController extends AppController
{

    /**
     * Action index
     *
     * @return void
     */
     public function indexAction()
     {
         // Pagination
         $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
         $perpage = 3;
         $count = R::count('order');
         $pagination = new Pagination($page, $perpage, $count);
         $start = $pagination->getStart();

         // Get all orders by joins
         $orders = R::getAll(
             "SELECT 
                      `order`.`id`, `order`.`user_id`, `order`.`status`, 
                      `order`.`date`, `order`.`update_at`, `order`.`currency`, `user`.`name`, 
                  ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
                  FROM `order`
                  JOIN `user` ON `order`.`user_id` = `user`.`id`
                  JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
                  GROUP BY `order`.`id` 
                  ORDER BY `order`.`status`, `order`.`id` LIMIT $start, $perpage");

         // set meta datas
         $this->setMeta('Список заказов');

         // parse variables to the view
         $this->set(compact('orders', 'pagination', 'count'));
     }
}