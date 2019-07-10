<?php
namespace app\controllers;


use app\models\User;

/**
 * Class UserController
 *
 * @package app\controllers
 */
class UserController extends AppController
{

    /**
     * Action signup
     *
     * @return void
     */
    public function signupAction()
    {
        if(!empty($_POST))
        {
            // new instance of user
            $user = new User();

            // storage data $_POST in variable $data
            $data = $_POST;

            // assign user attributes from data $_POST
            $user->load($data);

            // debug($user);

            // if is not valide data
            if(!$user->validate($data) || !$user->checkUnique())
            {
                 // get errors and saved in errors
                $user->getErrors();
                $_SESSION['form_data'] = $data;

            }else{
                // Before save
                $user->attributes['password'] = password_hash(
                    $user->attributes['password'],
                    PASSWORD_DEFAULT
                );

                // save
                if($user->save('user'))
                {
                    $_SESSION['success'] = 'Пользователь зарегистрирован';
                }else{
                    $_SESSION['error'] = 'Ошибка!';
                }
            }
            redirect();
        }

        $this->setMeta('Регистрация');
    }


    /**
     * Action login
     *
     * @return void
     */
    public function loginAction()
    {
        if(!empty($_POST))
        {
            $user = new User();

            // if user login
            if($user->login())
            {
                $_SESSION['success'] = 'Вы успешно авторизованы';

            }else{

                $_SESSION['error'] = 'Логин/пароль введены неверно';

            }
            redirect();
        }
        $this->setMeta('Вход');
    }


    /**
     * Action logout
     *
     * @return void
     */
    public function logoutAction()
    {
        if(isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
        }
        redirect();
    }
}