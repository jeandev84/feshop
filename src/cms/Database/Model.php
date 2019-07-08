<?php
namespace Framework\Database;


/**
 * Class Model
 *
 * @package Framework\Database
 */
abstract class Model
{
    /**
     * @var array $attributes
     */
    protected $attributes = [];
    public $errors = [];
    public $rules  = [];


    /**
     * Model constructor.
     */
    public function __construct()
    {
        DB::instance();
    }
}