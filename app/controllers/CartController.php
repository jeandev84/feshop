<?php
namespace app\controllers;



use app\models\Cart;
use app\models\Order;
use app\models\User;
use R;


/**
 * Class CartController
 *
 * @package app\controllers
 */
class CartController extends AppController
{

    /**
     *  Action Add
     *
     * @return void
     */
      public function addAction()
      {
           $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
           $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
           $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;

           $mod = null;

           // if defined id
           if($id)
           {
               // find product by id
               $product = R::findOne('product', 'id = ?', [$id]);

               if(!$product)
               {
                   return false;
               }

               // if has mod_id , it does mean user choiced modification
               if($mod_id)
               {
                    // find current modification
                    $mod = R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
               }

           }

            // Add to cart
            $cart = new Cart();
            $cart->addToCart($product, $qty, $mod);

            // if request is ajax
             if($this->isAjax())
             {
                // we'll show modal windows [ Модальное Окно ]
                $this->loadView('cart_modal');
             }
             // otherwise we'll send user to where he's from
             redirect();
      }


      /**
       * Action Show [ Show Modal windows / Модальное окно ]
       *
       * @return void
      */
      public function showAction()
      {
         $this->loadView('cart_modal');
      }


    /**
     *  Action Delete [ Delete produit ordered ]
     *
     *
     * @return void
     */
      public function deleteAction()
      {
            $id = !empty($_GET['id']) ? $_GET['id'] : null;

            if(isset($_SESSION['cart'][$id]))
            {
                $cart = new Cart();
                $cart->deleteItem($id);
            }

            if($this->isAjax())
            {
                $this->loadView('cart_modal');
            }
            redirect();
      }


    /**
     * Action clear [ Clear all data from $_SESSION ]
     *
     * @return void
     */
    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $this->loadView('cart_modal');
    }


    /**
     * View
     *
     *  URL: http://eshop.loc/cart/view
     *
     * @return void
     */
    public function viewAction()
    {
        $this->setMeta('Корзина');
    }


    /**
     * Action checkout
     *
     *  URL: http://eshop.loc/cart/checkout
     * @return void
     */
    public function checkoutAction()
    {
        if(!empty($_POST))
        {
            // if user not authenticate or not registreted
            if(!User::checkAuth())
            {
                // we'll registrate user
                $user = new User();
                $data = $_POST;

                // load data from POST
                $user->load($data);

                // validation
                if(!$user->validate($data) || !$user->checkUnique())
                {
                    $user->getErrors();
                    $_SESSION['form_data'] = $data;
                    redirect();

                }else{

                    $user->attributes['password'] = password_hash(
                        $user->attributes['password'],
                        PASSWORD_DEFAULT
                    );

                    if(!$user_id = $user->save('user'))
                    {
                        $_SESSION['error'] = 'Ошибка!';
                        redirect();
                    }

                }
            }

            // save order into database [ сохранение заказа ] and send mail
            $data['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
            $data['note'] = !empty($_POST['note']) ? $_POST['note'] : '';
            $user_email   = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['email'];
            $order_id = Order::saveOrder($data);
            Order::mailOrder($order_id, $user_email);
        }
        redirect();
    }
}