<?php
namespace app\models\admin;

use app\models\AppModel;


/**
 * Class Currency
 *
 * @package app\models\admin
 */
class Currency extends AppModel
{

    /**
     * @var array $attributes
     */
    public $attributes = [
        'title' => '',
        'code' => '',
        'symbol_left' => '',
        'symbol_right' => '',
        'value' => '',
        'base' => '',
    ];

    /**
     * @var array $rules
     */
    public $rules = [
        'required' => [
            ['title'],
            ['code'],
            ['value'],
        ],
        'numeric' => [
            ['value'],
        ],
    ];

}