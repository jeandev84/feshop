<?php
namespace app\models;


use Framework\App;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


/**
 * Class Order
 *
 *  In This class , we can used transaction for execution 2
 *  queries with tables: order and order_product (table of ordered product)
 * @package app\models
 */
class Order extends AppModel
{

    /**
     * Save order [Commande] to the database
     *
     * @param $data
     * @return int|string
     */
    public static function saveOrder($data)
    {
        $order = \R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }


    /**
     * Save ordered Products [Produits commandes] in to database
     *
     * (int) afin que tout produit commande ayant pour product_id de type [1-2] cad avec ediffice ,
     *   retournera toujours la valeur superieure 1 par exemple
     *  Par exemple
     *  Si product_id = [2-5] on aura product_id = 2 a cause du typage (int) cela force la valeur a un entier
     *  Si product_id = 2 alors il sera retourne product_id = 2 (sans changement car le chiffre est deja un entier plein)
     *
     * @param $order_id
     * @return void
     */
    public static function saveOrderProduct($order_id)
    {
        $sql_part = '';
        foreach($_SESSION['cart'] as $product_id => $product){
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ','); // echo $sql_part
        \R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }


    /**
     * Mail order , send mail client and admin [ Send mail management ]
     *
     * @param $order_id
     * @param $user_email
     */
    public static function mailOrder($order_id, $user_email)
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport(
            App::$app->get('smtp_host'),
            App::$app->get('smtp_port'),
            App::$app->get('smtp_protocol'))
        )->setUsername(App::$app->get('smtp_login'))->setPassword(App::$app->get('smtp_password'));


        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        ob_start();
        require APP . '/views/mail/mail_order.php';
        $body = ob_get_clean();

        // Message to client
        $message_client = (new Swift_Message("Вы совершили заказ №{$order_id} на сайте " . App::$app->get('shop_name')))
            ->setFrom([App::$app->get('smtp_login') => App::$app->get('shop_name')])
            ->setTo($user_email)
            ->setBody($body, 'text/html');

        // Message to admin
        $message_admin = (new Swift_Message("Сделан заказ №{$order_id}"))
            ->setFrom([App::$app->get('smtp_login') => App::$app->get('shop_name')])
            ->setTo(App::$app->get('admin_email'))
            ->setBody($body, 'text/html');

        // Send the message
        $result = $mailer->send($message_client);
        $result = $mailer->send($message_admin);

        // on peut mettre une condition pour dire si message a ete envoye au client
        // et egalement a l'administrateur alors on void le panier
        /*
         * if($send_client && $send_admin)
         * {
         *      unset($_SESSION['cart']);
                unset($_SESSION['cart.qty']);
                unset($_SESSION['cart.sum']);
                unset($_SESSION['cart.currency']);
                $_SESSION['success'] = 'Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа';
         * }
         */
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $_SESSION['success'] = 'Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа';
    }

}