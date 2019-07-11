<?php
namespace app\controllers\admin;


use Framework\Library\Pagination;
use R;
use Exception;



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


    /**
     * Action view
     *
     *
     * @throws \Exception
     */
     public function viewAction()
     {
        $order_id = $this->getRequestID();

        $order = R::getRow(
                 "SELECT `order`.*, `user`.`name`, ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
                      FROM `order`
                      JOIN `user` ON `order`.`user_id` = `user`.`id`
                      JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
                      WHERE `order`.`id` = ?
                      GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id` LIMIT 1", [$order_id]);
        if(!$order)
        {
            throw new \Exception('Страница не найдена', 404);
        }

        $order_products = \R::findAll('order_product', "order_id = ?", [$order_id]);
        $this->setMeta("Заказ №{$order_id}");
        $this->set(compact('order', 'order_products'));
    }


    /**
     * Action change
     *
     *
     * @throws Exception
     */
    public function changeAction()
    {
        $order_id = $this->getRequestID();
        $status = !empty($_GET['status']) ? '1' : '0';
        $order = R::load('order', $order_id);

        if(!$order)
        {
            throw new \Exception('Страница не найдена', 404);
        }
        $order->status = $status;
        $order->update_at = date("Y-m-d H:i:s");
        R::store($order);
        $_SESSION['success'] = 'Изменения сохранены';
        redirect();
    }


    /**
     * Action delete
     *
     *
     * @throws Exception
     */
    public function deleteAction()
    {
        $order_id = $this->getRequestID();
        $order = R::load('order', $order_id);
        R::trash($order);
        $_SESSION['success'] = 'Заказ удален';
        redirect(ADMIN . '/order');
    }
}