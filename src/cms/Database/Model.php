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


    public function __construct()
    {
    }
}