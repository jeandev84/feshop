<?php
namespace app\controllers;


use app\models\Cart;

/**
 * Class CurrencyController
 *
 * @package app\controllers
 */
class CurrencyController extends AppController
{

     /**
      * Action change
      *
      *  URL : '/currency/change?curr=UAH,USD,EUR..
      *@return void
     */
      public function changeAction()
      {
          // Get Asked Currency by User from $_GET params
          $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;

          // If has currency
          if($currency)
          {
              // Try to find this currency from database [ or / Can try to find from registry App->$app->get($currency) ]
              $curr = \R::findOne('currency', 'code = ?', [$currency]);

              // if finded this currency from database
              if(!empty($curr))
              {
                  // we'll save this currency in cookie , 1 week , on all domain '/'
                  setcookie('currency', $currency, time() + 3600*24*7, '/');

                  // convertor price with choiced course
                  // [ si le client choisit de voir le montant commande en Euro, Dollars, ...
                  // alors la methode recalc() fait la convertion de la monaie en cours
                  Cart::recalc($curr);
              }
          }

          // redirect user to URL where he's from
          redirect();
      }
}