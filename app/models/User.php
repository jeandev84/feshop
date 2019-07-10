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
}