<?php
namespace app\models;


/**
 * Class User
 *
 * @package app\models
 */
class User extends AppModel
{

    /**
     * @var array $attributes [ Fillable Attributes ]
     */
     public $attributes = [
         'login'    => '',
         'password' => '',
         'name'     => '',
         'email'    => '',
         'address'  => '',
         // 'role'     => 'user'
     ];


     /**
      * @var array $rules [ Validation rules ]
      */
     public $rules = [
         'required' => [
             ['login'],
             ['password'],
             ['name'],
             ['email'],
             ['address'],
         ],
         'email' => [
             ['email'],
         ],
         'lengthMin' => [
             ['password', 6],
         ]
     ];

    /**
     * @var string $table [ Table name ]
     */
     public $table = 'user';


    /**
     * Check Unique fields
     *
     */
     public function checkUnique()
     {
         $user = \R::findOne($this->table, 'login = ? OR email = ?', [
             $this->attributes['login'],
             $this->attributes['email']
         ]);

         if($user)
         {
             if($user->login == $this->attributes['login'])
             {
                 $this->errors['unique'][] = 'Этот логин уже занят';
             }
             if($user->email == $this->attributes['email'])
             {
                 $this->errors['unique'][] = 'Этот email уже занят';
             }
             return false;
         }
         return true;
     }
}