<?php
namespace app\controllers\admin;


use app\models\AppModel;
use app\models\Category;
use Framework\App;
use R;


/**
 * Class CategoryController
 *
 * @package app\controllers\admin
 */
class CategoryController extends AppController
{
    /**
     * Action index
     *
     * @return void
     */
    public function indexAction()
    {
        $this->setMeta('Список категорий');
    }


    /**
     * Action delete
     *
     *
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id = $this->getRequestID();
        $children = R::count('category', 'parent_id = ?', [$id]);
        $errors = '';

        // if category has childs we'll don't delete this
        if($children)
        {
            $errors .= '<li>Удаление невозможно, в категории есть вложенные категории</li>';
        }

        $products = R::count('product', 'category_id = ?', [$id]);

        if($products)
        {
            $errors .= '<li>Удаление невозможно, в категории есть товары</li>';
        }

        if($errors)
        {
            $_SESSION['error'] = "<ul>$errors</ul>";
            redirect();
        }

        // delete category
        $category = R::load('category', $id);
        R::trash($category);

        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }


    /**
     * Action add
     *
     * @return void
     */
    public function addAction()
    {
        if(!empty($_POST))
        {
            $category = new Category();
            $data = $_POST;
            $category->load($data);

            if(!$category->validate($data))
            {
                $category->getErrors();
                redirect();
            }

            if($id = $category->save('category'))
            {

                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $cat = R::load('category', $id);
                $cat->alias = $alias;
                R::store($cat);
                $_SESSION['success'] = 'Категория добавлена';
            }
            redirect();
        }
        $this->setMeta('Новая категория');
    }


    /**
     * Action edit
     *
     *
     * @throws \Exception
     */
    public function editAction()
    {
        if(!empty($_POST))
        {
            $id = $this->getRequestID(false);
            $category = new Category();
            $data = $_POST;
            $category->load($data);

            if(!$category->validate($data))
            {
                $category->getErrors();
                redirect();
            }

            if($category->update('category', $id))
            {
                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $category = R::load('category', $id);
                $category->alias = $alias;
                R::store($category);
                $_SESSION['success'] = 'Изменения сохранены';
            }
            redirect();
        }

        $id = $this->getRequestID();
        $category = R::load('category', $id);
        App::$app->set('parent_id', $category->parent_id);
        $this->setMeta("Редактирование категории {$category->title}");
        $this->set(compact('category'));
    }
}