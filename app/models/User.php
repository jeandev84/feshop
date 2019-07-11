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
     * Check Unique fields
     *
     *
     * @return bool
     */
     public function checkUnique()
     {
         $user = \R::findOne('user', 'login = ? OR email = ?', [
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

     /**
      * Login User
      *
      *
      * @param bool $isAdmin
      * @return bool
     */
     public function login($isAdmin = false)
     {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if($login && $password)
        {
            if($isAdmin)
            {
                $user = \R::findOne('user', "login = ? AND role = 'admin'", [$login]);
            }else{
                $user = \R::findOne('user', "login = ?", [$login]);
            }

            if($user)
            {
                if(password_verify($password, $user->password))
                {
                    foreach($user as $k => $v)
                    {
                        // keep [ password ] put all attributes without 'password'
                        if($k != 'password'){ $_SESSION['user'][$k] = $v; }
                    }
                    return true;
                }
            }
        }
        return false;
     }


    /**
     * Determine if user authenticate [ is logged ]
     *
     * @return bool
     */
    public static function checkAuth()
    {
        return isset($_SESSION['user']);
    }



    /**
     * Determine if current user is admin
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }
}