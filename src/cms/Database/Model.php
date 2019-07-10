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

    /**
     * Assign attributes value
     *
     * Ex:
     *  $data = $_POST
     *
     * if(isset($data['name'])) {
     *    $this->attributes['name'] = $data['name'];
     * }
     * @param $data
     *
     */
    public function load($data)
    {
        foreach($this->attributes as $name => $value)
        {
            if(isset($data[$name]))
            {
                $this->attributes[$name] = $data[$name];
            }
        }
    }
}