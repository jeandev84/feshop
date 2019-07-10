<?php
namespace app\controllers;


use R;

/**
 * Class SearchController
 *
 * @package app\controllers
 */
class SearchController extends AppController
{

    /**
     * Action
     *
     * Exemple URL: http://eshop.loc/typeahead?query=casio
     *
     * @return void
     */
    public function typeaheadAction()
    {
        // if request method ajax
        if($this->isAjax())
        {
            // get query from URL
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;

            // if has param
            if($query)
            {
                // get 9 firsts result [js/app.js limit = 10, here we'll limit to 11 ,
                // if in js : limit = 9, here write limit = 10
                $products = R::getAll('SELECT id, title FROM product WHERE title LIKE ? LIMIT 11', ["%{$query}%"]);
                echo json_encode($products);
            }
        }

        die;
    }


    /**
     * Action index
     *
     * Exemple URL: http://eshop.loc/search?s=casio
     *
     * @return void
     */
    public function indexAction()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        if($query)
        {
            $products = \R::find('product', "title LIKE ? AND status = '1'", ["%{$query}%"]);
        }
        $this->setMeta('Поиск по: ' . h($query));
        $this->set(compact('products', 'query'));
    }
}