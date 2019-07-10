<?php
namespace Framework\Database;


use Valitron\Validator;

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