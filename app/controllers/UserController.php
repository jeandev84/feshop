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
            $user = new User();
            $data = $_POST;
            $user->load($data);

            debug($user);
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

    }


    /**
     * Action logout
     *
     * @return void
     */
    public function logoutAction()
    {

    }
}