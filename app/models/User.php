<?php
namespace app\models;


/**
 * Class User
 *
 * @package app\models
 */
class User extends AppModel
{
     public $attributes = [
         'login'    => '',
         'password' => '',
         'name'     => '',
         'email'    => '',
         'address'  => '',
         // 'role'     => 'user'
     ];
}