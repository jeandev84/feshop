<?php
namespace app\controllers;


use app\models\Category;
use Exception;
use Framework\App;
use R;

/**
 * Class CategoryController
 *
 * @package app\controllers
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
         $breadcrumbs = '';

         // Get all categories Получить все вложеные категории
         $category_model = new Category();
         $ids = $category_model->getIds($category->id);

         // if is null ids then we'll give him current category id
         $ids = !$ids ? $category->id : $ids . $category->id;

         // Get products
         $products = R::find('product', "category_id IN ($ids)");

         /* debug($products); */

         $this->setMeta($category->title, $category->description, $category->keywords);
         $this->set(compact('products', 'breadcrumbs'));
     }
}