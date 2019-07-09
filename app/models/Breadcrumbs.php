<?php
namespace app\models;


use Framework\App;

/**
 * Class Breadcrumbs
 *
 * @package app\models
 */
class Breadcrumbs
{


    /**
     * Get Bread Crumbs
     *
     * @param $category_id
     * @param string $name
     */
    public static function getBreadcrumbs($category_id, $name = '')
    {
        // Get all categories
        $categories = App::$app->get('categories');

        // Build bread crumbs
        $breadcrumbsArray = self::getParts($categories, $category_id);

        /* debug($breadcrumbsArray); */
        $breadcrumbs = sprintf('<li><a href="%s">Главная</a></li>', BASE_URL);

        // if has breadcrumbs array
        if($breadcrumbsArray)
        {
            // populate breadcrumbs array as alias and title
            foreach($breadcrumbsArray as $alias => $title)
            {
                // and concat next link to previous
                $breadcrumbs .= sprintf(
                    '<li><a href="%s">%s</a></li>',
                    BASE_URL.'/category/'. $alias,
                    $title
                );
            }

            // if has name
            if($name)
            {
                $breadcrumbs .= sprintf('<li>%s</li>', $name);
            }

            return $breadcrumbs;
        }
    }


    /**
     * Get parts
     *
     * @param $categories
     * @param $id
     * @return mixed
     */
    public static function getParts($categories, $id)
    {
        // break process if has not $id
       if(!$id) { return false; }

       // populate categories

       $breadcrumbs = [];

       foreach ($categories as $k => $v)
       {
           if(isset($categories[$id]))
           {
               // save alias and title categorie
               $breadcrumbs[$categories[$id]['alias']] = $categories[$id]['title'];

               // save parent id current categorie
               $id = $categories[$id]['parent_id'];
           }else{
               break;
           }
       }

       // on retourne l'inverse du tableau breadcrumbs
       return array_reverse($breadcrumbs, true);
    }
}