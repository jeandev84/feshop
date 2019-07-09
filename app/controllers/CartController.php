<?php
namespace app\controllers;



use app\models\Cart;
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
     * @return void
     */
    public function viewAction()
    {
        $this->setMeta('Корзина');
    }
}