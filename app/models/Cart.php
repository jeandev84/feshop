<?php
namespace app\models;



use Framework\App;

/**
 * Class Cart
 *
 * @package app\models
 *

*
* Array
* (
 *
* [1] => Array (
 *
* [qty] => QTY, [1]
      * [name] => NAME,
      * [price] => PRICE, [70]
      * [img]   => IMG
   * ),
   * [1] => Array (
 *
* [qty] => QTY, [3]
      * [name] => NAME,
      * [price] => PRICE, [ 55]
      * [img]   => IMG
   * ),
   * [qty] => QTY ( 1 + 3),
   * [sum] => SUM  (1 * 70 + 3 * 55)
 *
* )
 */
class Cart extends AppModel
{

    /**
     * Add to cart
     *
     * @param $product
     * @param int $qty
     * @param null $mod [ modification]
     */
     public function addToCart($product, $qty = 1, $mod = null)
     {
          // if has not cart currency
          if(!isset($_SESSION['cart.currency']))
          {
              $_SESSION['cart.currency'] = App::$app->get('currency');
          }

          // if has modification
          if($mod)
          {
              $ID = sprintf('%s-%s', $product->id, $mod->id);
              $title = sprintf('%s (%s)', $product->title, $mod->title);
              $price = $mod->price;

          }else{ // otherwise

              $ID = $product->id;
              $title = $product->title;
              $price = $product->price;

          }

          /*
          debug($_SESSION);
          debug($ID);
          debug($title);
          debug($price);
          */

          if(isset($_SESSION['cart'][$ID]))
          {
               // incremenet la quantite
              $_SESSION['cart'][$ID]['qty'] += $qty;

          }else{
              // on cree un nouveau tableau de donnees
              $_SESSION['cart'][$ID] = [
                  'qty'   => $qty,
                  'title' => $title,
                  'alias' => $product->alias,
                  'price' => $this->convertPrice($price),
                  'img'   => $product->img
              ];
          }

          // Add quantity
          $this->addQantity($qty);

          // Add sum
          $this->addPrice($qty, $price);
     }


    /**
     * Delete Item
     *
     * @param int $id
     * @return void
     */
    public function deleteItem($id)
    {
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }


    /**
     * Convertor Price [ Calcul price with course ]
     * Il calcul le prix avec la valeur de la monaie d'echange
     *
     * @param $curr
     * @return void
     */
    public static function recalc($curr)
    {
        if(isset($_SESSION['cart.currency']))
        {
            // change sum [ Price ]
            if($_SESSION['cart.currency']['base'])
            {
                $_SESSION['cart.sum'] *= $curr->value;
            }else{
                $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $curr->value;
            }

            // change price each product
            foreach($_SESSION['cart'] as $k => $v)
            {
                if($_SESSION['cart.currency']['base'])
                {
                    $_SESSION['cart'][$k]['price'] *= $curr->value;
                }else{
                    $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] / $_SESSION['cart.currency']['value'] * $curr->value;
                }
            }

            // Rewrite new value course in session [ Перезаписать валюты в сессии ]
            foreach($curr as $k => $v)
            {
                $_SESSION['cart.currency'][$k] = $v;
            }
        }
    }


    /**
      * Add quantity product to session
      *
      * @param $qty
      * @return void
     */
     protected function addQantity($qty)
     {
         if(isset($_SESSION['cart.qty']))
         {
             $_SESSION['cart.qty'] += $qty;
         }else{
             $_SESSION['cart.qty'] = $qty;
         }
     }


     /**
     * Add sum price to session
     *
     * @param $qty
     * @param $price
     * @return void
     */
     protected function addPrice($qty, $price)
     {
        if(isset($_SESSION['cart.sum']))
        {
            $_SESSION['cart.sum'] += $qty * $this->convertPrice($price);

        }else{

            $_SESSION['cart.sum'] = $qty * $this->convertPrice($price);
        }
     }


    /**
     * Convert price to currency value
     *
     * @param $price
     * @return int
     */
     protected function convertPrice($price)
     {
         return $price * $_SESSION['cart.currency']['value'];
     }
}