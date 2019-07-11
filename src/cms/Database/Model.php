<?php
namespace Framework\Database;


use Valitron\Validator;
use R;


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
    // public $table;


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


    /**
     * Update data
     *
     * @param $table
     * @param $id
     * @return int|string
     */
    public function update($table, $id)
    {
        $bean = R::load($table, $id);

        foreach($this->attributes as $name => $value)
        {
            $bean->{$name} = $value;
        }
        return R::store($bean);
    }

    /**
     * Validate data
     *
     * @return bool
     */
    public function validate($data)
    {
         // set Lang Directory
         Validator::langDir(WWW.'/validator/lang');

         // set current language
         Validator::lang('ru');

         // set new instance of validator
         $validator = new Validator($data);

         // set rules
         $validator->rules($this->rules);

         // is valid rules
         if($validator->validate())
         {
             return true;
         }

         // get errors
         $this->errors = $validator->errors();
         return false;
    }


    /**
     * Save data in to database
     *
     * @param string $table
     * @return bool|int [ return lastInsertId or false if not saved data ]
     */
    public function save($table)
    {
       $tbl = R::dispense($table);
       foreach ($this->attributes as $name => $value)
       {
           $tbl->$name = $value;
       }

       return R::store($tbl);
    }


    /**
     * Get Errors HTML
     *
     * @return void
     */
    public function getErrors()
    {
        $errors = '<ul>';
        foreach($this->errors as $error)
        {
            foreach ($error as $item)
            {
                $errors .= sprintf('<li>%s</li>', $item);
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }


}