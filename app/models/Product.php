<?php
namespace app\models;


/**
 * Class Product
 *
 * @package app\models
 */
class Product extends AppModel
{

     /**
      * Set Recently Viewed Product
      *
      * @param int $id
     */
     public function setRecentlyViewed($id)
     {
         if(!headers_sent())
         {
             // Try to get recentlyViewed
             $recentlyViewed = $this->getAllRecentyViewed();

             // If empty recently viewed,
             if(!$recentlyViewed)
             {
                 // we'll set id product in cookie
                 setcookie('recentlyViewed', $id, time() + 3600*24, '/');

             }else{

                 // add recentlyViewed product in cookie []
                 $recentlyViewed = explode('.', $recentlyViewed);

                 // if has not id
                 if(!in_array($id, $recentlyViewed))
                 {
                     // we'll add in register recently viewed
                     $recentlyViewed[] = $id;
                     $recentlyViewed = implode('.', $recentlyViewed);

                     // set recently viewed in cookie [ ne pas afficher quelque chose avant de definir le cookie ]
                     setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
                 }

             }
         }
     }


    /**
     * Get Recently Viewed Product
     *
     *  Ex:
     *  $arr = [2,7,5];
     *  array(
     *   0 => 2,
     *   1 => 7,
     *   2 => 5
     *  ];
     *
     *  $arr_slice = array_slice($arr, -2); => [7,5]
     *  debug($arr_slice)
     *
     *  (
     *     0 => 7,
     *     1 => 5
     *   )
     *
     * @return mixed
     */
    public function getRecentlyViewed()
    {
       if(!empty($_COOKIE['recentlyViewed']))
       {
           $recentlyViewed = $_COOKIE['recentlyViewed'];
           $recentlyViewed = explode('.', $recentlyViewed);

           // on recupere les 3 derniers elements du tableau
           return array_slice($recentlyViewed, -3);
       }
       return false;
    }


    /**
     * Get All viewd product
     */
    public function getAllRecentyViewed()
    {
        if(!empty($_COOKIE['recentlyViewed']))
        {
            return $_COOKIE['recentlyViewed'];
        }
        return false;
    }
}