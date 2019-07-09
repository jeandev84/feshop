<?php
namespace app\controllers;



use Framework\App;
use Framework\Library\Cache;
use Exception;
use R;



/**
 * Class ProductController
 *
 * @package app\controllers
 */
class ProductController extends AppController
{


    /**
     * Action view [ Show concret product ]
     *
     * @return void
     * @throws Exception
     */
    public function viewAction()
    {
        // Get alias
        $alias = $this->route['alias'];


        // Get product by alias where status = 1
        $product = R::findOne('product', "alias = ? AND status = '1'", [$alias]);


        // If has not product , we'll get Error message
        if(!$product)
        {
            throw new Exception('Страница не найдена', 404);
        }


        // Get Breadcrumbs   [ Хлебные крошки ]


        // Get Related products   [ Связанные товары ]
        $sql = 'SELECT * 
                FROM related_product 
                JOIN product ON product.id = related_product.related_id
                WHERE related_product.product_id = ?';

        $related = R::getAll($sql, [$product->id]);  /* debug($related); */

        // Save current product in cookie [ Запись в куки запрошенного товара ]


        // Get all viewed products from cookie [ Просмотренные товары ]


        // Get Gallery images [ Галерея ]
        $galleries = R::findAll('gallery', 'product_id = ?', [$product->id]);

        // Modification product [ Модификации ]


        // Set meta data
        $this->setMeta($product->title, $product->description, $product->keywords);

        // Parse data to view
        $this->set(compact('product', 'related', 'galleries'));
    }
}