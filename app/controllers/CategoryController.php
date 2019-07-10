<?php
namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Category;
use Exception;
use Framework\App;
use Framework\Library\Pagination;
use R;

/**
 * Class CategoryController
 *
 * @package app\controllers
 *
 *    http://eshop.loc/category/casio?page=2&sort=name&filter=1,2,3
 *
 *    unset page
     Framework\Library\Pagination Object
    (
        [currentPage] => 2
        [perpage] => 3
        [total] => 20
        [countPages] => 7
        [uri] => /category/casio?sort=name&filter=1,2,3&
    )

 */
class CategoryController extends AppController
{

    /**
     * Action view
     *
     *  Demo:
     *   $category_model = new Category();
     *   echo $ids = $category_model->getIds($category->id);
     *   debug(App::$app->get('categories'), true);
     *
     *
     * @return void
     * @throws Exception
     */
     public function viewAction()
     {
         // Get alias
         $alias = $this->route['alias'];

         // find categories by alias
         $category = R::findOne('category', 'alias = ?', [$alias]);

         // if not found category
         if(!$category)
         {
             throw new Exception('Страница не найдена', 404);
         }


         // Breadcrumbs [ Хлебные крошки ]
         $breadcrumbs =  Breadcrumbs::getBreadcrumbs($category->id);


         // Get all categories Получить все вложеные категории
         $category_model = new Category();
         $ids = $category_model->getIds($category->id);

         // if is null ids then we'll give him current category id
         $ids = !$ids ? $category->id : $ids . $category->id;

         //--- Pagination
         $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
         $perpage = App::$app->get('perpage');
         $total = R::count('product', "category_id IN ($ids)");
         $pagination = new Pagination($page, $perpage, $total);
         $start = $pagination->getStart();


         // Get products
         $products = R::find('product', "category_id IN ($ids) LIMIT $start, $perpage");

         /* debug($products); */

         $this->setMeta($category->title, $category->description, $category->keywords);

         // Parse data to view
         $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
     }
}