<?php
namespace app\models;


use Framework\App;

/**
 * Class Category
 *
 * @package app\models
 */
class Category extends  AppModel
{

    /**
     * @var array $attributes
     */
    public $attributes = [
        'title' => '',
        'parent_id' => '',
        'keywords' => '',
        'description' => '',
        'alias' => '',
    ];

    /**
     * @var array $rules
     */
    public $rules = [
        'required' => [
            ['title'],
        ]
    ];


    /**
     * Get Id category
     *
     *  Ex: 4,6,7,5,8,9,10,
     *
     * @param int $id
     * @return string
     */
     public function getIds($id)
     {
           $cats = App::$app->get('categories');

           $ids = null;
           foreach ($cats as $k => $v)
           {
                // compare if parent_id == id
               if($v['parent_id'] == $id)
               {
                   $ids .= $k . ',';
                   $ids .= $this->getIds($k);
               }

           }

           return $ids;
     }
}