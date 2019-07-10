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
     * URL: /search/typeahead?query=casio
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
}