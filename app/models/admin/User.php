<?php
namespace app\models\admin;


/**
 * Class User
 *
 * @package app\models\admin
 */
class User extends \app\models\User
{

    /**
     * @var array $attributes
     */
    public $attributes = [
        'id' => '',
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
        'role' => '',
    ];

    /**
     * @var array $rules
     */
    public $rules = [
        'required' => [
            ['login'],
            ['name'],
            ['email'],
            ['role'],
        ],
        'email' => [
            ['email'],
        ],
    ];

    /**
     * @return bool
     */
    public function checkUnique()
    {
        # id [ From input hidden form ]
        $user = \R::findOne('user', '(login = ? OR email = ?) AND id <> ?',
            [$this->attributes['login'], $this->attributes['email'], $this->attributes['id']]
        );
        if($user){
            if($user->login == $this->attributes['login']){
                $this->errors['unique'][] = 'Этот логин уже занят';
            }
            if($user->email == $this->attributes['email']){
                $this->errors['unique'][] = 'Этот email уже занят';
            }
            return false;
        }
        return true;
    }

}