<?php
namespace app\controllers;



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

               // debug($mod);
           }

//           die;
      }
}