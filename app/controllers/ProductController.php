<?php
namespace app\controllers;



use app\models\Breadcrumbs;
use app\models\Product;
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
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);


        // Get Related products   [ Связанные товары ]
        $sql = 'SELECT * 
                FROM related_product 
                JOIN product ON product.id = related_product.related_id
                WHERE related_product.product_id = ?';

        $related = R::getAll($sql, [$product->id]);  /* debug($related); */

        // Save current product in cookie [ Запись в куки запрошенного товара ]
        $product_model = new Product();
        $product_model->setRecentlyViewed($product->id);


        // Get all viewed products from cookie [ Просмотренные товары ]
        $r_viewed = $product_model->getRecentlyViewed();
        $recentlyViewed = null;
        if($r_viewed)
        {
            // R::genSlots($v_viewed)  => implode($r_viewed)
            $recentlyViewed = R::find('product', 'id IN ('. R::genSlots($r_viewed) .') LIMIT 3', $r_viewed);
        }


        // Get Gallery images [ Галерея ]
        $galleries = R::findAll('gallery', 'product_id = ?', [$product->id]);


        // Modification product [ Модификации ]


        // Set meta data
        $this->setMeta($product->title, $product->description, $product->keywords);

        // Parse data to view
        $this->set(compact('product', 'related', 'galleries', 'recentlyViewed', 'breadcrumbs'));
    }
}